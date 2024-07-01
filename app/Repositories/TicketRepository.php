<?php

namespace App\Repositories;

use App\Models\Ticket;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
}
