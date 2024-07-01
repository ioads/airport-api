<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTicketRequest;
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
