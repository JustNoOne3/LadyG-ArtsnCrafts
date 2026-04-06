<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Branch;

class Brand extends Model
{
    protected $fillable = [
        'brand_name',
        'brand_description',
        'brand_address',
        'brand_logo',
        'brand_backgroundImage',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
