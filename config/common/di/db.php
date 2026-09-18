<?php

declare(strict_types=1);

use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Mysql\Connection;
use Yiisoft\Db\Mysql\Driver;
use Yiisoft\Db\Mysql\Dsn;

/** @var array $params */

return [
    ConnectionInterface::class => [
        'class' => Connection::class,
        '__construct()' => [
            'driver' => new Driver(
                dsn: new Dsn(
                    host: $params['db']['host'],
                    databaseName: $params['db']['name'],
                    port: (string) $params['db']['port'],
                ),
                username: $params['db']['username'],
                password: $params['db']['password'],
            ),
        ],
    ],
];
