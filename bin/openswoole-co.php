<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

use App\Bootstrap;
use App\Http\Kernel;
use App\Http\ServerRequest;
use Mpie\Di\Context;
use Mpie\Http\Server\ResponseEmitter\SwooleResponseEmitter;
use Swoole\Constant;
use Swoole\Http\Request;
use Swoole\Http\Response;

use function Swoole\Coroutine\run;

require_once __DIR__ . '/base.php';

(function () {
    if (! class_exists('Swoole\Server')) {
        throw new Exception('You should install the swoole extension before starting.');
    }
    Bootstrap::boot(true);

    run(function () {
        // Configuration.
        $host     = '0.0.0.0';
        $port     = 8989;
        $settings = [
            Constant::OPTION_WORKER_NUM  => swoole_cpu_num(),
            Constant::OPTION_MAX_REQUEST => 100000,
        ];

        // Start server.
        $server = new Swoole\Coroutine\Http\Server($host, $port);
        $kernel = Context::getContainer()->make(Kernel::class);
        $server->handle('/', function (Request $request, Response $response) use ($kernel) {
            $psrResponse = $kernel->through(ServerRequest::createFromSwooleRequest($request, [
                'request'  => $request,
                'response' => $response,
            ]));
            (new SwooleResponseEmitter())->emit($psrResponse, $response);
        });

        $server->set($settings);
        echo <<<'EOT'
---------------------------------------------------------------------------
    ███╗░░░███╗██████╗░██╗███████╗░░░░░░██████╗░██╗░░██╗██████╗░
    ████╗░████║██╔══██╗██║██╔════╝░░░░░░██╔══██╗██║░░██║██╔══██╗
    ██╔████╔██║██████╔╝██║█████╗░░█████╗██████╔╝███████║██████╔╝
    ██║╚██╔╝██║██╔═══╝░██║██╔══╝░░╚════╝██╔═══╝░██╔══██║██╔═══╝░
    ██║░╚═╝░██║██║░░░░░██║███████╗░░░░░░██║░░░░░██║░░██║██║░░░░░
    ╚═╝░░░░░╚═╝╚═╝░░░░░╚═╝╚══════╝░░░░░░╚═╝░░░░░╚═╝░░╚═╝╚═╝░░░░░
---------------------------------------------------------------------------

EOT;
        printf("System       Name:       %s\n", strtolower(PHP_OS));
        printf("Container    Name:       openswoole\n");
        printf("PHP          Version:    %s\n", PHP_VERSION);
        printf("OpenSwoole   Version:    %s\n", swoole_version());
        printf("Listen       Addr:       http://%s:%d\n", $host, $port);
        $server->start();
    });
})();
