<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Resource controller for managing external links and resources
 * Handles CRUD operations for useful resources and links
 */
class ResourceController extends Controller
{
    /**
     * Display a listing of resources
     */
    public function index(Request $request)
    {
        $query = Resource::query();

        // Filter by category if provided
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Search by title or description
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Only show active resources for regular users
        if (!auth()->user()->isAdmin()) {
            $query->where('is_active', true);
        }

        $resources = $query->ordered()
                          ->paginate($request->get('per_page', 15));

        return response()->json([
            'data' => $resources->items(),
            'meta' => [
                'current_page' => $resources->currentPage(),
                'last_page' => $resources->lastPage(),
                'per_page' => $resources->perPage(),
                'total' => $resources->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
            'category' => 'required|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $resource = Resource::create($request->all());

        return response()->json([
            'message' => 'Resource created successfully',
            'data' => $resource
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource
     */
    public function show(Resource $resource)
    {
        return response()->json(['data' => $resource]);
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'sometimes|required|url',
            'category' => 'sometimes|required|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $resource->update($request->all());

        return response()->json([
            'message' => 'Resource updated successfully',
            'data' => $resource
        ]);
    }

    /**
     * Remove the specified resource
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return response()->json([
            'message' => 'Resource deleted successfully'
        ]);
    }

    /**
     * Get available categories
     */
    public function categories()
    {
        $categories = Resource::select('category')
                             ->distinct()
                             ->whereNotNull('category')
                             ->orderBy('category')
                             ->pluck('category');

        return response()->json(['data' => $categories]);
    }
}
