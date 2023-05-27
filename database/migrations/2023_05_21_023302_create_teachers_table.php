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
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('religion')->nullable();
            $table->string('address');
            $table->foreignId('advisory_class')
            ->nullable()
            ->constrained('class_sections', 'id');
            // $table->unsignedBigInteger('advisory_class')
            // ->nullable()
            // ->unsigned();
            $table->string('profile_img')->nullable();
            $table->string('email');
            $table->string('phone_no');
            $table->string('password');
            $table->date('admission_date');
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
