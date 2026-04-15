<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $t) {
            $t->id();
            $t->foreignId('bank_id')->constrained()->cascadeOnDelete();
            $t->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $t->json('title')->nullable();
            $t->decimal('apr', 6, 2);
            $t->unsignedBigInteger('max_amount')->default(0);
            $t->unsignedBigInteger('min_amount')->default(0);
            $t->unsignedInteger('monthly_sample')->default(0); // monthly on 100k
            $t->unsignedTinyInteger('max_term_years')->default(5);
            $t->json('approval_note')->nullable(); // e.g. "Instant approval"
            $t->string('approval_icon')->default('fa-clock');
            $t->string('sector')->default('all'); // all, government, private
            $t->boolean('is_best')->default(false);
            $t->boolean('is_active')->default(true);
            $t->integer('order')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('offers'); }
};
