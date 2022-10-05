<?php

declare(strict_types=1);

use App\Bootstrap;
use App\Http\Kernel;
use App\Http\ServerRequest;
use Mpie\Di\Context;
use Mpie\Http\Server\ResponseEmitter\FPMResponseEmitter;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '1G');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');
define('BASE_PATH', dirname(__DIR__) . '/');

(function () {
    require_once __DIR__ . '/../vendor/autoload.php';
    Bootstrap::boot();
    $kernel   = Context::getContainer()->make(Kernel::class);
    $response = $kernel->through(ServerRequest::createFromGlobals());
    (new FPMResponseEmitter())->emit($response);
})();
