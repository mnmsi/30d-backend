<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duas_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('dua_id');
            $table->foreign('dua_id')->references('id')->on('duas');
            $table->longText('ar_text');
            $table->longText('en_text');
            $table->string('audio');
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
        Schema::dropIfExists('duas_categories');
    }
}
