<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStore;
use App\Http\Requests\User\UserUpdate;
use App\Models\User;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index(): Collection
    {
        $users = User::with('roles')->get();

        $users = $users->map(function ($user) {
            return [
                ...$user->toArray(),
                'roles' => $user->roles->pluck('name')->toArray(),
            ];
        });

        return $users;
    }

    public function store(UserStore $request)
    {
        $inputs = $request->validated();

        $user = User::create($inputs);

        return response()->json([
            'data' => $user,
        ], 201);
    }

    public function show(string $id): User
    {
        return User::find($id);
    }

    public function update(UserUpdate $request, string $id)
    {
        $inputs = $request->validated();

        $user = User::find($id)->update($inputs);

        return response()->json([
            'data' => $user,
        ]);
    }

    public function destroy(string $id)
    {
        User::find($id)->delete();

        return response()->json();
    }
}
