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
        'buyer_name',
        'buyer_cpf',
        'buyer_birthdate',
        'buyer_email',
        'passenger_name',
        'passenger_cpf',
        'passenger_birthdate',
        'total_price',
        'origin_iata',
        'destination_iata',
        'departure',
        'check_baggage'
    ];
}
