<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level')->unique();
            $table->timestamps();
        });
        Schema::create('contact_levels_event', function(Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->integer('contact_level_id')->unsigned()->index();
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
        Schema::dropIfExists('contact_levels');
    }
}
