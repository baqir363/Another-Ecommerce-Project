<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;
    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'category',
        'image',
    ];

    public function Sluggable():array
    {
        return[
            'slug'=>[
                'source' => 'title'
            ]
            ];
    }

}
