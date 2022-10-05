<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

use App\Bootstrap;
use App\Console\Kernel;

require_once __DIR__ . '/base.php';

(function () {
    Bootstrap::boot(true);
    (new Kernel())->run();
})();
