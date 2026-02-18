<?php

use App\Models\Setting;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        // Use caching for better performance
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            return Setting::getValue($key, $default);
        });
    }
}

if (!function_exists('fb_event_id')) {
    function fb_event_id()
    {
        return uniqid('fb_', true);
    }
}


if (!function_exists('setMailConfigFromDB')) {
    function setMailConfigFromDB()
    {
        Config::set('mail.default', setting('mail_mailer', 'smtp'));
        Config::set('mail.mailers.smtp.host', setting('mail_host', 'smtp.mailtrap.io'));
        Config::set('mail.mailers.smtp.port', setting('mail_port', 587));
        Config::set('mail.mailers.smtp.username', setting('mail_username'));
        Config::set('mail.mailers.smtp.password', setting('mail_password'));
        Config::set('mail.mailers.smtp.encryption', setting('mail_encryption', 'tls'));
        Config::set('mail.from.address', setting('mail_from_address', 'hello@example.com'));
        Config::set('mail.from.name', setting('mail_from_name', config('app.name')));
    }
}

if (!function_exists('setLicenseConfigFromDB')) {
    function setLicenseConfigFromDB()
    {
        Config::set('license.license_key', setting('license_key', null));
    }
}

if (!function_exists('isLicenseValid')) {
    function isLicenseValid()
    {
        $licenseStatus = Cache::get(config('license.cache.key'));

        return $licenseStatus === 'valid';
    }
}

if (!function_exists('track_event')) {
    /**
     * Professional Hybrid Tracker
     * @param string $eventName Facebook Event Name (Purchase, AddToCart, etc)
     * @param array $params Custom Data (value, items, currency)
     */
    function track_event($eventName, $params = [])
    {
        $eventId = 'ev_' . time() . '_' . uniqid();

        // 1. Identify User (Priority: Passed Data > Auth User)
        $userData = $params['user_data'] ?? [];
        if (empty($userData) && auth()->check()) {
            $user = auth()->user();
            $userData = [
                'em' => $user->email,
                'ph' => $user->phone,
                'external_id' => (string) $user->id,
            ];
        }

        // Clean up params so 'user_data' isn't sent as a custom property to FB
        unset($params['user_data']);

        // 2. Fire Server-Side (CAPI)
        app(AnalyticsService::class)->dispatchEvent($eventName, $eventId, $params, $userData);

        // 3. Fire Browser-Side (Pixel/GTM) via Session
        $ga4Mapping = [
            'ViewContent' => 'view_item',
            'AddToCart' => 'add_to_cart',
            'InitiateCheckout' => 'begin_checkout',
            'Purchase' => 'purchase'
        ];
        $gtmEventName = $ga4Mapping[$eventName] ?? $eventName;

        $queuedEvents = session()->get('analytics_events', []);
        $queuedEvents[] = [
            'fb_name' => $eventName,
            'gtm_name' => $gtmEventName,
            'event_id' => $eventId,
            'params' => $params
        ];
        session()->put('analytics_events', $queuedEvents);
    }
}