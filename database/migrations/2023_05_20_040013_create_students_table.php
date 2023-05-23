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
        Schema::create('students', function (Blueprint $table) {

            //student info
            $table->uuid('std_ID')->unique();
            $table->string('std_name');
            $table->enum('std_gender', ['male', 'female']);
            $table->string('password');
            $table->string('std_photo')->nullable();
            $table->date('std_date_of_birth');
            $table->string('std_religion');
            $table->string('std_email');
            $table->enum('std_status', ['transferee', 'old', 'new']);


            //Foreign Id
            $table->foreignId('tchr_Id');
            $table->foreignUuid('grade_level_id')
            ->constrained('grade_levels', 'uuid');
            $table->foreignId('section_id')
            ->constrained('class_sections');
            $table->foreignId('school_Id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
