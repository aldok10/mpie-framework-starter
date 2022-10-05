<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

return [
    'aop'      => [
        'cache'      => true,
        'scanDirs'   => [
            'app',
        ],
        'collectors' => [
            \Mpie\Aop\Collector\AspectCollector::class,
            \Mpie\Aop\Collector\PropertyAnnotationCollector::class,
            \App\Aop\Collector\RouteCollector::class,
            \App\Aop\Collector\ListenerCollector::class,
            \App\Aop\Collector\CommandCollector::class,
        ],
        'runtimeDir' => 'runtime',
    ],
    'bindings' => [
        \Psr\EventDispatcher\EventDispatcherInterface::class       => \Mpie\Event\EventDispatcher::class,
        \Psr\EventDispatcher\ListenerProviderInterface::class      => \Mpie\Event\ListenerProvider::class,
        \Mpie\Http\Server\Contract\RouteDispatcherInterface::class => \Mpie\Http\Server\RouteDispatcher::class,
        \Mpie\Config\Contract\ConfigInterface::class               => \Mpie\Config\Repository::class,
        \Psr\Log\LoggerInterface::class                            => \App\Logger::class,
    ],
];
