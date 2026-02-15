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
        Schema::table('service_providers', function (Blueprint $table) {
            $table->unsignedInteger('completed_jobs_count')->default(0)->after('approval_status');
            $table->unsignedInteger('promotion_credits')->default(0)->after('completed_jobs_count');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->timestamp('promoted_until')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('promoted_until');
        });

        Schema::table('service_providers', function (Blueprint $table) {
            $table->dropColumn(['completed_jobs_count', 'promotion_credits']);
        });
    }
};
