<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackAnalytics
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip analytics for admin routes, API routes, and auth routes
        if ($request->is('admin/*') || $request->is('api/*') || $request->is('auth/*')) {
            return $next($request);
        }

        try {
            $sessionId = $request->session()->getId();
            $url = $request->fullUrl();
            $referer = $request->header('referer');
            $userAgent = $request->header('user-agent');
            $ipAddress = $request->ip();

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
            PageView::create([
                'session_id' => $sessionId,
                'url' => $request->path(),
                'title' => null, // Will be updated by frontend if needed
                'referer' => $referer,
                'method' => $request->method(),
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);

        } catch (\Exception $e) {
            // Log error but don't break the application
            Log::error('Analytics tracking error: ' . $e->getMessage());
        }

        return $next($request);
    }

    /**
     * Detect device type from user agent.
     */
    protected function detectDeviceType(Request $request): string
    {
        $userAgent = $request->header('user-agent', '');

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
        $userAgent = $request->header('user-agent', '');

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
        $userAgent = $request->header('user-agent', '');

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
