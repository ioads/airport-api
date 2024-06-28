<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassFlight extends Model
{
    use HasFactory;

    protected $table = 'classes_flights';

    protected $fillable = [
        'class_id',
        'flight_id',
        'seats',
        'unit_price'
    ];
}
