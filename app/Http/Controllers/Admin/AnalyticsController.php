<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\PageView;
use App\Models\Product;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Quotation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    /**
     * Display the main analytics dashboard.
     */
    public function index()
    {
        try {
            // Get date range (default to last 30 days)
            $startDate = now()->subDays(30)->startOfDay();
            $endDate = now()->endOfDay();

            // Website Analytics
            $uniqueVisitors = Visitor::whereBetween('first_visit', [$startDate, $endDate])->count();
            $totalPageViews = PageView::whereBetween('created_at', [$startDate, $endDate])->count();
            $returningVisitors = Visitor::returningVisitors()->whereBetween('first_visit', [$startDate, $endDate])->count();

            // Business Analytics
            $totalLeads = Lead::whereBetween('created_at', [$startDate, $endDate])->count();
            $newLeads = Lead::new()->whereBetween('created_at', [$startDate, $endDate])->count();
            $convertedLeads = Lead::converted()->whereBetween('created_at', [$startDate, $endDate])->count();
            $totalQuoteRequests = QuoteRequest::whereBetween('created_at', [$startDate, $endDate])->count();
            $totalQuotations = Quotation::whereBetween('created_at', [$startDate, $endDate])->count();
            $acceptedQuotations = Quotation::where('status', 'accepted')->whereBetween('created_at', [$startDate, $endDate])->count();

            // Calculate conversion rates
            $leadConversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;
            $quoteConversionRate = $totalQuoteRequests > 0 ? round(($acceptedQuotations / $totalQuoteRequests) * 100, 2) : 0;

            // Content Analytics
            $totalProjects = Project::count();
            $activeProjects = Project::where('status', 'active')->count();
            $totalProducts = Product::count();
            $activeProducts = Product::where('status', 'active')->count();

            // Chart data - visitors by day
            $visitorsByDay = Visitor::select([
                DB::raw('DATE(first_visit) as date'),
                DB::raw('COUNT(*) as count')
            ])
                ->whereBetween('first_visit', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Chart data - leads by status
            $leadsByStatus = Lead::select('status', DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('status')
                ->pluck('count', 'status');

            $stats = [
                'website' => [
                    'unique_visitors' => $uniqueVisitors,
                    'total_page_views' => $totalPageViews,
                    'returning_visitors' => $returningVisitors,
                ],
                'business' => [
                    'total_leads' => $totalLeads,
                    'new_leads' => $newLeads,
                    'converted_leads' => $convertedLeads,
                    'total_quote_requests' => $totalQuoteRequests,
                    'total_quotations' => $totalQuotations,
                    'accepted_quotations' => $acceptedQuotations,
                    'lead_conversion_rate' => $leadConversionRate,
                    'quote_conversion_rate' => $quoteConversionRate,
                ],
                'content' => [
                    'total_projects' => $totalProjects,
                    'active_projects' => $activeProjects,
                    'total_products' => $totalProducts,
                    'active_products' => $activeProducts,
                ],
            ];

            Log::info('Admin accessing analytics dashboard');

            return view('admin.analytics.index', compact(
                'stats',
                'visitorsByDay',
                'leadsByStatus',
                'startDate',
                'endDate'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading analytics dashboard: ' . $e->getMessage());

            return redirect()->route('dashboard')
                ->with('error', 'Error loading analytics dashboard.');
        }
    }

    /**
     * Display website analytics dashboard.
     */
    public function website(Request $request)
    {
        try {
            // Get date range from request or default to last 30 days
            $period = $request->get('period', 30);
            $startDate = now()->subDays($period)->startOfDay();
            $endDate = now()->endOfDay();

            // Basic stats
            $uniqueVisitors = Visitor::whereBetween('first_visit', [$startDate, $endDate])->count();
            $totalPageViews = PageView::whereBetween('created_at', [$startDate, $endDate])->count();
            $returningVisitors = Visitor::returningVisitors()->whereBetween('first_visit', [$startDate, $endDate])->count();
            $avgPageViewsPerVisitor = $uniqueVisitors > 0 ? round($totalPageViews / $uniqueVisitors, 2) : 0;

            // Top pages
            $topPages = PageView::select('url', DB::raw('COUNT(*) as views'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('url')
                ->orderBy('views', 'desc')
                ->take(10)
                ->get();

            // Traffic sources
            $trafficSources = PageView::select('referer', DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('referer')
                ->where('referer', '!=', '')
                ->groupBy('referer')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get();

            // Device types
            $deviceTypes = Visitor::select('device_type', DB::raw('COUNT(*) as count'))
                ->whereBetween('first_visit', [$startDate, $endDate])
                ->groupBy('device_type')
                ->get();

            // Browsers
            $browsers = Visitor::select('browser', DB::raw('COUNT(*) as count'))
                ->whereBetween('first_visit', [$startDate, $endDate])
                ->groupBy('browser')
                ->get();

            // Visitors by day for chart
            $visitorsByDay = Visitor::select([
                DB::raw('DATE(first_visit) as date'),
                DB::raw('COUNT(*) as count')
            ])
                ->whereBetween('first_visit', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $stats = [
                'unique_visitors' => $uniqueVisitors,
                'total_page_views' => $totalPageViews,
                'returning_visitors' => $returningVisitors,
                'avg_page_views_per_visitor' => $avgPageViewsPerVisitor,
            ];

            return view('admin.analytics.website', compact(
                'stats',
                'topPages',
                'trafficSources',
                'deviceTypes',
                'browsers',
                'visitorsByDay',
                'period'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading website analytics: ' . $e->getMessage());

            return redirect()->route('admin.analytics.index')
                ->with('error', 'Error loading website analytics.');
        }
    }

    /**
     * Display business analytics dashboard.
     */
    public function business(Request $request)
    {
        try {
            $period = $request->get('period', 30);
            $startDate = now()->subDays($period)->startOfDay();
            $endDate = now()->endOfDay();

            // Lead stats
            $totalLeads = Lead::whereBetween('created_at', [$startDate, $endDate])->count();
            $newLeads = Lead::new()->whereBetween('created_at', [$startDate, $endDate])->count();
            $contactedLeads = Lead::contacted()->whereBetween('created_at', [$startDate, $endDate])->count();
            $qualifiedLeads = Lead::qualified()->whereBetween('created_at', [$startDate, $endDate])->count();
            $convertedLeads = Lead::converted()->whereBetween('created_at', [$startDate, $endDate])->count();
            $lostLeads = Lead::lost()->whereBetween('created_at', [$startDate, $endDate])->count();

            // Quote stats
            $totalQuoteRequests = QuoteRequest::whereBetween('created_at', [$startDate, $endDate])->count();
            $quotedRequests = QuoteRequest::quoted()->whereBetween('created_at', [$startDate, $endDate])->count();
            $totalQuotations = Quotation::whereBetween('created_at', [$startDate, $endDate])->count();
            $acceptedQuotations = Quotation::where('status', 'accepted')->whereBetween('created_at', [$startDate, $endDate])->count();
            $rejectedQuotations = Quotation::where('status', 'rejected')->whereBetween('created_at', [$startDate, $endDate])->count();

            // Calculate totals
            $totalQuotationValue = Quotation::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'accepted')
                ->sum('total');

            // Calculate conversion rates
            $leadConversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;
            $quoteConversionRate = $totalQuoteRequests > 0 ? round(($acceptedQuotations / $totalQuoteRequests) * 100, 2) : 0;

            // Leads by day for chart
            $leadsByDay = Lead::select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Recent leads
            $recentLeads = Lead::with('assignedTo')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $stats = [
                'total_leads' => $totalLeads,
                'new_leads' => $newLeads,
                'contacted_leads' => $contactedLeads,
                'qualified_leads' => $qualifiedLeads,
                'converted_leads' => $convertedLeads,
                'lost_leads' => $lostLeads,
                'total_quote_requests' => $totalQuoteRequests,
                'quoted_requests' => $quotedRequests,
                'total_quotations' => $totalQuotations,
                'accepted_quotations' => $acceptedQuotations,
                'rejected_quotations' => $rejectedQuotations,
                'total_quotation_value' => $totalQuotationValue,
                'lead_conversion_rate' => $leadConversionRate,
                'quote_conversion_rate' => $quoteConversionRate,
            ];

            return view('admin.analytics.business', compact(
                'stats',
                'leadsByDay',
                'recentLeads',
                'period'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading business analytics: ' . $e->getMessage());

            return redirect()->route('admin.analytics.index')
                ->with('error', 'Error loading business analytics.');
        }
    }

    /**
     * Display content analytics dashboard.
     */
    public function content(Request $request)
    {
        try {
            $period = $request->get('period', 30);
            $startDate = now()->subDays($period)->startOfDay();
            $endDate = now()->endOfDay();

            // Content stats
            $totalProjects = Project::count();
            $activeProjects = Project::where('status', 'active')->count();
            $completedProjects = Project::where('status', 'completed')->count();
            $totalProducts = Product::count();
            $activeProducts = Product::where('status', 'active')->count();

            // Most viewed pages
            $topPages = PageView::select('url', DB::raw('COUNT(*) as views'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('url')
                ->orderBy('views', 'desc')
                ->take(20)
                ->get();

            // Projects by category
            $projectsByCategory = Project::select('category_id', DB::raw('COUNT(*) as count'))
                ->where('status', 'active')
                ->with('category')
                ->groupBy('category_id')
                ->get();

            // Most viewed project pages
            $projectPageViews = PageView::select('url', DB::raw('COUNT(*) as views'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('url', 'like', '%project%')
                ->groupBy('url')
                ->orderBy('views', 'desc')
                ->take(10)
                ->get();

            $stats = [
                'total_projects' => $totalProjects,
                'active_projects' => $activeProjects,
                'completed_projects' => $completedProjects,
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
            ];

            return view('admin.analytics.content', compact(
                'stats',
                'topPages',
                'projectsByCategory',
                'projectPageViews',
                'period'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading content analytics: ' . $e->getMessage());

            return redirect()->route('admin.analytics.index')
                ->with('error', 'Error loading content analytics.');
        }
    }

    /**
     * API endpoint for chart data (AJAX).
     */
    public function apiChartData(Request $request)
    {
        try {
            $type = $request->get('type');
            $period = $request->get('period', 30);
            $startDate = now()->subDays($period)->startOfDay();
            $endDate = now()->endOfDay();

            switch ($type) {
                case 'visitors':
                    $data = Visitor::select([
                        DB::raw('DATE(first_visit) as date'),
                        DB::raw('COUNT(*) as count')
                    ])
                        ->whereBetween('first_visit', [$startDate, $endDate])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'leads':
                    $data = Lead::select([
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('COUNT(*) as count')
                    ])
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'page_views':
                    $data = PageView::select([
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('COUNT(*) as count')
                    ])
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'leads_by_status':
                    $data = Lead::select('status', DB::raw('COUNT(*) as count'))
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('status')
                        ->get();
                    break;

                default:
                    $data = [];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching chart data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching chart data'
            ], 500);
        }
    }
}
