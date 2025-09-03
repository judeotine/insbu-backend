<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Admin controller for user and system management
 * Provides administrative functions with role-based access control
 */
class AdminController extends Controller
{
    /**
     * Constructor - ensure only admins can access these methods
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->user() || !$request->user()->isAdmin()) {
                return response()->json([
                    'message' => 'Unauthorized. Admin access required.'
                ], Response::HTTP_FORBIDDEN);
            }
            return $next($request);
        });
    }

    /**
     * Get all users with pagination
     */
    public function getUsers(Request $request)
    {
        $perPage = $request->get('limit', 15);
        
        $query = User::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->has('role')) {
            $query->role($request->role);
        }
        
        // Filter by status
        if ($request->has('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json($users);
    }

    /**
     * Get a specific user by ID
     */
    public function getUser(User $user)
    {
        return response()->json($user);
    }

    /**
     * Create a new user
     */
    public function createUser(Request $request)
    {
        // Validate user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,editor,admin',
            'is_active' => 'sometimes|boolean',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->get('is_active', true),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a user's information
     */
    public function updateUser(Request $request, User $user)
    {
        // Validate update data
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'sometimes|in:user,editor,admin',
            'is_active' => 'sometimes|boolean',
            'password' => 'sometimes|string|min:8',
        ]);

        // Prepare update data
        $updateData = $request->only(['name', 'email', 'role', 'is_active']);
        
        // Hash password if provided
        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($updateData);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * Update a user's role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,editor,admin',
        ]);

        $user->update(['role' => $request->role]);

        return response()->json([
            'message' => 'User role updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->update(['is_active' => $request->is_active]);

        $status = $request->is_active ? 'activated' : 'deactivated';

        return response()->json([
            'message' => "User {$status} successfully",
            'user' => $user,
        ]);
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        // Prevent deletion of the last admin
        if ($user->isAdmin()) {
            $adminCount = User::role('admin')->active()->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'message' => 'Cannot delete the last active admin user.'
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    /**
     * Get available roles
     */
    public function getRoles()
    {
        return response()->json(User::ROLES);
    }

    /**
     * Get system statistics
     */
    public function getStatistics()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::active()->count(),
                'inactive' => User::where('is_active', false)->count(),
                'admin' => User::role('admin')->count(),
                'editor' => User::role('editor')->count(),
                'user' => User::role('user')->count(),
            ],
            'news' => [
                'total' => News::count(),
                'published' => News::status('published')->count(),
                'draft' => News::status('draft')->count(),
                'pending' => News::status('pending')->count(),
            ],
            'documents' => [
                'total' => Document::count(),
                'public' => Document::where('is_public', true)->count(),
                'private' => Document::where('is_public', false)->count(),
                'total_size' => Document::sum('file_size'),
                'total_downloads' => Document::sum('download_count'),
            ],
            'activity' => [
                'users_this_month' => User::whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->count(),
                'news_this_month' => News::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
                'documents_this_month' => Document::whereMonth('created_at', now()->month)
                                                 ->whereYear('created_at', now()->year)
                                                 ->count(),
            ],
        ];

        return response()->json($stats);
    }

    /**
     * Get recent system activity logs
     */
    public function getSystemLogs(Request $request)
    {
        $perPage = $request->get('limit', 20);
        
        // This is a simplified implementation
        // In a real application, you would have a proper logging system
        $logs = collect([
            [
                'id' => 1,
                'level' => 'info',
                'message' => 'User login successful',
                'user_id' => 1,
                'created_at' => now()->subMinutes(5),
            ],
            [
                'id' => 2,
                'level' => 'warning',
                'message' => 'Failed login attempt',
                'user_id' => null,
                'created_at' => now()->subMinutes(15),
            ],
            [
                'id' => 3,
                'level' => 'info',
                'message' => 'Document uploaded',
                'user_id' => 2,
                'created_at' => now()->subHours(1),
            ],
        ]);

        return response()->json([
            'data' => $logs,
            'total' => $logs->count(),
            'per_page' => $perPage,
            'current_page' => 1,
        ]);
    }

    /**
     * Get user activity statistics
     */
    public function getUserActivity(Request $request)
    {
        $days = $request->get('days', 30);
        
        // Get user registration statistics for the last N days
        $registrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get login statistics (simplified - would need proper tracking in real app)
        $logins = User::selectRaw('DATE(last_login_at) as date, COUNT(*) as count')
            ->whereNotNull('last_login_at')
            ->where('last_login_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'registrations' => $registrations,
            'logins' => $logins,
        ]);
    }
}
