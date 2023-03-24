<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $user): bool
    {
        return can('users.list', $user);
    }

    public function show(User $user): bool
    {
        return can('users.show', $user);
    }

    public function create(User $user): bool
    {
        return can('users.create', $user);
    }

    public function update(User $user): bool
    {
        return can('users.update', $user);
    }

    public function delete(User $user): bool
    {
        return can('users.delete', $user);
    }
}
