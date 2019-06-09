<?php

namespace MostafaRDE\StorageManager;

use DateTime;
use Illuminate\Http\UploadedFile;
use MostafaRDE\StorageManager\Models\Storage;
use MostafaRDE\StorageManager\Models\StorageLink;

class StorageManager
{
    public function accidentallyName()
    {
        return round(microtime(true) * 1000);
    }

    public function createPathWithDateTime(DateTime $dateTime, $disk = 'public')
    {
        return config("mostafarde_storage_manager.directory_names.$disk") . $dateTime->format('Y') . '/' . $dateTime->format('m') . '/' . $dateTime->format('d');
    }

    public function getFileOfColumn($links, $callerName, $placeholderKey = 'default')
    {
        if (!is_null($links))
            foreach ($links as $link)
                if ($link->linkable_caller_name === $callerName)
                    return $link;

        return $this->placeholder($placeholderKey);
    }

    public function placeholder($placeholderKey = 'default')
    {
        $placeholders = config('mostafarde_storage_manager.placeholders');

        if (is_array($placeholders))
            return (object)[
                'url' => $placeholders[$placeholderKey]
            ];
        elseif (is_string($placeholders))
            return (object)[
                'url' => $placeholders
            ];

        return null;
    }

    public function uploadMedia(UploadedFile $file, $disk = 'public', $validate = [])
    {
        request()->validate($validate);

        $filename_physical = $this->accidentallyName() . '.' . $file->getClientOriginalExtension();
        $filename_logical = $file->getClientOriginalName();
        $mimetype = $file->getMimeType();

        $now = new DateTime();
        $path_directory = $this->createPathWithDateTime($now, $disk);
        $file->storeAs($path_directory, $filename_physical, $disk);

        $file = new Storage();
        $file->filename_logical = $filename_logical;
        $file->filename_physical = $filename_physical;
        $file->mime_type = $mimetype;
        $file->disk = $disk;
        $file->uploaded_at = now();

        if ($file->save())
            return $file;
        return null;
    }

    public function uploadFileAndCreateLinkable($callerName, UploadedFile $file, $disk = 'public', $validate = [])
    {
        $file = $this->uploadMedia($file, $disk, $validate);

        $linkable = new StorageLink();
        $linkable->storage_id = $file->id;
        $linkable->linkable_caller_name = $callerName;

        return $linkable;
    }
}