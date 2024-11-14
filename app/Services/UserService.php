<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function create(array $payload)
    {
        $user = User::create($payload);

        return[
            'data' => $user,
            'message' => 'user added successfully!',
            'status' => 201,
        ];
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return[
            'data' => $user,
            'message' => 'user retrieved successfully!',
            'status' => 200,
        ];
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return[
            'message' => 'user deleted successfully!',
            'status' => 200
        ];
    }

    public function all()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return[
            'users' => $users,
            'message' => 'users list',
            'status' => 200,
        ];
    }

    public function edit($id, array $payload)
    {
        $user = User::findOrFail($id);

        $user->update($payload);
        return[
            'status' => 200,
            'message' => 'user updated successfully',
            'user' => $user
        ];
    }
}