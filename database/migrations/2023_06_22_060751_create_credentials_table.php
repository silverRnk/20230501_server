<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credentials', function (Blueprint $table) {
            $table->id()->unique();
            $table->enum(
                'credential_type',
                [
                    'birth_cert',
                    'form_137',
                    'good_moral',
                    'form_138',
                    'report_card'
                ]
            );
            $table->string('file_name');
            $table->string('file_path');
            $table->foreignUuid('std_ID')->constrained(
                'students', 'std_ID', 'std_ID'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credentials');
    }
};