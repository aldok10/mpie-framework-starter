<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http\Controller\Api;

use App\Http\Response;
use App\Model\User;
use Mpie\Routing\Annotation\Controller;
use Mpie\Routing\Annotation\DeleteMapping;
use Mpie\Routing\Annotation\GetMapping;
use Mpie\Routing\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoole\Coroutine\WaitGroup;

#[Controller(prefix: '/test-api-controller')]
class TestApiControllerController
{
    #[GetMapping(path: '/')]
    public static function index(ServerRequestInterface $request): ResponseInterface
    {
        $data = [];

        for ($i=0; $i < 10; $i++) { 
            $data[] = User::all();
        }
        
        return Response::json([
            'test-api' => true,
            'query'    => $request->getQueryParams(),
            'body'     => $request->getBody(),
            'user'     => $data,
        ]);
    }

    #[GetMapping(path: '/<id>')]
    public function show(ServerRequestInterface $request, $id): ResponseInterface
    {
        return Response::json(null);
    }

    #[DeleteMapping(path: '/<id>')]
    public function delete(ServerRequestInterface $request, $id): ResponseInterface
    {
        return Response::json(null);
    }

    #[RequestMapping(path: '/<id>', methods: ['PUT', 'PATCH'])]
    public function update(ServerRequestInterface $request, $id): ResponseInterface
    {
        return Response::json(null);
    }
}
