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
        Schema::create('parent_infos', function (Blueprint $table) {
            $table->id();
            //Parent Info
            $table->string('fathers_name');
            $table->string('mothers_name');
            $table->string('fathers_occupation');
            $table->string('parents_phone_no');
            $table->string('parents_religion');
            $table->string('parents_email');
            $table->foreignUuid('student_id')->constrained('students', 'std_ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
