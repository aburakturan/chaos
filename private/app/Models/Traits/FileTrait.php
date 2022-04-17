<?php

namespace App\Models\Traits;

use Hash;
use Illuminate\Support\Facades\URL;
use Storage;

trait FileTrait
{
    public $fileUploadPath = '/uploads';

    public function setFile($request, $name = 'file')
    {
        // First create necessary folders
        $this->createFileFolders($name);

        // Upload files
        $this->createFiles($request, $name);
    }

    public function destroyFile($name = 'file')
    {
        $fileName = $this->$name;

        if (!is_null($fileName)) {
            foreach ($this->fileAttributes[$name] as $attribute) {
                $filePath = $this->getFileUploadFolder($name).'/'.$fileName;

                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }

            $this->removeFileFromDB($name);
        }
    }

    public function getFileUploadFolder($name = null)
    {
        $path = '';

        $path .= $this->fileUploadPath.'/'.$this->modelMeta['name'];

        if (!is_null($name)) {
            $path .= '/'.$name;
        }

        return $path;
    }

    public function createFileFolders($name)
    {
        // if (!Storage::exists($this->getFileUploadFolder())) {
        //     Storage::makeDirectory($this->getFileUploadFolder(), 0755, true);
        // }

        foreach ($this->fileAttributes[$name] as $attribute) {
            // Create type > main (example: /page/featured) folder
            if (!Storage::exists($this->getFileUploadFolder($name))) {
                Storage::makeDirectory($this->getFileUploadFolder($name));
            }
        }
    }

    public function createFiles($request, $name = 'file', $saveFileToDB = true)
    {
        if (is_array($request)) {
            // If is string (url) get content and create $file
            $file = $request['file'];
            $fileName = $request['fileName'];
        } else {
            // If hasn't file, exit
            if (!$request->hasFile($name)) {
                return;
            }

            // Get file info
            $file = $request->file($name);
            $fileName = $this->fileName($file);
        }

        // Resize
        foreach ($this->fileAttributes[$name] as $attribute) {
            // Save
            Storage::putFileAs(
                $this->getFileUploadFolder($name), $file, $fileName,
                [
                    'visibility' => 'public',
                ]
            );

            // Copy-upload file to storage
            if ($saveFileToDB) {
                $this->saveFileToDB($name, $fileName);
            }
        }

        return [
            'base_path' => Storage::url($this->getFileUploadFolder($name)),
            'file_name' => $fileName,
            'path' => Storage::url($this->getFileUploadFolder($name).'/'.$fileName),
        ];
    }

    public function saveFileToDB($name, $fileName)
    {
        if (is_null($this)) {
            return;
        }

        $this->$name = $fileName;
        $this->update();
    }

    public function removeFileFromDB($name)
    {
        if (is_null($this)) {
            return;
        }

        $this->$name = null;
        $this->update();
    }

    /**
     * Source convert to slug type for more information https://github.com/cocur/slugify
     * @param  string $source
     * @return string
     */
    public function fileNameSlugify($source)
    {
        return str_slug($source, '-', 'tr');
    }

    /**
     * Generate file name with slug
     * @param  \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function fileName($file)
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $name = str_replace($extension, '', $name);
        $name = $this->fileNameSlugify($name);

        if ($this->id) {
            return $name.'-'.$this->id.'.'.$extension;
        } else {
            return md5(uniqid()).'.'.$extension;
        }
    }

    public function hasFile($name = 'file')
    {
        if (is_null($this->$name)) {
            return false;
        }

        return true;
    }

    public function getFilePath($name = 'file') {
        return $this->getFileUploadFolder($name.'/'.$this->$name);
    }

    public function getFileDownloadURL($name = 'file') {
        return URL::temporarySignedRoute(
            'web.'.app()->getLocale().'.download', now()->addMinutes(30), [
                'user_id' => auth()->user()->id,
                'id' => $this->id,
                'entity' => base64_encode(get_class($this)),
                'name' => $name,
            ]
        );
    }

    public function getFile($name = 'file')
    {
        return asset($this->getFilePath($name).'?='.md5($this->updated_at));
    }
}
