<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     * The response is sent to the browser immediately.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Perform tracking AFTER the response has been sent to the browser.
     * This is the "terminable" part — it does NOT slow down page load.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Only track successful GET page requests (not assets, not AJAX)
        if ($request->method() !== 'GET') {
            return;
        }

        // Skip non-HTML responses (images, JS, CSS, etc.)
        if ($response->headers->get('Content-Type') &&
            !str_contains($response->headers->get('Content-Type'), 'text/html')) {
            return;
        }

        // Skip admin, login, api, and asset routes
        $path = $request->path();
        if (preg_match('#^(admin|login|logout|api|_debugbar|livewire|sanctum|telescope)#', $path)) {
            return;
        }

        // Skip asset file extensions
        if (preg_match('/\.(js|css|png|jpg|jpeg|gif|svg|ico|woff2?|ttf|map|webp)$/i', $path)) {
            return;
        }

        // Skip bots/crawlers
        $ua = $request->userAgent() ?? '';
        if (empty($ua) || Visitor::isBot($ua)) {
            return;
        }

        // Debounce: same IP + URL within 30 minutes
        $ip = $request->ip();
        $url = '/' . ltrim($path, '/');

        $recentVisit = Visitor::where('ip_address', $ip)
            ->where('url', $url)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->exists();

        if ($recentVisit) {
            return;
        }

        // Parse user agent
        $parsed = Visitor::parseUserAgent($ua);

        // Record the visit
        try {
            Visitor::create([
                'ip_address'  => $ip,
                'user_agent'  => mb_substr($ua, 0, 1000),
                'url'         => mb_substr($url, 0, 500),
                'device_type' => $parsed['device_type'],
                'browser'     => $parsed['browser'],
                'os'          => $parsed['os'],
            ]);
        } catch (\Throwable $e) {
            // Silently fail — tracking should never break the site
            \Illuminate\Support\Facades\Log::warning('Visitor tracking failed: ' . $e->getMessage());
        }
    }
}
