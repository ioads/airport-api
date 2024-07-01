<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketRepositoryInterface
{
    protected Ticket $model;

    public function __construct(Ticket $flight)
    {
        $this->model = $flight;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);        
    }

    public function update(Ticket $ticket, array $data)
    {
        $ticket->update($data);
        return $ticket;
    }

    public function updateOrCreate(array $find, array $data)
    {
        return $this->model->updateOrCreate($find, $data);
    }

    public function delete(Ticket $ticket): int
    {
        return $ticket->delete();
    }

    public function buy($data)
    {
        foreach($data['passengers'] as $passenger) {
            $ticket = $this->model->where('seat_number', '=', $passenger['seat_number'])
                        ->where('flight_id', '=', $data['flight_id'])
                        ->first();
            
            $ticket->update([
                'buyer_name' => $data['buyer_name'],
                'buyer_cpf' => $data['buyer_cpf'],
                'buyer_birthdate' => $data['buyer_birthdate'],
                'buyer_email' => $data['buyer_email'],
                'check_baggage' => isset($passenger['check_baggage']) ? $passenger['check_baggage'] : false,
                'passenger_name' => $passenger['passenger_name'],
                'passenger_cpf' => $passenger['passenger_cpf'],
                'passenger_birthdate' => $passenger['passenger_birthdate'],
                'total_price' => isset($passenger['check_baggage']) ? $ticket->total_price + ($ticket->total_price * 0.1) : $ticket->total_price
            ]);
        }

        return $this->model->where('flight_id', '=', $data['flight_id'])->where('buyer_cpf', '=', $data['buyer_cpf'])->get();
    }

    public function voucher(string $cpf, string $flightId)
    {
        $tickets = $this->model->where('buyer_cpf', '=', $cpf)->where('flight_id', '=', $flightId)->get();

        $vouchers = [];

        foreach($tickets as $ticket) {
            $vouchers[] = [
                'ticket_code' => $ticket->code,
                'flight_code' => $ticket->flight->code,
                'origin' => $ticket->origin_iata,
                'destination' => $ticket->destination_iata,
                'passenger_name' => $ticket->passenger_name,
                'passenger_cpf' => $ticket->passenger_cpf,
                'check_baggage'=> $ticket->check_baggage ? 'Sim' : 'Não'
            ];
        }

        return $vouchers;
    }
}
