<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $t) {
            $t->string('email')->nullable()->change();
            $t->decimal('amount', 14, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $t) {
            $t->string('email')->nullable(false)->change();
            $t->decimal('amount', 14, 2)->nullable(false)->change();
        });
    }
};
