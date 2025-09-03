<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * News controller for managing articles and posts
 * Handles CRUD operations with role-based permissions
 */
class NewsController extends Controller
{
    /**
     * Display a listing of news articles
     */
    public function index(Request $request)
    {
        $query = News::with('author');

        // Filter by status (only published for regular users)
        if (!$request->user()->canManageContent()) {
            $query->published();
        } elseif ($request->has('status')) {
            $query->status($request->status);
        }

        // Filter by category
        if ($request->has('category')) {
            $query->category($request->category);
        }

        // Search functionality
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Pagination
        $perPage = $request->get('limit', 15);
        $news = $query->latest()->paginate($perPage);

        return response()->json($news);
    }

    /**
     * Store a newly created news article
     */
    public function store(Request $request)
    {
        // Check if user can manage content
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to create news articles.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Validate request data
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'excerpt' => 'sometimes|string|max:500',
            'status' => 'sometimes|in:draft,pending,published,archived',
            'image_url' => 'sometimes|url',
            'category' => 'sometimes|string|max:100',
        ]);

        // Determine status based on user role
        $status = $request->status ?? 'draft';
        
        // If editor is trying to publish, set to pending for admin review
        if ($status === 'published' && $request->user()->isEditor() && !$request->user()->isAdmin()) {
            $status = 'pending';
        }

        // Create news article
        $news = News::create([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'status' => $status,
            'image_url' => $request->image_url,
            'category' => $request->category,
            'author_id' => $request->user()->id,
        ]);

        $news->load('author');

        return response()->json([
            'message' => 'News article created successfully',
            'news' => $news,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified news article
     */
    public function show(Request $request, News $news)
    {
        $news->load('author');

        // Check if user can access this article
        if ($news->status !== 'published' && !$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Article not found or not published.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($news);
    }

    /**
     * Update the specified news article
     */
    public function update(Request $request, News $news)
    {
        // Check if user can manage content
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to edit news articles.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Check if user owns the article or is admin
        if ($news->author_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only edit your own articles.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Validate request data
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'excerpt' => 'sometimes|string|max:500',
            'status' => 'sometimes|in:draft,pending,published,archived',
            'image_url' => 'sometimes|url',
            'category' => 'sometimes|string|max:100',
        ]);

        // Prepare update data
        $updateData = $request->only([
            'title', 'body', 'excerpt', 'image_url', 'category'
        ]);
        
        // Handle status updates based on user role
        if ($request->has('status')) {
            $status = $request->status;
            
            // If editor is trying to publish, set to pending for admin review
            if ($status === 'published' && $request->user()->isEditor() && !$request->user()->isAdmin()) {
                $status = 'pending';
            }
            
            $updateData['status'] = $status;
        }

        // Update news article
        $news->update($updateData);

        $news->load('author');

        return response()->json([
            'message' => 'News article updated successfully',
            'news' => $news,
        ]);
    }

    /**
     * Remove the specified news article
     */
    public function destroy(Request $request, News $news)
    {
        // Check if user can manage content
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to delete news articles.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Check if user owns the article or is admin
        if ($news->author_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only delete your own articles.'
            ], Response::HTTP_FORBIDDEN);
        }

        $news->delete();

        return response()->json([
            'message' => 'News article deleted successfully',
        ]);
    }

    /**
     * Get latest news articles for dashboard
     */
    public function latest(Request $request)
    {
        $limit = $request->get('limit', 5);
        
        $query = News::with('author');
        
        // Only published articles for regular users
        if (!$request->user()->canManageContent()) {
            $query->published();
        }

        $news = $query->latest()->limit($limit)->get();

        return response()->json($news);
    }

    /**
     * Get news categories
     */
    public function categories()
    {
        $categories = News::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json($categories);
    }

    /**
     * Get news statistics
     */
    public function statistics(Request $request)
    {
        // Check if user can access statistics
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to view statistics.'
            ], Response::HTTP_FORBIDDEN);
        }

        $stats = [
            'total' => News::count(),
            'published' => News::status('published')->count(),
            'draft' => News::status('draft')->count(),
            'pending' => News::status('pending')->count(),
            'archived' => News::status('archived')->count(),
            'this_month' => News::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count(),
        ];

        return response()->json($stats);
    }
}
