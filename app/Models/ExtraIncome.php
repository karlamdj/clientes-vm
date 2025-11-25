<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'concept',
        'amount',
        'income_date',
        'notes',
    ];

    protected $casts = [
        'income_date' => 'date', 
    ];
}
