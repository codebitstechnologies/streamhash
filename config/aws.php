<?php

use Aws\Laravel\AwsServiceProvider;

return [
    'credentials' => [
        'key'    => "",
        'secret' => "",
    ],
    'region' => 'us-west-2',
    'version' => 'latest',

    // You can override settings for specific services
    'Ses' => [
        'region' => 'us-west-2',
    ],
];

