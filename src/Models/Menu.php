<?php

namespace Selene\Modules\MenuModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method create(array $all)
 */
class Menu extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'structure',
    ];
}

