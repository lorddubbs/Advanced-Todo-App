<?php

return [
    'search' => [
            'host' => env('ELASTICSEARCH_HOST', 'localhost'),
            'user' => env('ELASTICSEARCH_USERNAME', ''),
            'password' => env('ELASTICSEARCH_PASSWORD', '')
    ]
];