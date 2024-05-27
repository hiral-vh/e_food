<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFsBookTableDurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fs_book_table_duration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_table_id');
            $table->foreign('book_table_id')->references('id')->on('fs_book_table');
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();
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
        Schema::dropIfExists('fs_book_table_duration');
    }
}
