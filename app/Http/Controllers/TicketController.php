<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Flight;
use App\Models\Ticket;
use App\Repositories\TicketRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/tickets",
     *      operationId="getTicketsList",
     *      tags={"Tickets"},
     *      summary="Get list of tickets",
     *      description="Returns list of tickets",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
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
            $date1 = Carbon::parse($request->departure);
            $date2 = Carbon::now();

            if($date1 < $date2)  {
                return response()->json(['success' => false, 'message' => 'Não é permitido filtrar uma data anterior a data de hoje.']);
            }
            $query->whereDate('departure', '=', $request->departure);
        }
        if($request->total_price) {
            $query->where('total_price', '=', $request->total_price);
        }

        $query->whereNull('passenger_cpf');

        return response()->json($query->get());
    }

    /**
     * @OA\Put(
     *      path="/api/tickets/{ticket}",
     *      operationId="updateTicket",
     *      tags={"Tickets"},
     *      summary="Update ticket",
     *      description="Update a ticket",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Update a Ticket",
    *          @OA\JsonContent(
    *              @OA\Property(property="total_price", type="float", example="1800.99")
    *          )
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        $data = $request->validated();

        $ticket = $this->ticketRepository->update($ticket, $data);

        return response()->json($ticket);
    }

    /**
     * @OA\Post(
     *      path="/api/tickets/buy",
     *      operationId="buyTicket",
     *      tags={"Tickets"},
     *      summary="Buy Ticket",
     *      description="Buy ticket",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Buy Ticket",
    *          @OA\JsonContent(
    *              @OA\Property(property="flight_id", type="string", example="1"),
    *              @OA\Property(property="buyer_name", type="string", example="João Pedro"),
    *              @OA\Property(property="buyer_cpf", type="string", example="11122233344"),
    *              @OA\Property(property="buyer_birthdate", type="date", example="1993-02-12"),
    *              @OA\Property(property="buyer_email", type="string", format="email", example="joaopedro@airport.com"),
    *              @OA\Property(property="passengers", type="array", 
    *                  @OA\Items(
    *                      @OA\Property(property="class_id", type="integer", example=1),
    *                      @OA\Property(property="seat_number", type="integer", example="1"),
    *                      @OA\Property(property="passenger_name", type="string", example="João Pedro"),
    *                      @OA\Property(property="passenger_cpf", type="string", example="11122233344"),
    *                      @OA\Property(property="passenger_birthdate", type="date", example="1993-02-12"),
    *                      @OA\Property(property="check_baggage", type="boolean", example="true"),
    *                  ),
    *              ),
    *          )
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function buy(BuyTicketRequest $request)
    {
        $data = $request->validated();

        return $this->ticketRepository->buy($data);
    }

    /**
     * @OA\Get(
     *      path="/api/tickets/voucher/{buyerCpf}/{flight}",
     *      operationId="getVoucher",
     *      tags={"Tickets"},
     *      summary="Get voucher of ticket",
     *      description="Returns voucher of ticket",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function voucher(string $cpf, Flight $flight)
    {
        $vouchers = $this->ticketRepository->voucher($cpf, $flight);

        return response()->json($vouchers);
    }

    /**
     * @OA\Get(
     *      path="/api/tickets/baggage/{ticketCode}",
     *      operationId="getBaggageTag",
     *      tags={"Tickets"},
     *      summary="Get voucher of baggage ticket",
     *      description="Returns baggage tag of ticket",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function baggage(string $ticketCode)
    {
        $vouchers = $this->ticketRepository->baggage($ticketCode);

        return response()->json($vouchers);
    }

    /**
     * @OA\Get(
     *      path="/api/tickets/buyer/{buyerCpf}",
     *      operationId="getTicketsByCpf",
     *      tags={"Tickets"},
     *      summary="Get tickets by buyer",
     *      description="Get tickets by buyer",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function ticketsByCpf(string $cpf)
    {
        $tickets = $this->ticketRepository->ticketsByCpf($cpf);

        return response()->json($tickets);
    }

    /**
     * @OA\Post(
     *      path="/api/tickets/cancel",
     *      operationId="cancelTickets",
     *      tags={"Tickets"},
     *      summary="Cancel Tickets",
     *      description="Cancel tickets",
    *      @OA\RequestBody(
    *          required=true,
    *          description="Cancel Tickets",
    *          @OA\JsonContent(
    *              @OA\Property(property="flightId", type="string", example="1"),
    *              @OA\Property(property="buyerCpf", type="string", example="11122233344"),
    *          )
    *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function cancel(Request $request)
    {
        $data = $request->all();

        $this->ticketRepository->cancel($data);

        return response()->json('Compra cancelada com sucesso.');
    }
}
