<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Listener;

use Mpie\Event\Annotation\Listen;
use Mpie\Event\Contract\EventListenerInterface;
use Mpie\Http\Server\Event\OnRequest;

#[Listen]
class ServerListener implements EventListenerInterface
{
    public function listen(): iterable
    {
        return [
            OnRequest::class,
        ];
    }

    public function process(object $event): void
    {
        if ($event instanceof OnRequest) {
            $request    = $event->request;
            $response   = $event->response;
            $statusCode = $response->getStatusCode();
            $option     = $response->isSuccessful() ? 42 : ($response->isRedirect() ? 43 : 41);
            echo sprintf(
                "[MpiePHP] %s |%s|%10.3fms| %15s|\033[44m%7s\033[0m| \"%s\"\n",
                date('Y/m/d H:i:s'),
                sprintf("\033[%dm%6s\033[0m", $option, $statusCode),
                (microtime(true) - $event->requestedAt) * 1000,
                $request->getRealIp(),
                $request->getMethod(),
                $request->url(),
            );
        }
    }
}
