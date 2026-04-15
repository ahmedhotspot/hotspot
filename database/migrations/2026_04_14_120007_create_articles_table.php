<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->json('title');
            $t->json('category')->nullable();
            $t->json('excerpt')->nullable();
            $t->json('content')->nullable();
            $t->string('image')->nullable();
            $t->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('published_at')->nullable();
            $t->boolean('is_featured')->default(false);
            $t->integer('order')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('articles'); }
};
