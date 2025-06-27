<?php

namespace App\Http\Controllers;

use App\DTOs\Role\RoleDTO;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('roles/Index', ['roles' => $this->roleService->allRolesPaginated()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->roleService->create(RoleDTO::fromRequest($request->validated()));

        return to_route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): \Inertia\Response
    {
        return Inertia::render('roles/Show', ['roles' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): \Inertia\Response
    {
        return Inertia::render('roles/Edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        $this->roleService->update($role, RoleDTO::fromRequest($request->validated()));

        return to_route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): \Illuminate\Http\RedirectResponse
    {
        $currentPage = request()->input('page', 1);

        $this->roleService->delete($role);

        return to_route('roles.index', ['page' => $currentPage])
            ->with('success', 'Role deleted successfully.')
            ->with('preserveScroll', true);
    }
}
