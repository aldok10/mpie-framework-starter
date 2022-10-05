<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

use Mpie\Database\Connector\BaseConnector;
use Mpie\Database\DBConfig;

use function App\env;

return [
    'default'     => env('DB_DEFAULT', 'mysql'),
    'connections' => [
        'mysql' => [
            'connector' => BaseConnector::class,
            'options'   => [
                DBConfig::OPTION_DRIVER      => 'mysql',
                DBConfig::OPTION_HOST        => env('DB_HOST', 'localhost'),
                DBConfig::OPTION_USER        => env('DB_USER', 'user'),
                DBConfig::OPTION_UNIX_SOCKET => null,
                DBConfig::OPTION_PASSWORD    => env('DB_PASS', 'pass'),
                DBConfig::OPTION_DB_NAME     => env('DB_NAME', 'name'),
                DBConfig::OPTION_PORT        => env('DB_PORT', 3306),
                DBConfig::OPTION_OPTIONS     => [],
                DBConfig::OPTION_CHARSET     => env('DB_CHARSET', 'utf8mb4'),
                DBConfig::OPTION_POOL_SIZE   => 12,
            ],
        ],
    ],
];
