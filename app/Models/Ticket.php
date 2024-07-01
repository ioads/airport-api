<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable  = [
        'flight_id',
        'class_id',
        'seat_number',
        'code',
        'passenger_name',
        'passenger_cpf',
        'passenger_birthdate',
        'total_price'
    ];
}
