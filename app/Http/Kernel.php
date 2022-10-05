<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http;

use Mpie\Http\Message\Request;
use Mpie\Http\Server\Kernel as HttpKernel;
use Mpie\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

class Kernel extends HttpKernel
{
    /**
     * Global middleware.
     */
    protected array $middlewares = [
        \App\Http\Middleware\ExceptionHandleMiddleware::class,
        \App\Http\Middleware\AllowCrossDomain::class,
        \Mpie\Http\Server\Middleware\RoutingMiddleware::class,
    ];

    /**
     * Web middlewares.
     */
    protected array $webMiddlewares = [
        \Mpie\Http\Server\Middleware\SessionMiddleware::class,
        \App\Http\Middleware\VerifyCSRFToken::class,
    ];

    /**
     * Api middlewares.
     */
    protected array $apiMiddlewares = [
        \App\Http\Middleware\ParseBodyMiddleware::class,
    ];

    /**
     * Register routes.
     */
    protected function map(Router $router): void
    {
        $router->middleware(...$this->webMiddlewares)
            ->group(function (Router $router) {
                $router->request('/', [\App\Http\Controller\IndexController::class, 'index']);
            });
        $router->middleware(...$this->apiMiddlewares)
            ->prefix('api')
            ->group(function (Router $router) {
                $router->get('/', function (ServerRequestInterface|Request $request) {
                    return Response::JSON([
                        'statue'  => true,
                        'code'    => 0,
                        'message' => sprintf('Hello, %s.', $request->query('name', 'world')),
                        'data'    => [],
                    ]);
                });
            });
    }
}
