<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
// !defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

// Swoole\Runtime::enableCoroutine(true);

require BASE_PATH . '/vendor/autoload.php';
