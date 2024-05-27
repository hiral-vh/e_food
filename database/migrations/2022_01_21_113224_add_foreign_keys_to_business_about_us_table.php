<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBusinessAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_about_us', function (Blueprint $table) {
            $table->foreign(['business_id'], 'business_about_us_ibfk_1')->references(['id'])->on('businesses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_about_us', function (Blueprint $table) {
            $table->dropForeign('business_about_us_ibfk_1');
        });
    }
}
