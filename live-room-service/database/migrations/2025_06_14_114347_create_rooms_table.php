<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');
            $table->string('image_url');
            $table->string('category');
            $table->date('date');
            $table->time('time');
            $table->string('team_a');
            $table->string('team_b');
            $table->string('commentator')->nullable();
            $table->boolean('is_live')->default(false);
            $table->boolean('is_hot')->default(false);
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
        Schema::dropIfExists('rooms');
    }
}
