<?php

use App\Enums\CourseStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->enum(
                'status',
                array_column(CourseStatus::cases(), 'value')
            )
                ->default(CourseStatus::Draft->value)
                ->after('description');

        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->dropColumn('status');

        });
    }
};
