<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Storage;
use Image;

trait ImageTrait
{
    public $imageUploadPath = '/uploads';
    public $imagePlaceHolder = 'assets/img/placeholder.png';

    public function setImage($request, $name = 'image')
    {
        // First create necessary folders
        $this->createImageFolders($name);

        // Upload images
        $this->createImages($request, $name);
    }

    public function destroyImage($name = 'image')
    {
        $fileName = $this->$name;

        if (!is_null($fileName)) {
            foreach ($this->imageAttributes[$name] as $attribute) {
                $subFolderName = $this->createSubFolderNameBySize($attribute['w'], $attribute['h']);
                $imagePath = $this->getImageUploadFolder($name, $subFolderName).'/'.$fileName;

                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $this->removeImageFromDB($name);
        }
    }

    public function getImageUploadFolder($name = null, $subfolder = null)
    {
        $path = '';

        $path .= $this->imageUploadPath.'/'.$this->modelMeta['name'];

        if (!is_null($name)) {
            $path .= '/'.$name;
        }

        if (!is_null($subfolder)) {
            $path .= '/'.$subfolder;
        }

        return $path;
    }

    public function createImageFolders($name)
    {
        // if (!Storage::exists($this->getImageUploadFolder())) {
        //     Storage::makeDirectory($this->getImageUploadFolder());
        // }

        foreach ($this->imageAttributes[$name] as $attribute) {
            // Create type > main (example: /page/featured) folder
            if (!Storage::exists($this->getImageUploadFolder($name))) {
                Storage::makeDirectory($this->getImageUploadFolder($name));
            }

            // Create type > main > "wxh" (example: /page/featured/300x300) folders
            $subFolderName = $this->createSubFolderNameBySize($attribute['w'], $attribute['h']);

            if (!Storage::exists($this->getImageUploadFolder($name, $subFolderName))) {
                Storage::makeDirectory($this->getImageUploadFolder($name, $subFolderName));
            }
        }
    }

    public function createImages($request, $name = 'image', $saveImageToDB = true)
    {
        if (is_array($request)) {
            // If is string (url) get content and create $file
            $file = $request['file'];
            $fileName = $request['fileName'];

            // Get crop values
            $imageX = (isset($request['x']) ? round($request['x']) : 0);
            $imageY = (isset($request['y']) ? round($request['y']) : 0);
            $imageW = (isset($request['w']) ? round($request['w']) : 0);
            $imageH = (isset($request['h']) ? round($request['h']) : 0);
        } else {
            // If hasn't file, exit
            if (!$request->hasFile($name)) {
                return;
            }

            // Get file info
            $file = $request->file($name);
            $fileName = $this->imageFileName($file);

            // Get crop values
            $imageX = round($request->input($name.'_x'));
            $imageY = round($request->input($name.'_y'));
            $imageW = round($request->input($name.'_w'));
            $imageH = round($request->input($name.'_h'));
        }

        $subFolderName = null;

        // Resize
        foreach ($this->imageAttributes[$name] as $attribute) {
            // Response image set as Intervention/Image class
            $image = Image::make($file);

            // Resize or original
            $subFolderName = $this->createSubFolderNameBySize($attribute['w'], $attribute['h']);

            if (!is_null($attribute['w']) && !is_null($attribute['h'])) {
                // Crop
                if ($imageX || $imageY || $imageW || $imageH) {
                    $image->crop($imageW, $imageH, $imageX, $imageY);
                }

                // Resize or fit
                $image->fit($attribute['w'], $attribute['h']);
            }

            // Save
            Storage::put($this->getImageUploadFolder($name, $subFolderName).'/'.$fileName, (string) $image->encode(), 'public');

            // Copy-upload image to storage
            if ($saveImageToDB) {
                $this->saveImageToDB($name, $fileName);
            }
        }

        return [
            'base_path' => Storage::url($this->getImageUploadFolder($name, $subFolderName)),
            'file_name' => $fileName,
            'path' => Storage::url($this->getImageUploadFolder($name, $subFolderName).'/'.$fileName),
        ];
    }

    public function saveImageToDB($name, $fileName)
    {
        $this->$name = $fileName;
        $this->update();
    }

    public function removeImageFromDB($name)
    {
        $this->$name = null;
        $this->update();
    }

    /**
     * Source convert to slug type
     * @param  string $source
     * @return string
     */
    public function imageNameSlugify($source)
    {
        return str_slug($source, '-', 'tr');
    }

    /**
     * Generate file name with slug
     * @param  UploadedFile $file
     * @return string
     */
    public function imageFileName($file)
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $name = str_replace($extension, '', $name);
        $name = $this->imageNameSlugify($name);

        if ($this->id) {
            return $name.'-'.$this->id.'.'.$extension;
        } else {
            return md5(uniqid()).'.'.$extension;
        }
    }

    public function createSubFolderNameBySize($width = null, $height = null)
    {
        // if (is_null($width) && is_null($height)) {
        //     $width = $this->imageAttributes[$name][0]['w'];
        //     $height = $this->imageAttributes[$name][0]['h'];
        // }

        if (is_null($width) && is_null($height)) {
            $subFolderName = 'original';
        } else {
            $subFolderName = $width.'x'.$height;
        }

        return $subFolderName;
    }

    public function hasImage($name = 'image')
    {
        if (is_null($this->$name)) {
            return false;
        }

        return true;
    }

    public function getImagePlaceHolder($array)
    {
        if (isset($array['placeholder'])) {
            return asset($array['placeholder']);
        } else {
            return asset($this->imagePlaceHolder);
        }
    }

    public function getImage($name = 'image', $width = null, $height = null, $checkExists = true, $absolutePath = true, $updatedAt = true)
    {
        if ($checkExists === true && !$this->hasImage($name)) {
            return $this->getImagePlaceHolder($this->imageAttributes[$name]);
        }

        $imagePath = Storage::url($this->getImageUploadFolder($name, $this->createSubFolderNameBySize($width, $height).'/'.$this->$name));

        $url = $imagePath;

        if ($updatedAt) {
            $url .= '?='.md5($this->updated_at);
        }

        if ($absolutePath) {
            return asset($url);
        }

        return $url;
    }

    public function getImageByTemplate($template, $name = 'image', $absolutePath = true, $updatedAt = true)
    {
        $search = $this->searchImageSizeByName($this->imageAttributes, 'template', $template);

        if (count($search) > 0) {
            if (count($search[0]) > 1) {
                $result = $search[0];

                if (!$this->hasImage($name)) {
                    return $this->getImagePlaceHolder($result);
                }

                return $this->getImage($name, $result['w'], $result['h'], false, $absolutePath, $updatedAt);
            }
        }

        return null;
    }

    public function searchImageSizeByName($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->searchImageSizeByName($subarray, $key, $value));
            }
        }

        return $results;
    }
}
