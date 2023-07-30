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
                'roles' => $user->roles->toArray(),
            ];
        });

        return $users;
    }

    public function store(UserStore $request)
    {
        $inputs = $request->validated();
        $inputs['password'] = bcrypt($inputs['password']);
        $user = User::create($inputs);
        foreach ($inputs['roles'] as $role) {
            $role = Role::find($role);
            $user->assignRole($role->name);
        }

        return response()->json([
            'data' => $user,
        ], 201);
    }

    public function show(string $id): User
    {
        return User::with('roles')->findOrFail($id);
    }

    public function update(UserUpdate $request, string $id)
    {
        $inputs = $request->validated();

        $user = User::findOrFail($id);

        foreach ($inputs['roles'] as $role) {
            $role = Role::find($role);
            $user->assignRole($role->name);
        }

        $user->update($inputs);

        return response()->json([
            'data' => $user,
        ]);
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return response()->json();
    }
}