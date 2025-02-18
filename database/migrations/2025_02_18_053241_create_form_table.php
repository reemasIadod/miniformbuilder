<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('form', function (Blueprint $table) {
            $table->id();
            $table->string('label', 255);
            $table->string('bg_color', 50)->default('white');
            $table->string('font_family', 100)->default('Arial');
            $table->boolean('has_form_labels')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form');
    }
};