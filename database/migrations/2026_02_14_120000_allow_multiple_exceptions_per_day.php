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
        Schema::table('service_availability_exceptions', function (Blueprint $table) {
            // Keep FK index coverage before dropping the old unique composite index.
            $table->index('service_provider_id');
            $table->dropUnique(['service_provider_id', 'date']);
            $table->index(['service_provider_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_availability_exceptions', function (Blueprint $table) {
            $table->dropIndex(['service_provider_id', 'date']);
            $table->unique(['service_provider_id', 'date']);
            $table->dropIndex(['service_provider_id']);
        });
    }
};
