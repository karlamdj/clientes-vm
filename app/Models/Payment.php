<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'client_id',
        'amount',
        'payment_date',
    ];

    // --- AÑADE ESTE BLOQUE ---
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'payment_date' => 'date', // Le dice a Laravel que esta columna es una fecha
    ];
    // --- FIN DEL BLOQUE ---

    /**
     * Define la relación: Un Pago pertenece a un Cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}