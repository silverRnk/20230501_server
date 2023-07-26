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
        Schema::create('enrollees', function (Blueprint $table) {
            $table->id();
            //Student Information
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('phone_no')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('address');
            $table->string('place_of_birth');
            $table->string('prev_school')->nullable();
            $table->string('email');
            $table->string('password');
            $table->integer('grade_level_id');
            $table->enum('enrollee_type',['new', 'transferee', 'old']);

            //Parent Information
            $table->string('fathers_name');
            $table->string('fathers_occupation')->nullable();
            $table->string('mothers_name');
            $table->string('mothers_occupation')->nullable();
            $table->string('guardians_phone_no');
            $table->string('guardians_email')->nullable();

            //Supporting Documents
            $table->string('good_moral')->nullable();
            $table->string('form_138')->nullable();
            $table->string('birth_cert')->nullable();

            //Validation
            $table->boolean('validated');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollees');
    }
};
