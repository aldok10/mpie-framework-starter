<?php

declare(strict_types=1);

// use Mpie\Redis\Connector\BaseConnector;
use Mpie\Redis\Connector\SwoolePoolConnector;

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

return [
    // 'handler' => \Mpie\Session\Handler\FileHandler::class,
    // 'config'  => [
    //     'path'          => __DIR__ . '/../runtime/session',
    //     'gcDivisor'     => 100,
    //     'gcProbability' => 1,
    //     'gcMaxLifetime' => 1440,
    // ],
    'handler' => \Mpie\Session\Handler\RedisHandler::class,
    'config'  => [
        'connector' => SwoolePoolConnector::class,
        'prefix'    => 'PHP_SESS:',
        'host'      => '127.0.0.1',
        'port'      => 6379,
        'expire'    => 3600,
    ],
    // 'handler' => \Mpie\Session\Handler\RedisHandler::class,
    // 'config'  => [
    //     'connector' => BaseConnector::class,
    //     'prefix'    => 'PHP_SESS:',
    //     'host'      => '127.0.0.1',
    //     'port'      => 6379,
    //     'expire'    => 3600,
    // ],
];
