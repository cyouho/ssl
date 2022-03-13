<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API URLs
    |--------------------------------------------------------------------------
    |
    | These array of value are shown for api urls.
    |
    */

    'api_urls' => [
        'user_data_select_url' => env('APP_URL') . '/users/servers/',
        'user_data_create_url' => env('APP_URL') . '/users/servers/{userId}'
    ],

];
