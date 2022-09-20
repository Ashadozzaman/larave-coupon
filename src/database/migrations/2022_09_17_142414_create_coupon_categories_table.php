<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->string('code');
            $table->bigInteger('coupon_type');
            $table->bigInteger('coupon_rate');
            $table->string('start_date');
            $table->string('expire_date');
            $table->string('title')->nullable();
            $table->bigInteger('status')->default(1);
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
        Schema::dropIfExists('coupon_categories');
    }
}
