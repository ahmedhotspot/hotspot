<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('group')->default('general')->index();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->string('type')->default('text'); // text, textarea, image, json, boolean, number, color
            $t->string('label')->nullable();
            $t->boolean('is_translatable')->default(false);
            $t->integer('order')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('settings'); }
};
