<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('financing_request_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('action')->nullable();
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();

            $table->string('method')->nullable();
            $table->string('url', 1000)->nullable();
            $table->string('route_name')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->text('user_agent')->nullable();

            $table->string('user_email')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_national_id')->nullable();

            $table->string('financing_step')->nullable();
            $table->string('financing_step_name')->nullable();

            $table->json('request_data')->nullable();
            $table->integer('response_status')->nullable();
            $table->string('session_id')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
