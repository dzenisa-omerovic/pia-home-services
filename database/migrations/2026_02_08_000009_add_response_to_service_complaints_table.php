<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_complaints', function (Blueprint $table) {
            $table->text('response')->nullable()->after('description');
            $table->dateTime('responded_at')->nullable()->after('response');
        });
    }

    public function down(): void
    {
        Schema::table('service_complaints', function (Blueprint $table) {
            $table->dropColumn(['response', 'responded_at']);
        });
    }
};
