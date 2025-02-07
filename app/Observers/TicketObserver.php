<?php

namespace App\Observers;

use App\Models\ClassFlight;
use App\Models\Ticket;

class TicketObserver
{
    /**
     * Handle the ClassFlight "created" event.
     */
    public function created(ClassFlight $classFlight): void
    {
        $tickets = [];
        for ($i = 1; $i <= $classFlight->seats; $i++) {
            $tickets[] = [
                'flight_id' => $classFlight->flight_id,
                'class_id' => $classFlight->class_id,
                'code' => $classFlight->flight_id . $classFlight->class_id . $i,
                'total_price' => $classFlight->unit_price,
                'seat_number' => $i,
                'origin_iata' => $classFlight->flight->origin->iata_code,
                'destination_iata' => $classFlight->flight->destination->iata_code,
                'departure' => $classFlight->flight->departure,
            ];
        }
        Ticket::insert($tickets);        
    }
}
