<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'category',
        'website',
        'searchWord',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
