<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $t) {
            $t->id();
            $t->string('platform'); // twitter, facebook, linkedin, instagram, ...
            $t->string('url');
            $t->string('icon')->default('fa-link'); // FA class
            $t->integer('order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('social_links'); }
};
