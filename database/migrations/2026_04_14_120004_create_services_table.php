<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->json('title');
            $t->json('description')->nullable();
            $t->json('long_description')->nullable();
            $t->string('icon')->nullable();     // FA class e.g. fa-user-tie
            $t->string('icon_class')->nullable(); // CSS class e.g. icon-personal
            $t->string('image')->nullable();
            $t->integer('order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('services'); }
};
