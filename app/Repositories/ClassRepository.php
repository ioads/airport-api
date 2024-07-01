<?php

namespace App\Repositories;

use App\Models\TypeClass;
use Illuminate\Database\Eloquent\Collection;

class ClassRepository implements ClassRepositoryInterface
{
    protected TypeClass $model;

    public function __construct(TypeClass $class)
    {
        $this->model = $class;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
