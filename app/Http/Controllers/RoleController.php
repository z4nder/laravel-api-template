<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();


        return $roles;
    }
}