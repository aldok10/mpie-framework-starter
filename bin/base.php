<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

ini_set('display_errors', 'off');
ini_set('display_startup_errors', 'off');
ini_set('memory_limit', '1G');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');
define('BASE_PATH', dirname(__DIR__) . '/');

require_once './vendor/autoload.php';
