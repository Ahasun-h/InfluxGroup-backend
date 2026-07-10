<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnalyticsTrackingController extends Controller
{
    /**
     * Track page view from Vue frontend
     */
    public function trackPageView(Request $request)
    {
        try {
            $sessionId = $request->input('session_id');
            $url = $request->input('url', '/');
            $title = $request->input('title');
            $referer = $request->input('referer');
            $userAgent = $request->input('user_agent');
            $ipAddress = $request->ip();

            if (!$sessionId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session ID is required'
                ], 400);
            }

            // Get or create visitor
            $visitor = Visitor::where('session_id', $sessionId)->first();

            if ($visitor) {
                // Update existing visitor
                $visitor->update([
                    'last_visit' => now(),
                    'visit_count' => $visitor->visit_count + 1,
                ]);
            } else {
                // Create new visitor
                $visitor = Visitor::create([
                    'session_id' => $sessionId,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'first_visit' => now(),
                    'last_visit' => now(),
                    'visit_count' => 1,
                    'device_type' => $this->detectDeviceType($request),
                    'browser' => $this->detectBrowser($request),
                    'platform' => $this->detectPlatform($request),
                ]);
            }

            // Track page view
            $pageView = PageView::create([
                'session_id' => $sessionId,
                'url' => $url,
                'title' => $title,
                'referer' => $referer,
                'method' => 'GET',
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Page view tracked successfully',
                'data' => [
                    'visitor_id' => $visitor->id,
                    'page_view_id' => $pageView->id,
                    'is_new_visitor' => !$visitor->wasRecentlyCreated,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Analytics tracking error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error tracking page view'
            ], 500);
        }
    }

    /**
     * Detect device type from user agent.
     */
    protected function detectDeviceType(Request $request): string
    {
        $userAgent = $request->input('user_agent', '');

        if (preg_match('/mobile/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'tablet';
        }

        return 'desktop';
    }

    /**
     * Detect browser from user agent.
     */
    protected function detectBrowser(Request $request): string
    {
        $userAgent = $request->input('user_agent', '');

        if (preg_match('/Edg/i', $userAgent)) {
            return 'Edge';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent) || preg_match('/OPR\//i', $userAgent)) {
            return 'Opera';
        }

        return 'Unknown';
    }

    /**
     * Detect platform from user agent.
     */
    protected function detectPlatform(Request $request): string
    {
        $userAgent = $request->input('user_agent', '');

        if (preg_match('/Windows/i', $userAgent)) {
            return 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS/i', $userAgent)) {
            return 'Mac';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            return 'Android';
        } elseif (preg_match('/iOS|iPhone|iPad|iPod/i', $userAgent)) {
            return 'iOS';
        }

        return 'Unknown';
    }
}