<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

protected $fillable = [
    'user_email',
    'food_name',
    'description',
    'image_url',
    'is_public'
];
}
