<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'device_type',
        'browser',
        'os',
    ];

    /**
     * Parse a user agent string into device type, browser, and OS.
     * Lightweight parser — no external dependencies.
     */
    public static function parseUserAgent(string $ua): array
    {
        $result = [
            'device_type' => 'Desktop',
            'browser'     => 'Unknown',
            'os'          => 'Unknown',
        ];

        // ---- Device Type ----
        if (preg_match('/iPad|PlayBook|Kindle|Silk/i', $ua)) {
            $result['device_type'] = 'Tablet';
        } elseif (preg_match('/Mobile|Android.*Mobile|iPhone|iPod|Opera Mini|IEMobile|BB10|webOS/i', $ua)) {
            $result['device_type'] = 'Mobile';
        } elseif (preg_match('/Android/i', $ua)) {
            // Android without "Mobile" keyword → tablet
            $result['device_type'] = 'Tablet';
        }

        // ---- Browser ----
        if (preg_match('/Edg(?:e|A|iOS)?\/[\d.]+/i', $ua)) {
            $result['browser'] = 'Edge';
        } elseif (preg_match('/OPR\/|Opera/i', $ua)) {
            $result['browser'] = 'Opera';
        } elseif (preg_match('/SamsungBrowser/i', $ua)) {
            $result['browser'] = 'Samsung Browser';
        } elseif (preg_match('/UCBrowser|UCWEB/i', $ua)) {
            $result['browser'] = 'UC Browser';
        } elseif (preg_match('/YaBrowser/i', $ua)) {
            $result['browser'] = 'Yandex';
        } elseif (preg_match('/Brave/i', $ua)) {
            $result['browser'] = 'Brave';
        } elseif (preg_match('/Vivaldi/i', $ua)) {
            $result['browser'] = 'Vivaldi';
        } elseif (preg_match('/Chrome\/[\d.]+/i', $ua) && !preg_match('/Chromium/i', $ua)) {
            $result['browser'] = 'Chrome';
        } elseif (preg_match('/Firefox\/[\d.]+/i', $ua)) {
            $result['browser'] = 'Firefox';
        } elseif (preg_match('/Safari\/[\d.]+/i', $ua) && preg_match('/Version\//i', $ua)) {
            $result['browser'] = 'Safari';
        } elseif (preg_match('/MSIE|Trident/i', $ua)) {
            $result['browser'] = 'IE';
        }

        // ---- OS ----
        if (preg_match('/Windows NT 10/i', $ua)) {
            $result['os'] = 'Windows 10/11';
        } elseif (preg_match('/Windows NT 6\.3/i', $ua)) {
            $result['os'] = 'Windows 8.1';
        } elseif (preg_match('/Windows NT 6\.1/i', $ua)) {
            $result['os'] = 'Windows 7';
        } elseif (preg_match('/Windows/i', $ua)) {
            $result['os'] = 'Windows';
        } elseif (preg_match('/Mac OS X ([\d_]+)/i', $ua, $m)) {
            $ver = str_replace('_', '.', $m[1]);
            $result['os'] = 'macOS ' . $ver;
        } elseif (preg_match('/iPhone OS ([\d_]+)/i', $ua, $m)) {
            $ver = str_replace('_', '.', $m[1]);
            $result['os'] = 'iOS ' . $ver;
        } elseif (preg_match('/iPad.*OS ([\d_]+)/i', $ua, $m)) {
            $ver = str_replace('_', '.', $m[1]);
            $result['os'] = 'iPadOS ' . $ver;
        } elseif (preg_match('/Android ([\d.]+)/i', $ua, $m)) {
            $result['os'] = 'Android ' . $m[1];
        } elseif (preg_match('/Linux/i', $ua)) {
            $result['os'] = 'Linux';
        } elseif (preg_match('/CrOS/i', $ua)) {
            $result['os'] = 'Chrome OS';
        }

        return $result;
    }

    /**
     * Check if user agent looks like a bot/crawler.
     */
    public static function isBot(string $ua): bool
    {
        return (bool) preg_match(
            '/bot|crawl|spider|slurp|facebookexternalhit|mediapartners|google|bing|yahoo|baidu|yandex|duckduck|semrush|ahrefs|mj12bot|dotbot|rogerbot|screaming|lighthouse|pagespeed|pingdom|uptimerobot|statuspage|monitoring|curl|wget|python|java|go-http|httpie/i',
            $ua
        );
    }
}
