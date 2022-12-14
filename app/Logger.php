<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App;

use InvalidArgumentException;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as MonoLogger;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    /** @var string default log */
    protected string $default = 'app';

    /** @var array all logs */
    protected array $logger = [];

    public function __construct()
    {
        $this->logger[$this->default] = new MonoLogger($this->default, [
            new RotatingFileHandler(base_path('runtime/logs/' . $this->default . '.log'), 180, MonoLogger::DEBUG),
        ]);
        $this->logger['sql']          = new MonoLogger('sql', [
            new RotatingFileHandler(base_path('runtime/logs/database/sql.log'), 180, MonoLogger::DEBUG),
        ]);
    }

    /**
     * Return a logger.
     *
     * @param string $name registered name
     */
    public function get(string $name = ''): MonoLogger
    {
        return $this->logger[$name ?: $this->default] ?? throw new InvalidArgumentException('Logger ' . $name . ' does not exist');
    }

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = []): void
    {
        $this->get()->emergency($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = []): void
    {
        $this->get()->alert($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = []): void
    {
        $this->get()->critical($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = []): void
    {
        $this->get()->error($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = []): void
    {
        $this->get()->warning($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = []): void
    {
        $this->get()->notice($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = []): void
    {
        $this->get()->info($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = []): void
    {
        $this->get()->debug($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = []): void
    {
        $this->get()->log($level, $message, $context);
    }
}
