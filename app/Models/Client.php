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
        'payment_status',
    ];

    protected $casts = [
        'subscription_date' => 'date',
        'next_payment_date' => 'date',
    ];

    public function payments()
    {
        // todos los registros donde 'client_id' sea igual al 'id' de este cliente."
        return $this->hasMany(Payment::class);
    }

    public function getServiceDisplayNameAttribute()
{
    switch ($this->service_type) {
        case 'vm_eats':
            return 'VM Eats';
        case 'vm_tech':
            return 'VM Technologies';
        default:
            return ucfirst(str_replace('_', ' ', $this->service_type)); // Capitaliza y reemplaza guiones
    }
}
}