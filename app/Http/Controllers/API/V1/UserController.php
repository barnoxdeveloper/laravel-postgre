<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userRepository->index();
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
                ['error' => $validator->errors()], 
                'Validation Error!', 
                401
            ); 
        }
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];
    
        $user = $this->userRepository->store($userData);
    
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
        $data = $this->userRepository->show($id);
        return ResponseFormatter::success(
            $data,
            'Success Get Data User ID : '.$id
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
    
        if ($request->has('password')) {
            $userData['password'] = bcrypt($request->input('password'));
        }
    
        $user = $this->userRepository->update($id, $userData);
    
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
        $user = $this->userRepository->destroy($id);

        return ResponseFormatter::success(
            $user,
            'User deleted successfully!'
        );
    }
}
