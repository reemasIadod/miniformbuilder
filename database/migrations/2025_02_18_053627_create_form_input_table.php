<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('form_input', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('form')->onDelete('cascade');
            $table->enum('type', ['checkbox', 'text', 'date', 'number']);
            $table->string('label', 255);
            $table->string('name', 100)->unique();
            $table->string('id_index', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_input');
    }
};
