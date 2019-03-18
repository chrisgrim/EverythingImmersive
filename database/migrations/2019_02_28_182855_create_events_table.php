<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('organizer_id')->nullable();
            $table->string('eventTitle')->unique()->nullable();
            $table->string('slug')->unique();
            $table->longtext('eventDescription')->nullable();
            $table->string('eventWebsite')->nullable();
            $table->integer('eventPrice')->nullable();
            $table->string('eventTicketUrl')->nullable();
            $table->longtext('eventExpectations')->nullable();
            $table->string('eventStreetNumber')->nullable();
            $table->string('eventStreetAddress')->nullable();
            $table->string('eventCity')->nullable();
            $table->string('eventState')->nullable();
            $table->string('eventCountry')->nullable();
            $table->string('eventZipcode')->nullable();
            $table->string('eventLong')->nullable();
            $table->string('eventLat')->nullable();
            $table->string('overallRating')->default(0);
            $table->string('eventImagePath')->nullable();
            $table->string('thumbImagePath')->nullable();
            $table->boolean('approved')->nullable()->default(null);
            $table->integer('visitors')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
