<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('first_name')->index();
            $table->string('last_name');
            $table->string('entity_type')->default('PF')->index();
            $table->string('document')->nullable()->index();
            $table->string('document_type')->nullable()->index();
            $table->date('birth_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
