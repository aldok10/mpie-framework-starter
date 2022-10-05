<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

return [
    'engine' => \Mpie\View\Engine\BladeEngine::class,
    'config' => [
        // Template directory
        'path'       => __DIR__ . '/../views/',
        // Compile and cache directories
        'compileDir' => __DIR__ . '/../runtime/cache/views/',
        // Template cache
        'cache'      => false,
        // Template suffix
        'suffix'     => '.blade.php',
    ],
    //    'engine' => \Mpie\View\Engine\PhpEngine::class,
    //    'config' => [
    //        // Template directory
    //        'path'   => __DIR__ . '/../views/',
    //        // template suffix
    //        'suffix' => '.blade.php',
    //    ],
];
