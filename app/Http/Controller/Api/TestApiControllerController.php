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
use Mpie\Routing\Annotation\Controller;
use Mpie\Routing\Annotation\DeleteMapping;
use Mpie\Routing\Annotation\GetMapping;
use Mpie\Routing\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Controller(prefix: '/test-api-controller')]
class TestApiControllerController
{
    #[GetMapping(path: '/')]
    public static function index(ServerRequestInterface $request): ResponseInterface
    {
        return Response::json([
            'test-api' => true,
            'query'    => $request->getQueryParams(),
            'body'     => $request->getBody(),
        ]);
    }

    #[GetMapping(path: '/<id>')]
    public function show(ServerRequestInterface $request, $id): ResponseInterface
    {
    }

    #[DeleteMapping(path: '/<id>')]
    public function delete(ServerRequestInterface $request, $id): ResponseInterface
    {
    }

    #[RequestMapping(path: '/<id>', methods: ['PUT', 'PATCH'])]
    public function update(ServerRequestInterface $request, $id): ResponseInterface
    {
    }
}
