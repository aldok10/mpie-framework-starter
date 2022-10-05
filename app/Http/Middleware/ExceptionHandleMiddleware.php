<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http\Middleware;

use App\Http\Response;
use Mpie\Http\Server\Contract\Renderable;
use Mpie\Http\Server\Middleware\ExceptionHandleMiddleware as Middleware;
use Mpie\VarDumper\Abort;
use Mpie\VarDumper\AbortHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class ExceptionHandleMiddleware extends Middleware
{
    use AbortHandler;

    public function __construct(
        protected LoggerInterface $logger,
    ) {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    protected function render(Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        if ($this->runningInConsole() && class_exists('NunoMaduro\Collision\Provider')) {
            $provider = make('NunoMaduro\Collision\Provider');
            $handler  = $provider->register()
                ->getHandler()
                ->setOutput(new ConsoleOutput());
            $handler->setInspector(new \Whoops\Exception\Inspector($e));
            $handler->handle();
        }

        return $this->renderHttpResponse($e, $request);
    }

    protected function renderHttpResponse(Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        if ($e instanceof Abort) {
            return Response::HTML($this->convertToHtml($e));
        }
        if ($e instanceof Renderable) {
            return $e->render($request);
        }
        $statusCode = $this->getStatusCode($e);
        if (\App\env('APP_DEBUG')) {
            if (class_exists('Spatie\Ignition\Ignition')) {
                $ignition = new \Spatie\Ignition\Ignition();
                ob_start();
                $ignition->renderException($e);
                return Response::HTML(ob_get_clean(), $statusCode);
            }
            return parent::render($e, $request);
        }
        return Response::text($e->getMessage(), $statusCode);
    }

    protected function report(Throwable $e, ServerRequestInterface $request): void
    {
        $this->logger->error($e->getMessage(), [
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'request' => $request,
            'trace'   => $e->getTrace(),
        ]);
    }
}
