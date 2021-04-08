<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name','slug'];

    // Relation With Product Model
    public function products()
    {
        return $this->belongsToMany('App\Model\Product');
    }
}
