<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'branch_name', 
        'branch_address', 
        'branch_contact',
        'branch_email',
        'branch_mapLink',
        'branch_brands'
    ];

    protected $casts = [
        'branch_brands' => 'array',
    ];

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
}
