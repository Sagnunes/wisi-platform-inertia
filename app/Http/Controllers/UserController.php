<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Services\StatusService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly StatusService $statusService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('users/Index',
            [
                'users' => $this->userService->allUsers(),
                'can' => [
                    'manage-statuses' => auth()->user()->can('manage', Status::class),
                    'manage-roles' => auth()->user()->can('manage', Role::class),
                    'manage-permissions' => auth()->user()->can('manage', Permission::class),
                ],
            ]);
    }

    public function updateStatus(Request $request, User $user)
    {
        $status = $this->statusService->findOne($request->status_id);
        $this->userService->updateStatus($user, $status);

        return redirect()->back()->with('success', 'Status updated');
    }

    public function assignRoles(Request $request, User $user)
    {
        $this->userService->assignRoles($user, $request->role_ids);

        return redirect()->back()->with('success', 'Roles assigned');
    }
}
