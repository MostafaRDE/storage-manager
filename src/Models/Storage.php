<?php

namespace MostafaRDE\StorageManager\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage as StorageFacade;

class Storage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "storage";

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /*
     * Accessors and Mutators
     */
    public function getUrlAttribute()
    {
        $path = $this->getUrlDatePart($this->uploaded_at);
        if (!is_null($path))
        {
            $path = config("mostafarde_storage_manager.directory_names.$this->disk").$path;
            return url($this->disk === 'public' ? "storage/$path" : $path);
        }
        return null;
    }

    public function getUrlLocalAttribute()
    {
        $path = $this->getUrlDatePart($this->uploaded_at);
        if (!is_null($path))
        {
            $path = config("mostafarde_storage_manager.directory_names.$this->disk").$path;
            return $this->disk === 'public' ? "public/$path" : $path;
        }
        return null;
    }

    /*
     * Special methods
     */
    public function getUrlDatePart()
    {
        if (!is_null($this->uploaded_at))
        {
            $date = explode(" ", $this->uploaded_at);
            $date = explode("-", $date[0]);
            return config("mostafa_rde_storage_manager.directory_names.$this->disk") . $date[0] . '/' . $date[1] . '/' . $date[2] . '/' . $this->filename_physical;
        }
        return null;
    }

    /*
     * Methods
     */
    public function getFile($filename = null, $headers = [])
    {
        return StorageFacade::download($this->url_local, $filename ?: $this->filename_logical, $headers);
    }

    public function showFile($headers = [])
    {
        foreach ($headers as $key => $value)
            header("$key: $value");
        readfile(realpath(storage_path("app/{$this->url_local}")));
    }

    public function showFileAsImage($headers = [])
    {
        header("Content-Type: $this->mime_type");
        readfile(realpath(storage_path("app/{$this->url_local}")));
    }
}