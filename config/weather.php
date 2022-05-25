<?php
return [
    'qweather' => [
        'app_key' => "",
        'dev_mode' => false,
        'dev' => [
            'api_base_url' => 'https://devapi.qweather.com/v7/',
            'geo_base_url' => 'https://geoapi.qweather.com/v2/',
        ],
        'prod' => [
            'api_base_url' => 'https://api.qweather.com/v7/',
            'geo_base_url' => 'https://geoapi.qweather.com/v2/',
        ]
    ],
    'caiyun' => [
        'app_key' => "",
        'prod' => [
            'api_base_url' => "https://api.caiyunapp.com/v2.6",
        ]
    ]
];
