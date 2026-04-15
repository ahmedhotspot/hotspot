<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financing_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('request_number')->unique()->nullable();

            // Product
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('sub_product_id')->nullable();

            // Address
            $table->string('national_id', 20)->nullable();
            $table->string('residence_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('district_name')->nullable();
            $table->string('additional_code')->nullable();
            $table->string('location_description')->nullable();

            // Contact
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('category_1')->nullable();

            // Commercial registration
            $table->string('legal_form')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('commercial_registration')->nullable();
            $table->string('city_2')->nullable();
            $table->string('license_expiry_date_hijri')->nullable();
            $table->string('establishment_date_hijri')->nullable();

            // Supplier / Contract (sub_product 1)
            $table->string('supplier_name')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('contract_type')->nullable();
            $table->date('contract_expiry_date')->nullable();

            // Owner info
            $table->string('owner_name')->nullable();
            $table->string('owner_id_number', 20)->nullable();
            $table->string('nationality')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('mobile_without_zero')->nullable();
            $table->string('id_expiry_date')->nullable();

            // Files (paths)
            $table->string('commercial_registration_doc')->nullable();
            $table->string('financial_statements')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('zakat_certificate')->nullable();
            $table->string('vat_certificate')->nullable();
            $table->string('national_address_certificate')->nullable();
            $table->string('contract_file')->nullable();
            $table->string('invoices_file')->nullable();

            // Sub-product 3 (working capital)
            $table->string('wc_budget_text')->nullable();
            $table->string('wc_authorized_signatory')->nullable();
            $table->string('wc_bank_statement_file')->nullable();
            $table->string('wc_budget_last_3_years_file')->nullable();
            $table->string('wc_articles_of_association_file')->nullable();
            $table->string('wc_commercial_registration_file')->nullable();

            // Sub-product 4 (real estate income)
            $table->decimal('re_income_down_payment_amount', 18, 2)->nullable();
            $table->string('re_income_down_payment_details')->nullable();
            $table->string('re_income_audited_fs_3y_file')->nullable();
            $table->string('re_income_bank_statement_12m_file')->nullable();
            $table->string('re_income_commercial_registration_file')->nullable();
            $table->string('re_income_articles_of_association_file')->nullable();
            $table->string('re_income_latest_valuation_file')->nullable();

            // Sub-product 5 (real estate land/warehouse)
            $table->decimal('re_land_financing_amount', 18, 2)->nullable();
            $table->decimal('re_land_property_value', 18, 2)->nullable();
            $table->decimal('re_land_down_payment', 18, 2)->nullable();
            $table->decimal('re_land_total_rent_value', 18, 2)->nullable();
            $table->decimal('re_land_remaining_tenure', 10, 2)->nullable();
            $table->string('re_land_audited_fs_3y_file')->nullable();
            $table->string('re_land_bank_statement_12m_file')->nullable();
            $table->string('re_land_commercial_registration_file')->nullable();
            $table->string('re_land_articles_of_association_file')->nullable();
            $table->string('re_land_latest_valuation_file')->nullable();

            // Guarantee
            $table->json('guarantee_type')->nullable();
            $table->string('real_estate_type')->nullable();
            $table->decimal('property_value', 18, 2)->nullable();
            $table->unsignedInteger('number_of_shares')->nullable();
            $table->decimal('share_value', 18, 2)->nullable();
            $table->decimal('promissory_note_value', 18, 2)->nullable();
            $table->string('promissory_note_file')->nullable();
            $table->decimal('cash_deposit_value', 18, 2)->nullable();
            $table->decimal('coverage_percentage', 6, 2)->nullable();

            // Documents JSON (extras)
            $table->json('documents')->nullable();

            // Workflow
            $table->string('status')->default('pending');
            $table->string('stage')->nullable();
            $table->string('payment_status')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('selected_offer_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financing_requests');
    }
};
