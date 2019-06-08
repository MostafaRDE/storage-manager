<?php

namespace MostafaRDE\StorageManager\Facades;

use Illuminate\Support\Facades\Facade;

class StorageManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mostafa-rde-storage-manager';
    }
}