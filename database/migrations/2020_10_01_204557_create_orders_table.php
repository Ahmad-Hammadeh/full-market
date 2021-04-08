<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
            $table->string('email');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postalcode');
            $table->string('phone');
            $table->string('name_on_card')->nullable();
            $table->unsignedDecimal('discount', 8, 2)->default(0);
            $table->string('discount_code')->nullable();
            $table->unsignedDecimal('subtotal', 8, 2);
            $table->unsignedDecimal('tax', 8, 2);
            $table->unsignedDecimal('total', 8, 2);
            $table->enum('payment_method', ['at_receiving', 'credit_card', 'paypal'])->default('at_receiving');
            $table->boolean('shipped')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->string('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
