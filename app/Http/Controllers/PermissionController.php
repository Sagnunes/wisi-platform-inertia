<?php

namespace App\Http\Controllers;

use App\DTOs\Permission\PermissionDTO;
use App\Http\Requests\Permissions\StorePermissionRequest;
use App\Http\Requests\Permissions\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly PermissionService $permissionService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $this->authorize('manage', Permission::class);

        $canManage = Auth::user()->can('manage', Permission::class);

        return Inertia::render('permissions/Index',
            [
                'permissions' => $this->permissionService->allPermissionsPaginated(),
                'can' => [
                    'create' => $canManage,
                    'edit' => $canManage,
                    'delete' => $canManage,
                ],
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('manage', Permission::class);

        $this->permissionService->create(PermissionDTO::fromRequest($request->validated()));

        return to_route('permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): \Inertia\Response
    {
        $this->authorize('manage', Permission::class);

        return Inertia::render('permissions/Show', ['permission' => $permission]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): \Inertia\Response
    {
        $this->authorize('manage', Permission::class);

        return Inertia::render('permissions/Edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('manage', Permission::class);

        $this->permissionService->update($permission, PermissionDTO::fromRequest($request->validated()));

        return to_route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('manage', Permission::class);

        $currentPage = request()->input('page', 1);

        $this->permissionService->delete($permission);

        return to_route('permissions.index', ['page' => $currentPage])
            ->with('success', 'Permission deleted successfully.')
            ->with('preserveScroll', true);
    }
}
