<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http;

use Mpie\Http\Message\Contract\HeaderInterface;
use Mpie\Http\Message\Stream\FileStream;
use Mpie\Http\Server\Response as PsrResponse;
use Mpie\View\ViewFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Response extends PsrResponse
{
    protected const DEFAULT_DOWNLOAD_HEADERS = [
        HeaderInterface::HEADER_PRAGMA                    => 'public', // Public indicates that the response can be cached by any buffer
        HeaderInterface::HEADER_EXPIRES                   => '0', // Browser will not respond to cache
        HeaderInterface::HEADER_CACHE_CONTROL             => 'must-revalidate, post-check=0, pre-check=0',
        HeaderInterface::HEADER_CONTENT_TYPE              => 'application/download',
        HeaderInterface::HEADER_CONTENT_TRANSFER_ENCODING => 'binary',
    ];

    /**
     * Render view.
     */
    public static function view(string $view, array $arguments = [], ?ServerRequestInterface $request = null): ResponseInterface
    {
        $renderer = make(ViewFactory::class)->getRenderer();
        if (isset($request)) {
            $renderer->assign('request', $request);
        }
        return Response::HTML($renderer->render($view, $arguments));
    }

    /**
     * Create a file download response.
     *
     * @param string $name   Filename (leave blank to automatically generate filename)
     * @param int    $offset Offset
     * @param int    $length Length
     */
    public static function download(string $file, string $name = '', int $offset = 0, int $length = 0): ResponseInterface
    {
        $name                                                 = $name ?: pathinfo($file, PATHINFO_BASENAME);
        $headers                                              = static::DEFAULT_DOWNLOAD_HEADERS;
        $headers[HeaderInterface::HEADER_CONTENT_DISPOSITION] = sprintf('attachment;filename="%s"', htmlspecialchars($name, ENT_COMPAT));
        return new static(200, $headers, new FileStream($file, $offset, $length));
    }
}
