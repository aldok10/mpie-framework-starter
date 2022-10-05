<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http\Middleware;

use Mpie\Http\Server\Middleware\VerifyCSRFToken as Middleware;

class VerifyCSRFToken extends Middleware
{
    /**
     * Exclude, do not verify CSRF Token.
     */
    protected array $except = ['/'];
}
