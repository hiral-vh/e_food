<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFsRestaurantMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fs_restaurant_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_name')->nullable();
            $table->string('restaurant_image')->nullable();
            $table->string('restaurant_open_time')->nullable();
            $table->string('restaurant_close_time')->nullable();
            $table->string('restaurant_aboutus')->nullable();
            $table->string('restaurant_address')->nullable();
            $table->string('restaurant_latitude')->nullable();
            $table->string('restaurant_longitude')->nullable();
            $table->string('restaurant_phone')->nullable();
            $table->string('restaurant_email')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fs_restaurant_master');
    }
}
