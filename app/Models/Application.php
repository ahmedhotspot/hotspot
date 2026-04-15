<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'bank_id', 'service_id', 'offer_id',
        'full_name', 'national_id', 'email', 'phone', 'city',
        'employer', 'sector', 'salary', 'amount', 'term_years',
        'status', 'notes',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function bank()    { return $this->belongsTo(Bank::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function offer()   { return $this->belongsTo(Offer::class); }
}
