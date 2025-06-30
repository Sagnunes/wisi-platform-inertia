<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserRoleController extends Controller
{
    public function edit(User $user)
    {
        return Inertia::render('user_role/Edit', ['user' => $user]);
    }
}
