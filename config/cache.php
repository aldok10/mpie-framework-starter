<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

return [
    'default' => 'file',
    'stores'  => [
        'file'      => [
            'driver' => \Mpie\Cache\Driver\FileDriver::class,
            'config' => [
                'path' => __DIR__ . '/../runtime/cache/app',
            ],
        ],
        'redis'     => [
            'driver' => \Mpie\Cache\Driver\RedisDriver::class,
            'config' => [
                'connector' => \Mpie\Redis\Connector\BaseConnector::class,
                'config'    => [],
            ],
        ],
        'memcached' => [
            'driver' => \Mpie\Cache\Driver\MemcachedDriver::class,
            'config' => [
                'host' => '127.0.0.1',
                'port' => 11211,
            ],
        ],
        'apcu'      => [
            'driver' => \Mpie\Cache\Driver\ApcDriver::class,
            'config' => [],
        ],
    ],
];
