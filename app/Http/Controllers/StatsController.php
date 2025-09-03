<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Statistics controller for dashboard analytics and metrics
 * Provides comprehensive statistics for the INSBU Statistics Portal
 */
class StatsController extends Controller
{
    /**
     * Get dashboard overview statistics
     */
    public function dashboard(Request $request)
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::active()->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
                'growth_percentage' => $this->calculateGrowthPercentage(User::class),
            ],
            'news' => [
                'total' => News::count(),
                'published' => News::status('published')->count(),
                'new_this_month' => News::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
                'growth_percentage' => $this->calculateGrowthPercentage(News::class),
            ],
            'documents' => [
                'total' => Document::count(),
                'total_downloads' => Document::sum('download_count'),
                'new_this_month' => Document::whereMonth('created_at', now()->month)
                                           ->whereYear('created_at', now()->year)
                                           ->count(),
                'growth_percentage' => $this->calculateGrowthPercentage(Document::class),
                'total_size_gb' => round(Document::sum('file_size') / 1024 / 1024 / 1024, 2),
            ],
            'system' => [
                'uptime' => '99.9%',
                'server_load' => '45%',
                'storage_used' => '2.4 GB',
                'last_backup' => now()->subHours(2)->toISOString(),
            ],
        ];

        return response()->json($stats);
    }

    /**
     * Get user-related statistics
     */
    public function users(Request $request)
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'role_distribution' => [
                'admin' => User::role('admin')->count(),
                'editor' => User::role('editor')->count(),
                'user' => User::role('user')->count(),
            ],
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'avg_login_frequency' => $this->calculateAverageLoginFrequency(),
        ];

        return response()->json($stats);
    }

    /**
     * Get news-related statistics
     */
    public function news(Request $request)
    {
        $stats = [
            'total_articles' => News::count(),
            'published_articles' => News::status('published')->count(),
            'draft_articles' => News::status('draft')->count(),
            'pending_articles' => News::status('pending')->count(),
            'archived_articles' => News::status('archived')->count(),
            'avg_reading_time' => round(News::avg('reading_time'), 1),
            'most_active_authors' => $this->getMostActiveAuthors(),
            'categories' => $this->getNewsCategories(),
        ];

        return response()->json($stats);
    }

    /**
     * Get document-related statistics
     */
    public function documents(Request $request)
    {
        $stats = [
            'total_documents' => Document::count(),
            'public_documents' => Document::where('is_public', true)->count(),
            'private_documents' => Document::where('is_public', false)->count(),
            'total_downloads' => Document::sum('download_count'),
            'total_size_bytes' => Document::sum('file_size'),
            'avg_file_size_mb' => round(Document::avg('file_size') / 1024 / 1024, 2),
            'most_downloaded' => $this->getMostDownloadedDocuments(),
            'file_types' => $this->getFileTypeDistribution(),
            'categories' => $this->getDocumentCategories(),
        ];

        return response()->json($stats);
    }

    /**
     * Get monthly activity data for charts
     */
    public function monthlyActivity(Request $request)
    {
        $months = $request->get('months', 6);
        
        $activity = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('Y-m');
            $monthName = $date->format('M');
            
            $activity[] = [
                'month' => $monthName,
                'users' => User::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count(),
                'news' => News::whereYear('created_at', $date->year)
                             ->whereMonth('created_at', $date->month)
                             ->count(),
                'documents' => Document::whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->count(),
                'downloads' => Document::whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->sum('download_count'),
            ];
        }

        return response()->json($activity);
    }

    /**
     * Get role distribution data
     */
    public function roleDistribution(Request $request)
    {
        $distribution = User::select('role', DB::raw('count(*) as count'))
                           ->groupBy('role')
                           ->get()
                           ->map(function ($item) {
                               return [
                                   'role' => ucfirst($item->role),
                                   'count' => $item->count,
                                   'percentage' => round(($item->count / User::count()) * 100, 1),
                               ];
                           });

        return response()->json($distribution);
    }

    /**
     * Calculate growth percentage compared to previous month
     */
    private function calculateGrowthPercentage($model)
    {
        $thisMonth = $model::whereMonth('created_at', now()->month)
                           ->whereYear('created_at', now()->year)
                           ->count();
        
        $lastMonth = $model::whereMonth('created_at', now()->subMonth()->month)
                           ->whereYear('created_at', now()->subMonth()->year)
                           ->count();
        
        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1);
    }

    /**
     * Calculate average login frequency
     */
    private function calculateAverageLoginFrequency()
    {
        $avgLogins = User::where('login_count', '>', 0)->avg('login_count');
        return round($avgLogins, 1);
    }

    /**
     * Get most active authors
     */
    private function getMostActiveAuthors()
    {
        return User::withCount('news')
                   ->having('news_count', '>', 0)
                   ->orderBy('news_count', 'desc')
                   ->limit(5)
                   ->get(['id', 'name', 'news_count']);
    }

    /**
     * Get news categories with counts
     */
    private function getNewsCategories()
    {
        return News::select('category', DB::raw('count(*) as count'))
                   ->whereNotNull('category')
                   ->groupBy('category')
                   ->orderBy('count', 'desc')
                   ->get();
    }

    /**
     * Get most downloaded documents
     */
    private function getMostDownloadedDocuments()
    {
        return Document::select('id', 'title', 'download_count')
                      ->orderBy('download_count', 'desc')
                      ->limit(5)
                      ->get();
    }

    /**
     * Get file type distribution
     */
    private function getFileTypeDistribution()
    {
        return Document::select(DB::raw('
                CASE 
                    WHEN file_type LIKE "%pdf%" THEN "PDF"
                    WHEN file_type LIKE "%word%" OR file_type LIKE "%document%" THEN "Word"
                    WHEN file_type LIKE "%excel%" OR file_type LIKE "%spreadsheet%" OR file_type LIKE "%csv%" THEN "Excel/CSV"
                    WHEN file_type LIKE "%image%" THEN "Image"
                    ELSE "Other"
                END as type
            '), DB::raw('count(*) as count'))
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get document categories with counts
     */
    private function getDocumentCategories()
    {
        return Document::select('category', DB::raw('count(*) as count'))
                      ->whereNotNull('category')
                      ->groupBy('category')
                      ->orderBy('count', 'desc')
                      ->get();
    }
}
