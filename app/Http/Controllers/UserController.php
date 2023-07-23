<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStore;
use App\Http\Requests\User\UserUpdate;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(5);

        $users->getCollection()->transform(function ($user) {
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

        $roles = Role::whereIn('id', $inputs['roles'])->pluck('name');

        $user->assignRoles($roles);

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