<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouritesTable extends Migration
{
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('game_id'); // Adjust the data type if needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favourites');
    }
}
;
