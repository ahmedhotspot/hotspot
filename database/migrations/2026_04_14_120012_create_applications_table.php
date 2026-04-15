<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('bank_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('offer_id')->nullable()->constrained()->nullOnDelete();
            $t->string('full_name');
            $t->string('national_id')->nullable();
            $t->string('email');
            $t->string('phone');
            $t->string('city')->nullable();
            $t->string('employer')->nullable();
            $t->string('sector')->nullable(); // government, private
            $t->decimal('salary', 12, 2)->nullable();
            $t->decimal('amount', 14, 2);
            $t->unsignedTinyInteger('term_years')->default(5);
            $t->string('status')->default('new'); // new, reviewing, approved, rejected, completed
            $t->text('notes')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('applications'); }
};
