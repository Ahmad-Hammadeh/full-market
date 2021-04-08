<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;

class CustomDataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'products');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'products',
                'display_name_singular' => __('backend.product'),
                'display_name_plural'   => __('backend.products'),
                'icon'                  => 'voyager-bag',
                'model_name'            => 'App\Model\Product',
                'controller'            => '\App\Http\Controllers\Voyager\ProductBreadController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server-side'           => 1,
            ])->save();
        }

        $dataType = $this->dataType('slug', 'coupons');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'coupons',
                'display_name_singular' => __('backend.coupon'),
                'display_name_plural'   => __('backend.coupons'),
                'icon'                  => 'voyager-credit-card',
                'model_name'            => 'App\Model\Coupon',
                'controller'            => '\App\Http\Controllers\Voyager\CouponBreadController',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'categories');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'categories',
                'display_name_singular' => __('backend.category'),
                'display_name_plural'   => __('backend.categories'),
                'icon'                  => 'voyager-categories',
                'model_name'            => 'App\Model\Category',
                'controller'            => '\App\Http\Controllers\Voyager\CategoryBreadController',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $dataType = $this->dataType('name', 'orders');
        if (!$dataType->exists) {
            $dataType->fill([
                'slug' => 'orders',
                'display_name_singular' => __('backend.order'),
                'display_name_plural' => __('backend.orders'),
                'icon' => 'voyager-documentation',
                'model_name' => 'App\Model\Order',
                'controller' => '\App\Http\Controllers\Voyager\OrderBreadController',
                'generate_permissions' => 1,
                'description' => '',
                'server-side' => 1,
            ])->save();
        }
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
