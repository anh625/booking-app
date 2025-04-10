<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Models\Venue;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\IVenueService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class VenueController
 *
 * This controller handles CRUD operations for Venues.
 * It includes authorization checks for create, update, and delete actions.
 */
class VenueController extends Controller
{
    use ApiResponse;
    use AuthorizesRequests;

    /**
     * The service that handles venue business logic.
     *
     * @var IVenueService
     */
    private IVenueService $venueService;

    /**
     * VenueController constructor.
     *
     * @param IVenueService $venueService
     */
    public function __construct(IVenueService  $venueService) {
        $this->venueService = $venueService;
    }

    /**
     * Get a paginated list of venues.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $perPage = intval(request('per_page', 2));
        $perPage = max(1, min($perPage, 20));

        return $this->successResponse($this->venueService->show($perPage),"List of Venues"
        );
    }

    /**
     * Store a new venue.
     * Only authorized users (admin or owner) can perform this action.
     *
     * @param VenueRequest $request
     * @return JsonResponse
     */
    public function store(VenueRequest $request): JsonResponse {
        $this->authorize('create', Venue::class);
        $user = $request->user();
        return $this->successResponse($this->venueService->add($request), "Saved Venue");
    }

    /**
     * Find a venue by its ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function findById(string $id): JsonResponse {
        return $this->successResponse($this->venueService->findById($id), "Venue by ID");
    }

    /**
     * Update an existing venue by ID.
     * Only the venue owner can update it.
     *
     * @param string $id
     * @param VenueRequest $request
     * @return JsonResponse
     */
    public function update(string $id, VenueRequest $request): JsonResponse {
        $venue = $this->venueService->findById($id);
        $this->authorize('update', $venue);
        $data = $this->venueService->update($id, $request);
        if (!$data) {
            return $this->errorResponse("Updated Venue Failed", 500);
        }
        return $this->successResponse($data, "Updated Venue by id", 200);
    }

    /**
     * Delete a venue by ID.
     * Only the venue owner can delete it.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse {
        $venue = $this->venueService->findById($id);
        $this->authorize('delete', $venue);
        $data = $this->venueService->delete($id);
        if (!$data) {
            return $this->errorResponse("Deleted Venue Failed", 500);
        }
        return $this->successResponse($data, "Deleted Venue by id");
    }
}
