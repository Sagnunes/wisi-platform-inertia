<?php

namespace App\Http\Controllers;

use App\DTOs\Status\StatusDTO;
use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Services\StatusService;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function __construct(
        private readonly StatusService $statusService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('statuses/Index', ['statuses' => $this->statusService->allStatuses()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->statusService->create(StatusDTO::fromRequest($request->validated()));
        return to_route('statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status): \Inertia\Response
    {
        return Inertia::render('statuses/Show', ['status' => $status]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status): \Inertia\Response
    {
        return Inertia::render('statuses/Edit', ['status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status): \Illuminate\Http\RedirectResponse
    {
        $this->statusService->update($status, StatusDTO::fromRequest($request->validated()));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status): \Illuminate\Http\RedirectResponse
    {
        $this->statusService->delete($status);

        return to_route('statuses.index');
    }
}
