<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
      'photo',
      'description',
      'category',
      'price',
      'website',
      'link'
    ];

    public function search()
    {
        return $this->belongsTo(Search::class);
    }
}
