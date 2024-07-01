<?php

namespace App\Models;

use App\Observers\TicketObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TicketObserver::class])]
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

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
