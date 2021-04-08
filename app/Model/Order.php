<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['user_id', 'email', 'name', 'address', 'city', 'province', 'postalcode', 'phone', 'name_on_card', 'discount', 'discount_code', 'subtotal', 'tax', 'total', 'payment_method', 'shipped', 'is_paid', 'error'];

    // Relation With User Model
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Relation With Product Model
    public function products()
    {
        return $this->belongsToMany('App\Model\Product')->withPivot('quantity');
    }

}
