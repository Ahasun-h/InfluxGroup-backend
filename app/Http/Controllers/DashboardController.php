<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Product;
use App\Models\News;
use App\Models\Service;
use App\Models\Gallery;
use App\Models\JobOpening;
use App\Models\Testimonial;

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
                'total_value' => Project::sum('value'),
            ],
            'products' => Product::count(),
            'news' => News::count(),
            'services' => Service::count(),
            'gallery' => Gallery::count(),
            'jobs' => JobOpening::where('status', 'active')->count(),
            'testimonials' => Testimonial::count(),
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

        // Get recent news
        $recentNews = News::latest()->take(3)->get();

        // Get active job openings
        $activeJobs = JobOpening::where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        // Get recent testimonials
        $recentTestimonials = Testimonial::latest()->take(3)->get();

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
            'recentNews',
            'activeJobs',
            'recentTestimonials',
            'projectCompletion'
        ));
    }
}