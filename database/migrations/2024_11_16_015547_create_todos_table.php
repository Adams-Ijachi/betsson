<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();

            $table->text('name');
            $table->boolean('is_completed')->default(false);

            $table->foreignId('user_id')->constrained();
            $table->foreignId('priority_id')->constrained();
            $table->foreignId('category_id')->nullable()->constrained();

            $table->foreignId('parent_id')->nullable()->constrained('todos'); // Foreign key for self-referencing

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
