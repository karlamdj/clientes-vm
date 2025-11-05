<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'company',
        'phone_number',
        'service_type',
        'payment_amount',
        'subscription_date',
        'next_payment_date',
    ];
}
