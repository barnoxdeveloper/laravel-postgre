<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userService->index();
        return ResponseFormatter::success(
            $data,
            'Success Get Data User!'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return ResponseFormatter::error(
                ['errors' => $validator->errors()],
                'Validation Error!',
                422
            );
        }
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);
        $user = $this->userService->store($data);
        return ResponseFormatter::success(
            $user,
            'User created successfully!'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userService->show($id);
        if (!$user) {
            return ResponseFormatter::error(
                ['error' => 'User Not Found, ID : '.$id],
                'User Not Found, ID : '.$id,
                401
            );
        }
        return ResponseFormatter::success(
            $user,
            'Success Get Data User ID : '.$id
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return ResponseFormatter::error(
                ['errors' => $validator->errors()],
                'Validation Error!',
                422
            );
        }
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);
        $user = $this->userService->update($data, $id);
        return ResponseFormatter::success(
            $user,
            'User updated successfully!'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->userService->destroy($id);
        if (!$user) {
            return ResponseFormatter::error(
                ['error' => 'User Not Found, ID : '.$id],
                'User Not Found, ID : '.$id,
                401
            );
        }
        return ResponseFormatter::success(
            $user,
            'User deleted successfully, ID : '.$id
        );
    }
}
