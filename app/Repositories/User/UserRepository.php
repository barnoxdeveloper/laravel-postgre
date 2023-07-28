<?php

namespace App\Repositories\User;

interface UserRepository
{
    /**
     * Get all users.
     *
     * @return mixed
     */
    public function index();

    /**
     * Create a new user.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * Get user by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function show($id);

    /**
     * Update user by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete user by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy($id);
}
