<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Aop\Annotation;

use Attribute;
use Mpie\Aop\Contract\PropertyAnnotation;
use Mpie\Aop\Exception\PropertyHandleException;
use Mpie\Config\Contract\ConfigInterface;
use Mpie\Di\Reflection;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Config implements PropertyAnnotation
{
    /**
     * @param string $key     Keu
     * @param mixed  $default Defaults
     */
    public function __construct(
        protected string $key,
        protected mixed $default = null
    ) {
    }

    public function handle(object $object, string $property): void
    {
        try {
            $reflectionProperty = Reflection::property($object::class, $property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($object, $this->getConfigValue());
        } catch (Throwable $e) {
            throw new PropertyHandleException('Property assign failed. ' . $e->getMessage());
        }
    }

    /**
     * Get configuration value.
     *
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    protected function getConfigValue()
    {
        return make(ConfigInterface::class)->get($this->key, $this->default);
    }
}
