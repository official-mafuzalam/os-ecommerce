<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Http\UploadedFile;

class ApiService
{
    protected string $baseUrl;
    protected int $defaultTimeout;
    protected int $defaultRetry;
    protected array $defaultHeaders;

    public function __construct(?string $baseUrl = null)
    {
        $this->baseUrl = rtrim($baseUrl ?? config('license.api_url', 'https://octosyncsoftware.com/api'), '/');
        $this->defaultTimeout = 10;
        $this->defaultRetry = 1;
        $this->defaultHeaders = [
            'Accept' => 'application/json',
        ];
    }

    /**
     * Set base URL dynamically
     */
    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = rtrim($url, '/');
        return $this;
    }

    /**
     * Get current base URL
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Send a POST request to an external API endpoint
     */
    public function post(string $endpoint, array $data = [], array $headers = [], ?int $timeout = null, ?int $retry = null): Response
    {
        return $this->send('POST', $endpoint, ['json' => $data], $headers, $timeout, $retry);
    }

    /**
     * Send a multipart/form-data POST request (for file uploads)
     */
    public function postMultipart(string $endpoint, array $data = [], $file = null, string $fileParamName = 'screenshot', array $headers = [], ?int $timeout = null): Response
    {
        $url = $this->buildUrl($endpoint);
        $timeout = $timeout ?? $this->defaultTimeout;

        $client = Http::asMultipart()->timeout($timeout);

        if (!empty($headers)) {
            $client->withHeaders($headers);
        }

        // Attach file if present
        if ($file) {
            if ($file instanceof UploadedFile) {
                $client->attach(
                    $fileParamName,
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                );
            } elseif (is_string($file) && file_exists($file)) {
                $client->attach(
                    $fileParamName,
                    file_get_contents($file),
                    basename($file)
                );
            }
        }

        try {
            return $client->post($url, $data);
        } catch (\Exception $e) {
            Log::error("ApiService Multipart Request Failed: [POST] {$url}", [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Send a GET request to an external API endpoint
     */
    public function get(string $endpoint, array $query = [], array $headers = [], ?int $timeout = null, ?int $retry = null): Response
    {
        return $this->send('GET', $endpoint, ['query' => $query], $headers, $timeout, $retry);
    }

    /**
     * Verify / Check subscription status API
     */
    public function checkSubscription(string $licenseKey, string $endpoint = '/clients/check-subscription'): Response
    {
        return $this->post($endpoint, [
            'license_key' => $licenseKey
        ]);
    }

    /**
     * Alias for checkSubscription
     */
    public function verifySubscription(string $licenseKey, string $endpoint = '/clients/check-subscription'): Response
    {
        return $this->checkSubscription($licenseKey, $endpoint);
    }

    /**
     * Fetch list of client invoices
     */
    public function getInvoices(string $licenseKey, string $status = 'all'): Response
    {
        return $this->post('/clients/invoices', [
            'license_key' => $licenseKey,
            'status' => $status
        ]);
    }

    /**
     * Fetch details of a specific invoice
     */
    public function getInvoiceDetails(string $invoiceNumber, string $licenseKey): Response
    {
        return $this->post("/clients/invoices/{$invoiceNumber}", [
            'license_key' => $licenseKey
        ]);
    }

    /**
     * Submit a manual payment transaction (with optional screenshot proof)
     */
    public function submitTransaction(array $data, $screenshotFile = null): Response
    {
        // Must contain license_key, app_url, amount, transaction_id
        if ($screenshotFile) {
            return $this->postMultipart('/clients/submit-transction', $data, $screenshotFile, 'screenshot');
        }

        return $this->post('/clients/submit-transction', $data);
    }

    /**
     * Check payment submission status by transaction ID
     */
    public function checkSubmissionStatus(string $licenseKey, string $transactionId): Response
    {
        return $this->post('/clients/submission-status', [
            'license_key' => $licenseKey,
            'transaction_id' => $transactionId
        ]);
    }

    /**
     * Core request handler using Laravel Http Client
     */
    protected function send(string $method, string $endpoint, array $options = [], array $headers = [], ?int $timeout = null, ?int $retry = null): Response
    {
        $url = $this->buildUrl($endpoint);
        $mergedHeaders = array_merge($this->defaultHeaders, $headers);
        $timeout = $timeout ?? $this->defaultTimeout;
        $retry = $retry ?? $this->defaultRetry;

        $client = Http::withHeaders($mergedHeaders)
            ->timeout($timeout);

        if ($retry > 0) {
            $client->retry($retry, 100);
        }

        $method = strtoupper($method);

        try {
            if ($method === 'GET' && isset($options['query'])) {
                return $client->get($url, $options['query']);
            }

            if ($method === 'POST') {
                return $client->post($url, $options['json'] ?? []);
            }

            if ($method === 'PUT') {
                return $client->put($url, $options['json'] ?? []);
            }

            if ($method === 'DELETE') {
                return $client->delete($url, $options['json'] ?? []);
            }

            return $client->send($method, $url, $options);
        } catch (\Exception $e) {
            Log::error("ApiService Request Failed: [{$method}] {$url}", [
                'error' => $e->getMessage(),
                'options' => $options
            ]);
            throw $e;
        }
    }

    /**
     * Build full URL from endpoint
     */
    protected function buildUrl(string $endpoint): string
    {
        if (str_starts_with($endpoint, 'http://') || str_starts_with($endpoint, 'https://')) {
            return $endpoint;
        }

        return $this->baseUrl . '/' . ltrim($endpoint, '/');
    }
}
