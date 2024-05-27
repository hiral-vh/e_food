<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestaurantColumnsToFsOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fs_owner', function (Blueprint $table) {
            $table->string('restaurant_image')->after('restaurant_document');
            $table->string('restaurant_open_time')->after('restaurant_image');
            $table->string('restaurant_close_time')->after('restaurant_open_time');
            $table->string('restaurant_aboutus')->after('restaurant_close_time');
            $table->string('restaurant_latitude')->after('restaurant_aboutus');
            $table->string('restaurant_longitude')->after('restaurant_latitude');
            $table->enum('status', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fs_owner', function (Blueprint $table) {
            //
        });
    }
}
