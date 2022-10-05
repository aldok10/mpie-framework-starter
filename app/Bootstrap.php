<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App;

use Mpie\Aop\Scanner;
use Mpie\Aop\ScannerConfig;
use Mpie\Config\Repository;
use Mpie\Database\DBConfig;
use Mpie\Database\Manager;
use Mpie\Di\Context;
use Mpie\Event\EventDispatcher;
use Mpie\Event\ListenerProvider;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;

use function putenv;

class Bootstrap
{
    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public static function boot(bool $enable = false): void
    {
        $container = Context::getContainer();

        register_shutdown_function(function () use ($container) {
            if ($error = error_get_last()) {
                $container->make(Logger::class)->error($error['message'], [
                    'type' => $error['type'],
                    'file' => $error['file'],
                    'line' => $error['line'],
                ]);
            }
        });

        // Initialize environment variables and configurations
        if (file_exists($envFile = base_path('.env'))) {
            $variables = parse_ini_file($envFile, false, INI_SCANNER_RAW);
            foreach ($variables as $key => $value) {
                putenv(sprintf('%s=%s', $key, $value));
            }
        }

        $repository = $container->make(Repository::class);

        $repository->scan(base_path('config'));

        // Initialize scanner if it is enabled
        if ($enable) {
            Scanner::init(new ScannerConfig($repository->get('di.aop')));
        }

        // Initialize bindings
        foreach ($repository->get('di.bindings') as $id => $value) {
            $container->bind($id, $value);
        }

        // Initialize event listeners
        $listenerProvider = $container->make(ListenerProvider::class);
        if (! empty($listeners = $repository->get('listeners', []))) {
            foreach ($listeners as $listener) {
                $listenerProvider->addListener($container->make($listener));
            }
        }

        // Initialize database.
        $database = $repository->get('database');
        $manager  = $container->make(Manager::class);
        $manager->setDefault($database['default']);
        foreach ($database['connections'] as $name => $config) {
            $connector = $config['connector'];
            $options   = $config['options'];
            $manager->addConnector($name, new $connector(new DBConfig($options)));
        }
        $manager->setEventDispatcher($container->make(EventDispatcher::class));
        $manager->bootEloquent();
    }
}
