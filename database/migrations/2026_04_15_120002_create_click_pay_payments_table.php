<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('click_pay_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('financing_request_id')->nullable()->index();
            $table->unsignedBigInteger('reference_id')->nullable()->index();

            $table->string('request_uuid')->nullable()->index();
            $table->string('cart_id')->nullable()->index();
            $table->string('cart_description')->nullable();

            $table->decimal('amount', 18, 2)->default(0);
            $table->string('currency', 10)->default('SAR');

            $table->string('tran_ref')->nullable()->index();
            $table->text('redirect_url')->nullable();
            $table->text('callback_url')->nullable();
            $table->text('return_url')->nullable();

            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('card_scheme')->nullable();
            $table->string('card_last4', 10)->nullable();

            $table->string('response_code')->nullable();
            $table->text('response_message')->nullable();

            $table->json('create_response')->nullable();
            $table->json('callback_payload')->nullable();
            $table->json('verify_response')->nullable();
            $table->json('verification_response')->nullable();
            $table->json('clickpay_response')->nullable();

            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_ip', 64)->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('click_pay_payments');
    }
};
