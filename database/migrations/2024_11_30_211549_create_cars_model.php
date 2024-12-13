<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cars_model', function (Blueprint $table) {
            $table->id();
            $table->string('model')->index();
            $table->string('year')->index();
            $table->string('fuel_type')->nullable();
            $table->string('fipe_code')->nullable();
            $table->string('fipe_lib_model_code')->nullable();
            $table->unsignedInteger('brand_id')->index();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('car_brands');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars_model');
    }
};
