<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('number_of_rooms');
            $table->unsignedTinyInteger('number_of_beds');
            $table->unsignedTinyInteger('number_of_bathrooms');
            $table->unsignedMediumInteger('sqm')->nullable();
            $table->text('address');
            $table->string('city', 150);
            $table->unsignedMediumInteger('cap');
            $table->string('province', 10);
            $table->string('image', 255);
            $table->float('latitude', 11, 7);
            $table->float('longitude', 11, 7);
            $table->boolean('availability');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
