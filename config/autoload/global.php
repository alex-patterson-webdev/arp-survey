<?php

declare(strict_types=1);

use Arp\Survey\Service\Factory\SessionManagerFactory;
use Laminas\Session\Config\SessionConfig;

return [
    'session_manager' => [
        'config' => [
            'class' => SessionConfig::class,
            'options' => [
                'name' => 'arp_survey',
                'remember_me_seconds' => 600,
                'use_cookies' => true,
                'cookie_httponly' => true,
                'cache_expire' => 10,
            ],
        ],
    ],

    'service_manager' => [
        'factories' => [
            'ArpSessionManager' => SessionManagerFactory::class,
        ]
    ]
];
