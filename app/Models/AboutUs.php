<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'aboutUs_title',
        'aboutUs_content',
        'aboutUs_image',
        'aboutUs_background'
    ];
}
