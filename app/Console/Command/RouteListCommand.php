<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Console\Command;

use App\Http\Kernel;
use Closure;
use Mpie\Di\Exception\NotFoundException;
use Mpie\Routing\Route;
use Mpie\Utils\Collection;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class RouteListCommand extends Command
{
    /**
     * @return int
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table(new ConsoleOutput());

        $table->setHeaders(['Methods', 'URI', 'Action', 'Middlewares']);

        /** @var Route $route */
        foreach ($this->getRoutes() as $route) {
            $table->addRow([
                implode('|', $route->getMethods()),
                $route->getPath(),
                $this->formatRouteAction($route),
                implode(PHP_EOL, $route->getMiddlewares()),
            ]);
        }

        $table->render();

        return 0;
    }

    protected function configure()
    {
        $this->setName('route:list')
            ->setDescription('List all routes');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws ReflectionException
     */
    protected function getRoutes(): Collection
    {
        $kernel         = make(Kernel::class);
        $routes         = [];
        foreach ($kernel->getAllRoutes() as $registeredRoute) {
            foreach ($registeredRoute as $route) {
                if (! in_array($route, $routes)) {
                    $routes[] = $route;
                }
            }
        }
        return Collection::make($routes)->unique();
    }

    /**
     * Format action as string.
     */
    protected function formatRouteAction(Route $route): string
    {
        $action = $route->getAction();
        if ($action instanceof Closure) {
            return 'Closure';
        }
        if (is_array($action)) {
            return implode('@', $action);
        }
        return $action;
    }
}
