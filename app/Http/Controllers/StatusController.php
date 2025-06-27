<?php

namespace App\Http\Controllers;

use App\DTOs\Status\StatusDTO;
use App\Http\Requests\Statuses\StoreStatusRequest;
use App\Http\Requests\Statuses\UpdateStatusRequest;
use App\Models\Status;
use App\Services\StatusService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class StatusController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly StatusService $statusService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('manage', Status::class);

        $canManage = Auth::user()->can('manage', Status::class);

        return Inertia::render('statuses/Index',
            [
                'statuses' => $this->statusService->allStatusesPaginated(),
                'can' => [
                    'create' => $canManage,
                    'edit' => $canManage,
                    'delete' => $canManage,
                ],
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request): RedirectResponse
    {
        $this->authorize('manage', Status::class);

        $this->statusService->create(StatusDTO::fromRequest($request->validated()));

        return to_route('statuses.index')->withSuccess('Status created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status): Response
    {
        $this->authorize('manage', Status::class);

        return Inertia::render('statuses/Show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status): Response
    {
        $this->authorize('manage', Status::class);

        return Inertia::render('statuses/Edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status): RedirectResponse
    {
        $this->authorize('manage', Status::class);

        $this->statusService->update($status, StatusDTO::fromRequest($request->validated()));

        return to_route('statuses.index')->withSuccess('Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status): RedirectResponse
    {
        $this->authorize('manage', Status::class);

        $currentPage = request()->input('page', 1);

        $this->statusService->delete($status);

        return to_route('statuses.index', ['page' => $currentPage])
            ->withSuccess('Status deleted successfully.')
            ->with('preserveScroll', true);
    }
}
