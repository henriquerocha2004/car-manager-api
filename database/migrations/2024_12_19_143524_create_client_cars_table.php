<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_cars', function (Blueprint $table) {
            $table->id();
            $table->ulid('client_id');
            $table->unsignedInteger('car_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('car_id')->references('id')->on('cars_model');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_cars');
    }
};
