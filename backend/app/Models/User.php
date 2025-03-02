<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $color
 * @mixin Eloquent
 */
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'color'
    ];
}
