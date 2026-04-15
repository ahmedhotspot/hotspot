<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('role')->default('user')->after('password')->index(); // user, admin, super_admin
            $t->string('phone')->nullable()->after('email');
            $t->string('avatar')->nullable()->after('phone');
            $t->boolean('is_active')->default(true)->after('role');
            $t->string('locale', 5)->default('ar')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['role', 'phone', 'avatar', 'is_active', 'locale']);
        });
    }
};
