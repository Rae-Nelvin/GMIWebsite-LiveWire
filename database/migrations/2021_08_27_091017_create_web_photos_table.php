<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_photos', function (Blueprint $table) {
            $table->id();
            $table->text('section');
            $table->text('caption');
            $table->text('content1')->nullable();
            $table->text('content2')->nullable();
            $table->foreignId('author_id')->references('id')->on('users');
            $table->text('file_path');
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
        Schema::dropIfExists('web_photos');
    }
}
