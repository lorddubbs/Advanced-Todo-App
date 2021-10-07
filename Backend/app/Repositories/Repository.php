<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;

interface Repository
{
    public function find(int $id);
    public function create(array $data);
    public function update($id, array $data);
    public function all();
    public function delete(int $id);
}
