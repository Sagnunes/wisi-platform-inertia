<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RolePermissionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function __construct(private readonly RolePermissionService $rolePermissionService) {}

    public function edit(Role $role): \Inertia\Response
    {
        return Inertia::render('role_permission/Edit',
            [
                'permissions' => $this->rolePermissionService->allPermissions(),
                'role' => $this->rolePermissionService->roleWithPermissions($role->id),
            ]
        );
    }

    public function update($roleID, Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->rolePermissionService->syncPermissionToRole($roleID, $request->get('permissions'));

        return to_route('roles.index')->with('success', 'Role permissions assigned successfully.');
    }
}
