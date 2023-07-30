<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('id', 'ASC')->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        $user = $this->model->where('id', $id)->first();
        return $user ? $user : $user = null;
    }

    public function update(array $data, $id)
    {
        $user = $this->model->find($id);
        $user->update($data);
        return $user;
    }

    public function destroy($id)
    {
        $user = $this->model->find($id);
        return $user ? $user->delete() : null;
    }
}
