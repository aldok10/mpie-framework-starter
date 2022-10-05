<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class HttpTestCase extends TestCase
{
    protected Client $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new Client();
    }

    public function __call($name, $arguments)
    {
        return $this->client->{$name}(...$arguments);
    }
}
