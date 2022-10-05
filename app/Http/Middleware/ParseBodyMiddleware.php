<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http\Middleware;

use Mpie\Http\Message\Contract\HeaderInterface;
use Mpie\Http\Message\Contract\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * When the automatic request encoding method is json,
 * the json is automatically converted to an array.
 */
class ParseBodyMiddleware implements MiddlewareInterface
{
    /**
     * The request body of the following methods needs to be parsed.
     */
    protected array $shouldParseMethods = [
        RequestMethodInterface::METHOD_POST,
        RequestMethodInterface::METHOD_PUT,
        RequestMethodInterface::METHOD_PATCH,
    ];

    /**
     * Replace parsedBody after parsing.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->shouldParseBody($request) && $content = $request->getBody()?->getContents()) {
            $contentType = $request->getHeaderLine(HeaderInterface::HEADER_CONTENT_TYPE);
            if (str_contains($contentType, 'application/json')) {
                $request = $request->withParsedBody(json_decode($content, true) ?? []);
            } elseif (str_contains($contentType, 'application/xml')) {
                $xmlElements = simplexml_load_string($content);
                $request     = $request->withParsedBody(json_decode(json_encode($xmlElements), true));
            }
        }

        return $handler->handle($request);
    }

    /**
     * Whether parsing is required.
     */
    protected function shouldParseBody(ServerRequestInterface $request): bool
    {
        return in_array($request->getMethod(), $this->shouldParseMethods);
    }
}
