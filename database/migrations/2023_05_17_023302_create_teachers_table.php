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
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('religion')->nullable();
            $table->string('advisory_class')->nullable();
            $table->string('profile_img')->nullable();
            $table->string('email');
            $table->string('phone_no');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
