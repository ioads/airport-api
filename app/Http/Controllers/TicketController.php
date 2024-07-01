<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Flight;
use App\Models\Ticket;
use App\Repositories\TicketRepositoryInterface;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query();

        if($request->origin_iata) {
            $query->where('origin_iata', '=', $request->origin_iata);
        }
        if($request->destination_iata) {
            $query->where('destination_iata', '=', $request->destination_iata);
        }
        if($request->departure) {
            $query->whereDate('departure', '=', $request->departure);
        }
        if($request->total_price) {
            $query->where('total_price', '=', $request->total_price);
        }

        $query->whereNull('passenger_cpf');

        return response()->json($query->get());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        $data = $request->validated();

        $ticket = $this->ticketRepository->update($ticket, $data);

        return response()->json($ticket);
    }

    public function buy(BuyTicketRequest $request)
    {
        $data = $request->validated();

        return $this->ticketRepository->buy($data);
    }

    public function voucher(string $cpf, Flight $flight)
    {
        $vouchers = $this->ticketRepository->voucher($cpf, $flight);

        return response()->json($vouchers);
    }

    public function baggage(string $ticketCode)
    {
        $vouchers = $this->ticketRepository->baggage($ticketCode);

        return response()->json($vouchers);
    }

    public function ticketsByCpf(string $cpf)
    {
        $tickets = $this->ticketRepository->ticketsByCpf($cpf);

        return response()->json($tickets);
    }

    public function cancel(Request $request)
    {
        $data = $request->all();

        $this->ticketRepository->cancel($data);

        return response()->json('Compra cancelada com sucesso.');
    }
}
