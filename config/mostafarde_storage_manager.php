<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default_disk' => 'local',
    'directory_names' => [
        'local' => 'rde_storage/',
        'public' => '',
    ],

    'placeholders' => [
        'default' => url(routeOfAdminDashboardGlobalAssets().'images/placeholders/placeholder.jpg'),
    ]
];
