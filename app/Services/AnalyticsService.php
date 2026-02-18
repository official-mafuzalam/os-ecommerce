<?php

namespace App\Services;

use App\Jobs\SendFacebookCapiEvent;

class AnalyticsService
{
    /**
     * Prepare and Dispatch Event
     */
    public function dispatchEvent($eventName, $eventId, $customData = [], $userData = [])
    {
        // 1. Prepare Server-Side User Data (Requirements for High Match Quality)
        $payloadUserData = array_merge([
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->userAgent(),
            'fbc' => request()->cookie('_fbc'),
            'fbp' => request()->cookie('_fbp'),
        ], $this->hashUserData($userData));

        // 2. Prepare Payload
        $payload = [
            'event_name' => $eventName,
            'event_time' => time(),
            'event_id' => $eventId,
            'action_source' => 'website',
            'event_source_url' => url()->current(),
            'user_data' => array_filter($payloadUserData),
            'custom_data' => array_filter($this->formatContents($customData)),
        ];

        // 3. Dispatch to Queue (Professional way - no lag for user)
        SendFacebookCapiEvent::dispatch($payload);
    }

    /**
     * Facebook requires PII data to be SHA256 hashed
     */
    private function hashUserData($data)
    {
        $hashed = [];
        $keysToHash = ['em', 'ph', 'fn', 'ln', 'ge', 'db', 'ct', 'st', 'zp', 'country'];

        foreach ($data as $key => $value) {
            if (in_array($key, $keysToHash) && !empty($value)) {
                $hashed[$key] = hash('sha256', strtolower(trim($value)));
            } else {
                $hashed[$key] = $value;
            }
        }
        return $hashed;
    }


    private function formatContents($customData)
    {
        if (isset($customData['items'])) {
            $customData['contents'] = array_map(function ($item) {
                return [
                    'id' => $item['item_id'] ?? ($item['id'] ?? ''),
                    'quantity' => $item['quantity'] ?? 1,
                    'item_price' => $item['price'] ?? 0
                ];
            }, $customData['items']);
        }
        return $customData;
    }
}