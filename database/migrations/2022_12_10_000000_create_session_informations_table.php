<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_informations', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->integer('session_id');
            $table->string('browser')->nullable();
            $table->string('countryName')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('cityName')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('timezone')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('os_family')->nullable();
            $table->string('os_type')->nullable();
            $table->string('os_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('os_title')->nullable();
            $table->string('device_type')->nullable();
            $table->integer('countCountries')->nullable()->default(0);
            $table->integer('countCity')->nullable()->default(0);
            $table->integer('countBrowser')->nullable()->default(0);
            $table->integer('countOs')->nullable()->default(0);
            $table->integer('countDevice')->nullable()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('session_informations');
    }
}