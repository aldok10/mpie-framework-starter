<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http\Controller;

use App\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    /**
     * Note: If you need to use request variables, remember that the variable name is $request, otherwise it cannot be injected.
     */
    public static function index(ServerRequestInterface $request): ResponseInterface
    {
        return Response::json(['name', $request->query('name', 'world')]);
    }
}
