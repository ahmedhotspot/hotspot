<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $t) {
            $t->id();
            $t->string('location')->index(); // header, footer_finance, footer_company
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->json('label'); // {"ar": "...", "en": "..."}
            $t->string('url');
            $t->string('target')->default('_self');
            $t->string('icon')->nullable();
            $t->integer('order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('menu_items'); }
};
