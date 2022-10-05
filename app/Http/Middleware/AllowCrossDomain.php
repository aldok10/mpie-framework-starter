<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Http\Middleware;

use Mpie\Http\Server\Middleware\AllowCrossDomain as Middleware;

class AllowCrossDomain extends Middleware
{
    /** {@inheritdoc} */
    protected array $allowOrigin = ['*'];
}
