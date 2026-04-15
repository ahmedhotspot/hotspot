<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->json('name');
            $t->json('city')->nullable();
            $t->json('text');
            $t->decimal('stars', 2, 1)->default(5.0);
            $t->string('avatar')->nullable();
            $t->string('initial', 4)->nullable();
            $t->integer('order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('testimonials'); }
};
