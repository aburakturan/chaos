<?php

namespace App\Models\Traits;

use File;
use Image;

trait GalleryTrait
{
    public $imageUploadPath = '/uploads';
    public $imagePlaceHolder = 'assets/img/placeholder.png';

    public function setGalleryImage($file, $entityId, $name = 'image')
    {
        // First create necessary folders
        $this->createImageFolders($name);

        // Upload images
        return $this->createGalleryImages($entityId, $file, $name);
    }

    public function destroyGalleryImage($name = 'image')
    {
        $fileName = $this->$name;

        if (!is_null($fileName)) {
            foreach ($this->galleryAttributes[$name] as $attribute) {
                $subFolderName = $this->createGallerySubFolderNameBySize($name, (isset($attribute['w']) ? $attribute['w'] : $attribute['maxW']), (isset($attribute['h']) ? $attribute['h'] : $attribute['maxH']));
                $imagePath = $this->getGalleryUploadFolder(true, $name, $subFolderName).DIRECTORY_SEPARATOR.$fileName;

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        }
    }

    public function getGalleryUploadFolder($absolute = true, $name = null, $subfolder = null)
    {
        $path = '';

        if ($absolute === true) {
            $path .= config('filesystems.disks.public.root');
        }

        $path .= $this->imageUploadPath.DIRECTORY_SEPARATOR.$this->modelMeta['name'];

        if (!is_null($name)) {
            $path .= DIRECTORY_SEPARATOR.$name;
        }

        if (!is_null($subfolder)) {
            $path .= DIRECTORY_SEPARATOR.$subfolder;
        }

        return $path;
    }

    public function createImageFolders($name)
    {
        if (!File::exists($this->getGalleryUploadFolder())) {
            File::makeDirectory($this->getGalleryUploadFolder(), 0755, true);
        }

        foreach ($this->galleryAttributes[$name] as $attribute) {
            // Create type > main (example: /page/featured) folder
            if (!File::exists($this->getGalleryUploadFolder(true, $name))) {
                File::makeDirectory($this->getGalleryUploadFolder(true, $name), 0755, true);
            }

            // Create type > main > "wxh" (example: /page/featured/300x300) folders
            $subFolderName = $this->createGallerySubFolderNameBySize($name, (isset($attribute['w']) ? $attribute['w'] : $attribute['maxW']), (isset($attribute['h']) ? $attribute['h'] : $attribute['maxH']));

            if (!File::exists($this->getGalleryUploadFolder(true, $name, $subFolderName))) {
                File::makeDirectory($this->getGalleryUploadFolder(true, $name, $subFolderName), 0755, true);
            }
        }
    }

    public function createGalleryImages($entityId, $file, $name = 'image', $saveGalleryImageToDB = true)
    {
        // If hasn't file, exit
        if (!$file) {
            return;
        }

        // Get file info
        $fileName = $this->galleryImageFileName($file);

        // Resize
        foreach ($this->galleryAttributes[$name] as $attribute) {
            // Response image set as Intervention/Image class
            $image = Image::make($file);

            // Resize or original
            $subFolderName = $this->createGallerySubFolderNameBySize($name, (isset($attribute['w']) ? $attribute['w'] : $attribute['maxW']), (isset($attribute['h']) ? $attribute['h'] : $attribute['maxH']));

            if ((isset($attribute['w']) && isset($attribute['h'])) && (!is_null($attribute['w']) && !is_null($attribute['h']))) {
                // Resize or fit
                $image->fit($attribute['w'], $attribute['h']);
            }

            if ((isset($attribute['maxW']) && isset($attribute['maxH'])) && (!is_null($attribute['maxW']) && !is_null($attribute['maxH']))) {
                // Max resize
                $image->resize($attribute['maxW'], null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->resize(null, $attribute['maxH'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Save
            $image->save($this->getGalleryUploadFolder(true, $name, $subFolderName).DIRECTORY_SEPARATOR.$fileName);
        }

        // Copy-upload image to storage
        if ($saveGalleryImageToDB) {
            $gallery = $this->saveGalleryImageToDB($entityId, $name, $fileName);
        }

        return [
            'name' => $fileName,
            'size' => 'Yüklendi',
            'url' => $this->getGalleryUploadFolder(false, $name, $subFolderName).DIRECTORY_SEPARATOR.$fileName,
            'thumbnailUrl' => $this->getGalleryUploadFolder(false, $name, $subFolderName).DIRECTORY_SEPARATOR.$fileName,
            'deleteUrl' => route('admin.'.str_replace('_gallery', '', $this->modelMeta['name']).'.gallery-hard-delete', ['id' => $gallery->id]),
            'deleteType' => 'DELETE',
        ];
    }

    public function saveGalleryImageToDB($entityId, $name, $fileName)
    {
        $row = new self;
        $row->entity_id = $entityId;
        $row->$name = $fileName;
        $row->save();

        return $row;
    }

    /**
     * Source convert to slug type for more information https://github.com/cocur/slugify
     * @param  string $source
     * @return string
     */
    public function galleryImageNameSlugify($source)
    {
        return str_slug($source, '-', 'tr');
    }

    /**
     * Generate file name with slug
     * @param  \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function galleryImageFileName($file)
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $name = str_replace($extension, '', $name);
        $name = $this->galleryImageNameSlugify($name);

        if ($this->id) {
            return $name.'-'.$this->id.'.'.$extension;
        } else {
            return md5(uniqid()).'.'.$extension;
        }
    }

    public function createGallerySubFolderNameBySize($name, $width = null, $height = null)
    {
        // if (is_null($width) && is_null($height)) {
        //     $width = $this->galleryAttributes[$name][0]['w'];
        //     $height = $this->galleryAttributes[$name][0]['h'];
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

    public function getGalleryPlaceHolder($array)
    {
        if (isset($array['placeholder'])) {
            return asset($array['placeholder']);
        } else {
            return asset($this->imagePlaceHolder);
        }
    }

    public function getGalleryImage($name = 'image', $width = null, $height = null, $checkExists = true)
    {
        if ($checkExists === true && !$this->hasImage($name)) {
            return $this->getGalleryPlaceHolder($this->galleryAttributes[$name]);
        }

        $imagePath = $this->getGalleryUploadFolder(false, $name, $this->createGallerySubFolderNameBySize($name, $width, $height).DIRECTORY_SEPARATOR.$this->$name);

        return asset($imagePath.'?='.md5($this->updated_at));
    }

    public function getGalleryImageByTemplate($template, $name = 'image')
    {
        $search = $this->searchGallerySizeByName($this->galleryAttributes, 'template', $template);

        if (count($search) > 0) {
            if (count($search[0]) > 1) {
                $result = $search[0];

                if (!$this->hasImage($name)) {
                    return $this->getGalleryPlaceHolder($result);
                }

                return $this->getGalleryImage($name, (isset($result['w']) ? $result['w'] : $result['maxW']), (isset($result['h']) ? $result['h'] : $result['maxH']), false);
            }
        }
    }

    public function searchGallerySizeByName($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->searchGallerySizeByName($subarray, $key, $value));
            }
        }

        return $results;
    }
}
