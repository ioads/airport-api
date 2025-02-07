<?php

namespace App\Repositories;

use App\Models\ClassFlight;
use App\Models\Flight;
use App\Models\Ticket;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketRepositoryInterface
{
    protected Ticket $model;
    protected ClassFlight $classFlight;

    public function __construct(Ticket $ticket, ClassFlight $classFlight)
    {
        $this->model = $ticket;
        $this->classFlight = $classFlight;
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

    public function voucher(string $cpf, Flight $flight)
    {
        $now = Carbon::now('America/Sao_Paulo');
        $hours = $now->diffInHours(Carbon::parse($flight->departure));

        if($hours < 5) {
            throw new Exception('Somente é permitido executar esta ação em até 5 horas antes do voo.');
        }

        $tickets = $this->model->where('buyer_cpf', '=', $cpf)->where('flight_id', '=', $flight->id)->get();

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

    public function baggage(string $ticketCode)
    {
        $ticket = $this->model->where('code', '=', $ticketCode)->first();

        $now = Carbon::now('America/Sao_Paulo');
        $hours = $now->diffInHours(Carbon::parse($ticket->departure));

        if($hours < 5) {
            throw new Exception('Somente é permitido executar esta ação em até 5 horas antes do voo.');
        }

        if(!$ticket->check_baggage) {
            throw new Exception('Esta passagem não possui despacho de bagagem.');
        }
        
        $ticket->update(['baggage_number' => $ticket->code . $ticket->passenger_cpf]);

        return [
            'ticket_code' => $ticket->code,
            'baggage_number' => $ticket->baggage_number,
            'passenger_name' => $ticket->passenger_name,
            'passenger_cpf' => $ticket->passenger_cpf
        ];
    }

    public function ticketsByCpf(string $cpf)
    {
        return $this->model->where('buyer_cpf', '=', $cpf)->get();
    }

    public function cancel($data)
    {
        $tickets = $this->model->where('buyer_cpf', '=', $data['buyerCpf'])->get();

        foreach($tickets as $ticket) {
            $classFlight = $this->classFlight->where('flight_id', '=', $ticket->flight_id)->where('class_id', '=', $ticket->class_id)->first();

            $ticket->update([
                'passenger_name' => null,
                'passenger_cpf' => null,
                'passenger_birthdate' => null,
                'buyer_name' => null,
                'buyer_cpf' => null,
                'buyer_birthdate' => null,
                'buyer_email' => null,
                'check_baggage' => false,
                'baggage_number' => null,
                'total_price' => $classFlight->unit_price
            ]);
        }
    }
}
