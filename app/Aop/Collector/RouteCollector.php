<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Aop\Collector;

use Mpie\Aop\Collector\AbstractCollector;
use Mpie\Di\Context;
use Mpie\Di\Exception\NotFoundException;
use Mpie\Routing\Annotation\Controller;
use Mpie\Routing\Annotation\RequestMapping;
use Mpie\Routing\Router;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;

class RouteCollector extends AbstractCollector
{
    /**
     * Get the router corresponding to the current controller with the configuration value.
     */
    protected static ?Router $router = null;

    /**
     * The class name of the current controller.
     */
    protected static string $class = '';

    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public static function collectClass(string $class, object $attribute): void
    {
        if ($attribute instanceof Controller) {
            $routeCollector = Context::getContainer()->make(\Mpie\Routing\RouteCollector::class);
            $router         = new Router($attribute->prefix, $attribute->patterns, middlewares: $attribute->middlewares, routeCollector: $routeCollector);
            self::$router   = $router;
            self::$class    = $class;
        }
    }

    /**
     * @throws NotFoundException
     */
    public static function collectMethod(string $class, string $method, object $attribute): void
    {
        if ($attribute instanceof RequestMapping && self::$class === $class && ! is_null(self::$router)) {
            self::$router->request($attribute->path, [$class, $method], $attribute->methods)->middleware(...$attribute->middlewares);
        }
    }
}
