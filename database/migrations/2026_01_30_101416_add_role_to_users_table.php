<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
       Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['visitor', 'member', 'organizer', 'admin'])->default('visitor')->after('email');
            $table->string('phone')->nullable()->after('email');
            $table->text('description')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('description');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
       Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'description', 'is_active']);
        }); 
    }
};
