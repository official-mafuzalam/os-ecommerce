<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendFacebookCapiEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;
    protected $pixelId;
    protected $accessToken;

    public function __construct($payload)
    {
        $this->payload = $payload;
        $this->pixelId = setting('fb_pixel_id');
        $this->accessToken = setting('facebook_access_token');
    }

    public function handle()
    {
        if (!$this->pixelId || !$this->accessToken)
            return;

        try {
            $response = Http::post("https://graph.facebook.com/v20.0/{$this->pixelId}/events", [
                'data' => [$this->payload],
                'access_token' => $this->accessToken,
            ]);

            Log::info('FB CAPI Event Sent: ' . $this->payload['event_name'] . ' | Response: ' . $response->body());

            if ($response->failed()) {
                Log::error('FB CAPI Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('FB CAPI Exception: ' . $e->getMessage());
        }
    }
}