<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = [
        'footer_image',
        'footer_fbLink',
        'footer_instagramLink',
        'footer_viberLink',
    ];
}
