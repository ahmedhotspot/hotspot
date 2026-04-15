<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('page', 60)->index();           // e.g. 'about', 'home', 'contact'
            $table->string('section', 80)->nullable();     // e.g. 'hero', 'vision'
            $table->string('key', 120);                    // e.g. 'title', 'text', 'badge'
            $table->string('type', 20)->default('text');   // text | html | image
            $table->json('value')->nullable();             // {"ar": "...", "en": "..."} OR {"path": "..."} for images
            $table->string('label')->nullable();           // admin hint
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->unique(['page', 'section', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
