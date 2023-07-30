<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;

class UserService {

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->repository->store($data);
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function update(array $data, $id)
    {
        // Check if the password is provided in the data
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return $this->repository->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
