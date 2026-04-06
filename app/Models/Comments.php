<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'comment_ratingId',
        'comment_userId',
        'comment_content',
        'comment_attachment',
    ];
}
