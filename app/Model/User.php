<?php

declare(strict_types=1);

/**
 * This file is part of Mpie Framework.
 *
 * @link     https://github.com/aldok10/mpie-framework
 * @license  https://github.com/aldok10/mpie-framework/blob/master/LICENSE
 */

namespace App\Model;

use Mpie\Database\Eloquent\Model;

/**
 * @property int $id
 */
class User extends Model
{
    protected static string $table    = 'users';

    protected static array  $hidden   = ['password'];

    protected static array  $fillable = ['id', 'name', 'nickname'];
}
