<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('how_it_works_steps', function (Blueprint $t) {
            $t->id();
            $t->string('icon')->default('fa-check');
            $t->json('title');
            $t->json('description');
            $t->integer('order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('how_it_works_steps'); }
};
