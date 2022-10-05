<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

if (is_file($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'])) {
    return false;
}
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';

require __DIR__ . '/public/index.php';
