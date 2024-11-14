<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->validated());
        return response($user, $user['status']);
    }

    public function user($id)
    {
        $user = $this->userService->show($id);
        return response($user, $user['status']);
    }

    public function delete($id)
    {
        $user = $this->userService->destroy($id);
        return response($user, $user['status']);
    }

    public function get()
    {
        $users = $this->userService->all();
        return response($users, $users['status']);
    }
    public function update($id, Request $request)
    {
        $user = $this->userService->edit($id, $request->all());
        return response($user, $user['status']);
    }
}
