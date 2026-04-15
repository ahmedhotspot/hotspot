<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('phone')->nullable();
            $t->string('subject')->nullable();
            $t->text('message');
            $t->string('status')->default('new'); // new, read, replied, archived
            $t->text('admin_notes')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('contacts'); }
};
