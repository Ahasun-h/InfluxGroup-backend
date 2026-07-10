<?php

namespace App\Http\Controllers\Api;

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
     * Get analytics overview dashboard data (Public API)
     */
    public function getDashboardData(Request $request)
    {
        try {
            $period = $request->get('period', 30);
            $startDate = now()->subDays($period)->startOfDay();
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

            return response()->json([
                'success' => true,
                'data' => [
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
                    'period' => $period,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Error fetching dashboard data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching analytics data'
            ], 500);
        }
    }

    /**
     * Get website analytics data (Public API)
     */
    public function getWebsiteAnalytics(Request $request)
    {
        try {
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

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'unique_visitors' => $uniqueVisitors,
                        'total_page_views' => $totalPageViews,
                        'returning_visitors' => $returningVisitors,
                        'avg_page_views_per_visitor' => $avgPageViewsPerVisitor,
                    ],
                    'top_pages' => $topPages,
                    'traffic_sources' => $trafficSources,
                    'device_types' => $deviceTypes,
                    'browsers' => $browsers,
                    'visitors_by_day' => $visitorsByDay,
                    'period' => $period,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Error fetching website analytics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching website analytics'
            ], 500);
        }
    }

    /**
     * Get business analytics data (Public API)
     */
    public function getBusinessAnalytics(Request $request)
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

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
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
                    ],
                    'leads_by_day' => $leadsByDay,
                    'period' => $period,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Error fetching business analytics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching business analytics'
            ], 500);
        }
    }

    /**
     * Get content analytics data (Public API)
     */
    public function getContentAnalytics(Request $request)
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

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'total_projects' => $totalProjects,
                        'active_projects' => $activeProjects,
                        'completed_projects' => $completedProjects,
                        'total_products' => $totalProducts,
                        'active_products' => $activeProducts,
                    ],
                    'top_pages' => $topPages,
                    'projects_by_category' => $projectsByCategory,
                    'project_page_views' => $projectPageViews,
                    'period' => $period,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Error fetching content analytics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching content analytics'
            ], 500);
        }
    }

    /**
     * Get chart data for analytics (Public API)
     */
    public function getChartData(Request $request)
    {
        try {
            $type = $request->get('type');
            $period = $request->get('period', 30);
            $startDate = now()->subDays($period)->startOfDay();
            $endDate = now()->endOfDay();

            $data = [];

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
            Log::error('API Error fetching chart data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching chart data'
            ], 500);
        }
    }
}
