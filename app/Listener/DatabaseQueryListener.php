<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Listener;

use Mpie\Database\Event\QueryExecuted;
use Mpie\Event\Contract\EventListenerInterface;
use Psr\Log\LoggerInterface;

class DatabaseQueryListener implements EventListenerInterface
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    public function listen(): iterable
    {
        return [
            QueryExecuted::class,
        ];
    }

    public function process(object $event): void
    {
        if ($event instanceof QueryExecuted) {
            $this->logger->get('sql')->debug($event->query, [
                'duration' => microtime(true) - $event->executedAt,
                'bindings' => $event->bindings,
            ]);
        }
    }
}
