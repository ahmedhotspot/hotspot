<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $t) {
            $t->string('industry_id')->nullable()->after('service_id');
            $t->string('sub_industry_id')->nullable()->after('industry_id');
            $t->string('industry_name')->nullable()->after('sub_industry_id');
            $t->string('sub_industry_name')->nullable()->after('industry_name');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $t) {
            $t->dropColumn(['industry_id', 'sub_industry_id', 'industry_name', 'sub_industry_name']);
        });
    }
};
