<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_complaints', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_request_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('open');
            $table->timestamps();

            $table->unique(['service_request_id', 'customer_id']);
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_complaints');
    }
};
