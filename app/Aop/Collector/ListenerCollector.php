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
use Mpie\Event\Annotation\Listen;
use Mpie\Event\ListenerProvider;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;

class ListenerCollector extends AbstractCollector
{
    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     */
    public static function collectClass(string $class, object $attribute): void
    {
        if ($attribute instanceof Listen) {
            make(ListenerProvider::class)->addListener(make($class));
        }
    }
}
