<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'bank_id', 'service_id', 'offer_id', 'sub_product',
        'industry_id', 'sub_industry_id', 'industry_name', 'sub_industry_name',
        'full_name', 'national_id', 'residence_number', 'email',
        'phone', 'mobile_2', 'phone_1', 'phone_2',
        'city', 'street_name', 'postal_code', 'district_name',
        'additional_code', 'location_description',
        'employer', 'sector', 'salary', 'amount', 'term_years',
        'legal_form', 'commercial_name', 'commercial_registration',
        'commercial_city', 'license_expiry_hijri', 'establishment_date_hijri',
        'owner_name', 'owner_id_number', 'nationality', 'birth_date', 'id_expiry_date',
        'guarantee_types', 'guarantee_details', 'documents',
        'status', 'notes',
    ];

    protected $casts = [
        'guarantee_types'   => 'array',
        'guarantee_details' => 'array',
        'documents'         => 'array',
        'birth_date'        => 'date',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function bank()    { return $this->belongsTo(Bank::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function offer()   { return $this->belongsTo(Offer::class); }
}
