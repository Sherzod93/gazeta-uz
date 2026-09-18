<?php

declare(strict_types=1);

use App\Admin\Auth\AdminCredentials;
use App\Shared\ApplicationParams;

/** @var array $params */

return [
    ApplicationParams::class => [
        '__construct()' => [
            'name' => $params['application']['name'],
            'charset' => $params['application']['charset'],
            'locale' => $params['application']['locale'],
        ],
    ],

    AdminCredentials::class => [
        '__construct()' => [
            'username' => $params['admin']['username'],
            'passwordHash' => $params['admin']['passwordHash'],
        ],
    ],
];
