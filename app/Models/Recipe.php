<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use CrudTrait;
    protected $fillable = ['name', 'description', 'ingredients', 'prep_time'];

    protected $casts = [
        'ingredients' => 'array',
    ];
}
