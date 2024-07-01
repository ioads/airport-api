<?php

namespace App\Repositories;

use App\Models\Ticket;

interface TicketRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update(Ticket $ticket, array $data);

    public function updateOrCreate(array $find, array $data);

    public function delete(Ticket $ticket);
}
