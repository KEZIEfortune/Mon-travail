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
            $table->id(); // bigint(20) UNSIGNED
            
            // Informations de base
            $table->string('title'); // varchar(255)
            $table->text('description'); // text
            $table->string('slug')->unique(); // varchar(255)
            $table->string('image')->nullable(); // varchar(255) NULL
            
            // Dates et Descriptions (Mission Organisateur)
            $table->dateTime('start_date'); // datetime
            $table->dateTime('end_date'); // datetime
            
            // Lieu (Mission Organisateur)
            $table->string('location'); // varchar(255)
            $table->string('city'); // varchar(255)
            $table->string('region')->nullable(); // varchar(255) NULL
            
            // Prix et Places
            $table->decimal('price', 8, 2)->nullable(); // decimal(8,2) NULL
            $table->integer('available_tickets')->default(0); 

            // Clés étrangères
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // bigint(20) UNSIGNED
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade'); // bigint(20) UNSIGNED
            
            // Statuts et Validations (Mission Soumission & Admin)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved'); // enum
            $table->tinyInteger('is_validated')->default(0); // tinyint(1) (0 = en attente)
            $table->tinyInteger('is_active')->default(1); // tinyint(1)
            
            $table->timestamps(); // created_at & updated_at
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