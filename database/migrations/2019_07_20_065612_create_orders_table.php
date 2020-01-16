<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->text('name');
            $table->integer('user_id')->unsignedBigInteger();
            $table->integer('book_id')->unsignedBigInteger();
            $table->text('payment_method');
            $table->text('location');
            $table->string('transection_id')->nullable();
            $table->string('ip_address');
            $table->integer('total_price');
            $table->integer('order_type')->default(0)->comment('0=Normal|1=gift|');
            $table->integer('quantity')->default(1);
            $table->text('phone_number');
            $table->text('shiping_address');
            $table->integer('is_completed')->default(0);
            $table->integer('is_seen_by_admin')->default(0);
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
