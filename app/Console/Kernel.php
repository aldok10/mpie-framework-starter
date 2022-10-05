<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Console;

use App\Aop\Collector\CommandCollector;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Component\Console\Application;

class Kernel
{
    /**
     * 注册命令.
     *
     * @var array<int, string>
     */
    protected array $commands = [
        \App\Console\Command\ControllerMakeCommand::class,
        \App\Console\Command\MiddlewareMakeCommand::class,
        \App\Console\Command\RouteListCommand::class,
    ];

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function run(): void
    {
        $application = new Application('MpiePHP', 'dev');
        $commands    = array_merge($this->commands, CommandCollector::all());
        foreach ($commands as $command) {
            $application->add(make($command));
        }
        $application->run();
    }
}
