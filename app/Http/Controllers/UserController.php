<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Services\StatusService;
use App\Services\UserService;
use App\Services\UserStatusService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly UserService $userService,
        private readonly StatusService $statusService,
        private readonly UserStatusService $userStatusService,
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
        $status = $this->statusService->findOne($request->status);

        $this->userStatusService->updateStatus($user, $status);

        return redirect()->back()->with('success', 'Status updated');
    }

    public function assignRoles(Request $request, User $user)
    {
        $this->userService->assignRoles($user, $request->role_ids);

        return redirect()->back()->with('success', 'Roles assigned');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $currentPage = request()->input('page', 1);

        $this->userService->deleteUser($user);

        return to_route('users.index', ['page' => $currentPage])
            ->withSuccess('User deleted successfully.')
            ->with('preserveScroll', true);
    }
}
