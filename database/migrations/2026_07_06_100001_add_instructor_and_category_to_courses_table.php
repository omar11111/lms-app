<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('instructor_id')
                ->nullable()
                ->after('module_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->after('instructor_id')
                ->constrained('categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('instructor_id');
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
