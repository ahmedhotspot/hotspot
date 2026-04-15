<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $t) {
            $t->string('sub_product')->nullable()->after('service_id');

            $t->string('residence_number')->nullable()->after('national_id');
            $t->string('street_name')->nullable()->after('city');
            $t->string('postal_code')->nullable()->after('street_name');
            $t->string('district_name')->nullable()->after('postal_code');
            $t->string('additional_code')->nullable()->after('district_name');
            $t->string('location_description')->nullable()->after('additional_code');

            $t->string('mobile_2')->nullable()->after('phone');
            $t->string('phone_1')->nullable()->after('mobile_2');
            $t->string('phone_2')->nullable()->after('phone_1');

            $t->string('legal_form')->nullable();
            $t->string('commercial_name')->nullable();
            $t->string('commercial_registration')->nullable();
            $t->string('commercial_city')->nullable();
            $t->string('license_expiry_hijri')->nullable();
            $t->string('establishment_date_hijri')->nullable();

            $t->string('owner_name')->nullable();
            $t->string('owner_id_number')->nullable();
            $t->string('nationality')->nullable();
            $t->date('birth_date')->nullable();
            $t->string('id_expiry_date')->nullable();

            $t->json('guarantee_types')->nullable();
            $t->json('guarantee_details')->nullable();
            $t->json('documents')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $t) {
            $t->dropColumn([
                'sub_product',
                'residence_number', 'street_name', 'postal_code', 'district_name',
                'additional_code', 'location_description',
                'mobile_2', 'phone_1', 'phone_2',
                'legal_form', 'commercial_name', 'commercial_registration',
                'commercial_city', 'license_expiry_hijri', 'establishment_date_hijri',
                'owner_name', 'owner_id_number', 'nationality', 'birth_date', 'id_expiry_date',
                'guarantee_types', 'guarantee_details', 'documents',
            ]);
        });
    }
};
