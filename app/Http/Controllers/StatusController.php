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
        $this->authorize('viewAny', Status::class);

        return Inertia::render('statuses/Index',
            [
                'statuses' => $this->statusService->allStatusesPaginated(),
                'can' => [
                    'create'=> Auth::user()->can('create', Status::class),
                    'edit'=> Auth::user()->can('edit', Status::class),
                    'delete'=> Auth::user()->can('delete', Status::class),
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request): RedirectResponse
    {
        $this->statusService->create(StatusDTO::fromRequest($request->validated()));

        return to_route('statuses.index')->with('success', 'Status created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status): Response
    {
        return Inertia::render('statuses/Show', ['status' => $status]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status): Response
    {
        return Inertia::render('statuses/Edit', ['status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status): RedirectResponse
    {
        $this->statusService->update($status, StatusDTO::fromRequest($request->validated()));

        return to_route('statuses.index')->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status): RedirectResponse
    {
        $currentPage = request()->input('page', 1);

        $this->statusService->delete($status);

        return to_route('statuses.index', ['page' => $currentPage])
            ->with('success', 'Status deleted successfully.')
            ->with('preserveScroll', true);
    }
}
