<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_portals', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->longText('content');
            $table->string('featured_image');
            $table->string('video_url')->nullable();
            $table->string('type')->default('text');
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
        Schema::dropIfExists('news_portals');
    }
}
