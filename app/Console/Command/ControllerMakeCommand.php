<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Console\Command;

use Mpie\Utils\Exception\FileNotFoundException;
use Mpie\Utils\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function App\base_path;

class ControllerMakeCommand extends Command
{
    protected string $stubsPath = __DIR__ . '/stubs/';

    protected function configure()
    {
        $this->setName('make:controller')
            ->setDescription('Create a new controller')
            ->setDefinition([
                new InputArgument('controller', InputArgument::REQUIRED, 'A controller name such as `user`.'),
                new InputOption('rest', 'r', InputOption::VALUE_OPTIONAL, 'Make a restful controller.'),
            ]);
    }

    /**
     * @return int
     * @throws FileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem               = new Filesystem();
        $controller               = $input->getArgument('controller');
        $stubFile                 = $this->stubsPath . ($input->hasOption('rest') ? 'controller_rest.stub' : 'controller.stub');
        [$namespace, $controller] = $this->parse($controller);
        $controllerPath           = base_path('app/Http/Controller/' . str_replace('\\', '/', $namespace) . '/');
        $controllerFile           = $controllerPath . $controller . 'Controller.php';
        if ($filesystem->exists($controllerFile)) {
            $output->writeln('<comment>[WARN]</comment> Controller already exists!');
            return 1;
        }
        $filesystem->exists($controllerPath) || $filesystem->makeDirectory($controllerPath, 0777, true);
        $filesystem->put($controllerFile, str_replace(['{{namespace}}', '{{class}}', '{{path}}'], ['App\\Http\\Controller' . $namespace, $controller . 'Controller', strtolower($controller)], $filesystem->get($stubFile)));
        $output->writeln("<info>[INFO]</info> Controller: App\\Http\\Controller{$namespace}\\{$controller}Controller created successfully!");

        return 1;
    }

    protected function parse($input): array
    {
        $array     = explode('/', $input);
        $class     = ucfirst(array_pop($array));
        $namespace = implode('\\', array_map(fn ($value) => ucfirst($value), $array));
        if (! empty($namespace)) {
            $namespace = '\\' . $namespace;
        }
        return [$namespace, $class];
    }
}
