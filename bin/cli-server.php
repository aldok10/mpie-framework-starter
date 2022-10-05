<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

$host = '0.0.0.0';
$port = 8989;
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
printf("PHP          Version:    %s\n", PHP_VERSION);
passthru(PHP_BINARY . ' -S ' . $host . ':' . $port . ' -t public/ server.php' . PHP_EOL);
