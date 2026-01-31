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
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->dateTime('start_date');
        $table->dateTime('end_date');
        $table->string('location');
        $table->string('slug');
        $table->string('city');
        $table->decimal('price', 8, 2)->nullable();
        $table->string('image')->nullable();
        $table->string('region')->nullable();
        $table->foreignId('category_id')->constrained();
        $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
