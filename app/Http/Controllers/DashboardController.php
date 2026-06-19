<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'projects' => [
                'total' => Project::count(),
                'active' => Project::where('status', 'active')->count(),
                'completed' => Project::where('status', 'completed')->count(),
                'total_value' => (float) Project::sum('value'),
            ],
            'products' => Product::count(),
            'categories' => Category::count(),
        ];

        // Get recent projects
        $recentProjects = Project::latest()->take(5)->get();

        // Get projects by status for chart
        $projectsByStatus = [
            'active' => Project::where('status', 'active')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'pending' => Project::where('status', 'pending')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
        ];

        // Get projects by category
        $projectsByCategory = Project::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Get upcoming project deadlines
        $upcomingDeadlines = Project::where('expected_completion', '>=', now())
            ->orderBy('expected_completion', 'asc')
            ->take(5)
            ->get();

        // Project completion data for chart
        $projectCompletion = Project::select('title', 'completion')
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentProjects',
            'projectsByStatus',
            'projectsByCategory',
            'upcomingDeadlines',
            'projectCompletion'
        ));
    }
}