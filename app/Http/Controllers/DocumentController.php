<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Document controller for managing file uploads and downloads
 * Handles file operations with security and access control
 */
class DocumentController extends Controller
{
    /**
     * Display a listing of documents
     */
    public function index(Request $request)
    {
        $query = Document::with('uploader');

        // Filter by category
        if ($request->has('category')) {
            $query->category($request->category);
        }

        // Search functionality
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Only public documents for regular users
        if (!$request->user()->canManageContent()) {
            $query->public();
        }

        // Pagination
        $perPage = $request->get('limit', 15);
        $documents = $query->latest()->paginate($perPage);

        return response()->json($documents);
    }

    /**
     * Store a newly uploaded document
     */
    public function store(Request $request)
    {
        // Check if user can manage content
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to upload documents.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Validate request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string|max:100',
            'files' => 'required|array|min:1',
            'files.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png,gif', // 10MB max
            'is_public' => 'sometimes|boolean',
        ]);

        $uploadedDocuments = [];

        foreach ($request->file('files') as $file) {
            // Generate unique file name
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Store file in public/documents directory
            $filePath = $file->storeAs('documents', $fileName, 'public');

            // Create document record
            $document = Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'category' => $request->category,
                'uploaded_by' => $request->user()->id,
                'is_public' => $request->get('is_public', true),
            ]);

            $document->load('uploader');
            $uploadedDocuments[] = $document;
        }

        return response()->json([
            'message' => count($uploadedDocuments) . ' document(s) uploaded successfully',
            'documents' => $uploadedDocuments,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified document
     */
    public function show(Request $request, Document $document)
    {
        $document->load('uploader');

        // Check if user can access this document
        if (!$document->is_public && !$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Document not found or access denied.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($document);
    }

    /**
     * Update the specified document metadata
     */
    public function update(Request $request, Document $document)
    {
        // Check if user can manage content
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to edit documents.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Check if user owns the document or is admin
        if ($document->uploaded_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only edit your own documents.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Validate request data
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string|max:100',
            'is_public' => 'sometimes|boolean',
        ]);

        // Update document metadata
        $document->update($request->only([
            'title', 'description', 'category', 'is_public'
        ]));

        $document->load('uploader');

        return response()->json([
            'message' => 'Document updated successfully',
            'document' => $document,
        ]);
    }

    /**
     * Remove the specified document
     */
    public function destroy(Request $request, Document $document)
    {
        // Check if user can manage content
        if (!$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to delete documents.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Check if user owns the document or is admin
        if ($document->uploaded_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only delete your own documents.'
            ], Response::HTTP_FORBIDDEN);
        }

        $document->delete();

        return response()->json([
            'message' => 'Document deleted successfully',
        ]);
    }

    /**
     * Download the specified document
     */
    public function download(Request $request, Document $document)
    {
        // Check if user can access this document
        if (!$document->is_public && !$request->user()->canManageContent()) {
            return response()->json([
                'message' => 'Document not found or access denied.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            return response()->json([
                'message' => 'File not found on server.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Increment download count
        $document->incrementDownloadCount();

        // Return file download response
        return Storage::disk('public')->download(
            $document->file_path,
            $document->original_name
        );
    }

    /**
     * Get recent documents for dashboard
     */
    public function recent(Request $request)
    {
        $limit = $request->get('limit', 5);
        
        $query = Document::with('uploader');
        
        // Only public documents for regular users
        if (!$request->user()->canManageContent()) {
            $query->public();
        }

        $documents = $query->latest()->limit($limit)->get();

        return response()->json($documents);
    }

    /**
     * Get document categories
     */
    public function categories()
    {
        $categories = Document::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json($categories);
    }

    /**
     * Get document statistics
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
            'total' => Document::count(),
            'public' => Document::where('is_public', true)->count(),
            'private' => Document::where('is_public', false)->count(),
            'total_size' => Document::sum('file_size'),
            'total_downloads' => Document::sum('download_count'),
            'this_month' => Document::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get popular documents (most downloaded)
     */
    public function popular(Request $request)
    {
        $limit = $request->get('limit', 10);
        
        $query = Document::with('uploader');
        
        // Only public documents for regular users
        if (!$request->user()->canManageContent()) {
            $query->public();
        }

        $documents = $query->popular()->limit($limit)->get();

        return response()->json($documents);
    }
}
