<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use SearchableTrait, Searchable;

    protected $table = 'products';

    protected $fillable = ['name','slug','details','description','price', 'image', 'images', 'featured', 'quantity'];

    /**
     * Mutators
    */

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = app_number_format($value);
    }

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 2,
        ]
    ];

    /**
     * Algolia
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...
        $categories = [
            'categories' => $this->categories->pluck('name')->toArray()
        ];

        return array_merge( $array, $categories );
    }

    // Relation With Category Model
    public function categories()
    {
        return $this->belongsToMany('App\Model\Category');
    }

    // Relation With Order Model
    public function orders()
    {
        return $this->belongsToMany('App\Model\Order');
    }

}
