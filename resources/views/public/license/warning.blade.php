@extends('layouts.license')

@section('title', 'License & Subscription Verification')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-certificate text-white text-2xl mr-3"></i>
                            <h1 class="text-2xl font-bold text-white">License & Subscription Status</h1>
                        </div>
                        <span class="text-blue-100 text-sm font-medium bg-blue-700 px-3 py-1 rounded-full">
                            OctoSync Client Portal
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <ul class="list-disc list-inside text-sm text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- License Status -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Subscription & License Information</h2>

                        @php
                            $statusColor = 'green';
                            $statusBg = 'bg-green-100';
                            $statusTextColor = 'text-green-800';
                            $statusIcon = 'fa-check-circle';
                            $statusText = 'Active';

                            $currentStatus = $status['subscription']['status'] ?? $status['status'] ?? 'unknown';
                            $isValid = $status['valid'] ?? false;
                            $isExpired = $status['subscription']['is_expired'] ?? $status['is_expired'] ?? false;

                            if (!$isValid) {
                                $blockedStatuses = ['suspended', 'cancelled', 'revoked', 'terminated'];

                                if (in_array($currentStatus, $blockedStatuses)) {
                                    $statusColor = 'gray';
                                    $statusBg = 'bg-gray-100';
                                    $statusTextColor = 'text-gray-800';
                                    $statusIcon = 'fa-ban';
                                    $statusText = ucfirst($currentStatus);
                                } elseif ($isInGracePeriod) {
                                    $statusColor = 'yellow';
                                    $statusBg = 'bg-yellow-100';
                                    $statusTextColor = 'text-yellow-800';
                                    $statusIcon = 'fa-clock';
                                    $statusText = 'Grace Period';
                                } elseif ($isExpired) {
                                    $statusColor = 'red';
                                    $statusBg = 'bg-red-100';
                                    $statusTextColor = 'text-red-800';
                                    $statusIcon = 'fa-times-circle';
                                    $statusText = 'Expired';
                                } else {
                                    $statusColor = 'red';
                                    $statusBg = 'bg-red-100';
                                    $statusTextColor = 'text-red-800';
                                    $statusIcon = 'fa-exclamation-triangle';
                                    $statusText = 'Invalid';
                                }
                            }
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status Display -->
                            <div>
                                <div class="flex items-center mb-4">
                                    <div class="{{ $statusBg }} p-3 rounded-full mr-4">
                                        <i class="fas {{ $statusIcon }} text-2xl text-{{ $statusColor }}-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Subscription {{ $statusText }}</h3>
                                        <p class="text-gray-500 text-sm">
                                            Checked: {{ \Carbon\Carbon::parse($status['checked_at'] ?? $status['verified_at'] ?? now())->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                @if(!empty($status['message']))
                                    <div class="p-3 bg-gray-50 border border-gray-200 rounded text-sm text-gray-700 mb-2">
                                        <i class="fas fa-info-circle text-blue-500 mr-1"></i> {{ $status['message'] }}
                                    </div>
                                @endif

                                @if ($status['api_unreachable'] ?? false)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                        <div class="flex">
                                            <i class="fas fa-wifi-slash text-yellow-400 mr-2"></i>
                                            <p class="text-sm text-yellow-700">Using cached data. Unable to reach OctoSync API server.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Details -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Status:</span>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusBg }} {{ $statusTextColor }}">
                                            {{ ucfirst($currentStatus) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Valid:</span>
                                        <span class="font-medium {{ $isValid ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $isValid ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Subscription Type:</span>
                                        <span class="font-medium text-gray-800">
                                            {{ ucfirst($status['subscription']['type'] ?? 'N/A') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Auto Renew:</span>
                                        <span class="font-medium text-gray-800">
                                            {{ ($status['subscription']['auto_renew'] ?? false) ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client & Product Information -->
                        @if (!empty($status['client']) || !empty($status['product']))
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Client Details -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-building text-gray-400 mr-2"></i>
                                        <h4 class="font-semibold text-gray-900">Client Details</h4>
                                    </div>
                                    <div class="space-y-2">
                                        <div>
                                            <p class="text-sm text-gray-500">Company Name</p>
                                            <p class="font-medium text-gray-800">{{ $status['client']['company_name'] ?? 'N/A' }}</p>
                                        </div>
                                        @if(!empty($status['client']['company_email']))
                                            <div>
                                                <p class="text-sm text-gray-500">Company Email</p>
                                                <p class="font-medium text-gray-800">{{ $status['client']['company_email'] }}</p>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm text-gray-500">License Type</p>
                                            <p class="font-medium text-gray-800">{{ ucfirst($status['subscription']['license_type'] ?? $status['client']['license_type'] ?? 'Commercial') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Expiration Date</p>
                                            <p class="font-medium text-gray-800">
                                                @php
                                                    $expiresAtStr = $status['subscription']['expires_at'] ?? $status['client']['license_expires_at'] ?? null;
                                                @endphp
                                                @if ($expiresAtStr)
                                                    {{ \Carbon\Carbon::parse($expiresAtStr)->format('M d, Y') }}
                                                    <span class="text-gray-500 text-sm block">
                                                        ({{ $status['subscription']['expires_at_human'] ?? $status['expires_at_human'] ?? 'N/A' }})
                                                    </span>
                                                @else
                                                    Lifetime / Unspecified
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-box text-gray-400 mr-2"></i>
                                        <h4 class="font-semibold text-gray-900">Product & Expiry</h4>
                                    </div>
                                    <div class="space-y-2">
                                        <div>
                                            <p class="text-sm text-gray-500">Product Name</p>
                                            <p class="font-medium text-gray-800">{{ $status['product']['name'] ?? 'School Management System' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Version</p>
                                            <p class="font-medium text-gray-800">{{ $status['product']['version'] ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Days Until Expiry</p>
                                            <p class="font-medium {{ ($status['days_until_expiry'] ?? 0) < 0 ? 'text-red-600' : (($status['days_until_expiry'] ?? 0) <= 30 ? 'text-yellow-600' : 'text-green-600') }}">
                                                {{ $status['subscription']['days_until_expiry'] ?? $status['days_until_expiry'] ?? 'N/A' }} days
                                            </p>
                                        </div>
                                        @if(!empty($status['pending_invoice']))
                                            <div class="mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded">
                                                <p class="text-xs text-yellow-800 font-semibold">Pending Invoice:</p>
                                                <p class="text-sm text-yellow-900">{{ $status['pending_invoice']['invoice_number'] ?? 'Invoice Pending' }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Grace Period Information -->
                        @if ($isInGracePeriod && !empty($gracePeriodInfo))
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mt-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-yellow-400 text-2xl mr-3"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-yellow-800">Grace Period Active</h4>
                                        <p class="text-yellow-700 mt-1">
                                            Your license expired on
                                            <strong>{{ \Carbon\Carbon::parse($status['subscription']['expires_at'] ?? $status['client']['license_expires_at'])->format('F j, Y') }}</strong>.
                                        </p>
                                        <p class="text-yellow-700 mt-2">
                                            <strong>{{ $gracePeriodInfo['days_remaining'] }} day(s) remaining</strong>
                                            in grace period (ends {{ $gracePeriodInfo['ends_at']->format('F j, Y') }}).
                                            Renew before the grace period ends to avoid service interruption.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Refresh Status -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-blue-600 mb-4">
                                <i class="fas fa-sync-alt text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Refresh Status</h3>
                            <p class="text-gray-500 text-sm mb-4">Check for latest subscription status</p>
                            <form action="{{ route('license.refresh') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-white border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-sync-alt mr-2"></i> Refresh Now
                                </button>
                            </form>
                        </div>

                        <!-- Update License Key -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-yellow-600 mb-4">
                                <i class="fas fa-key text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Update License</h3>
                            <p class="text-gray-500 text-sm mb-4">Enter a new license key</p>
                            <button type="button" onclick="openLicenseModal()" class="w-full bg-white border border-yellow-600 text-yellow-600 px-4 py-2 rounded-lg hover:bg-yellow-50 transition-colors">
                                <i class="fas fa-edit mr-2"></i> Update Key
                            </button>
                        </div>

                        <!-- View Invoices -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-indigo-600 mb-4">
                                <i class="fas fa-file-invoice-dollar text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Invoices</h3>
                            <p class="text-gray-500 text-sm mb-4">View your client invoices</p>
                            <button type="button" onclick="openInvoicesModal()" class="w-full bg-white border border-indigo-600 text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                <i class="fas fa-list mr-2"></i> View Invoices
                            </button>
                        </div>

                        <!-- Submit Payment -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-green-600 mb-4">
                                <i class="fas fa-paper-plane text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Submit Payment</h3>
                            <p class="text-gray-500 text-sm mb-4">Submit manual payment proof</p>
                            <button type="button" onclick="openPaymentModal()" class="w-full bg-white border border-green-600 text-green-600 px-4 py-2 rounded-lg hover:bg-green-50 transition-colors">
                                <i class="fas fa-upload mr-2"></i> Submit Proof
                            </button>
                        </div>

                        <!-- Check Submission Status -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-purple-600 mb-4">
                                <i class="fas fa-search-dollar text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Check Payment Status</h3>
                            <p class="text-gray-500 text-sm mb-4">Check status by Transaction ID</p>
                            <button type="button" onclick="openStatusModal()" class="w-full bg-white border border-purple-600 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-50 transition-colors">
                                <i class="fas fa-search mr-2"></i> Check Status
                            </button>
                        </div>

                        <!-- Return Home -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-gray-600 mb-4">
                                <i class="fas fa-home text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Return Home</h3>
                            <p class="text-gray-500 text-sm mb-4">Go back to homepage</p>
                            <a href="{{ url('/') }}" class="block w-full bg-white border border-gray-600 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-home mr-2"></i> Home
                            </a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-6 text-center">
                        <p class="text-gray-500 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Client Subscription & License system powered by Octosync Software
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update License Key Modal -->
    <div id="licenseModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-key text-yellow-600 mr-2"></i>
                        <h3 class="text-lg font-semibold text-gray-900">Update License Key</h3>
                    </div>
                    <button type="button" onclick="closeLicenseModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form action="{{ route('license.update') }}" method="POST">
                @csrf
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label for="license_key" class="block text-sm font-medium text-gray-700 mb-2">License Key</label>
                        <input type="text" id="license_key" name="license_key"
                            value="{{ old('license_key', config('license.license_key', '')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="e.g. OCTO-SCHOOL-2026-X89B2" required>
                        <p class="mt-2 text-sm text-gray-500">Enter the license key provided by Octosync Software</p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" onclick="closeLicenseModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        <i class="fas fa-save mr-2"></i> Update License
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Invoices Modal -->
    <div id="invoicesModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-file-invoice-dollar text-indigo-600 mr-2 text-xl"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Client Invoices</h3>
                </div>
                <button type="button" onclick="closeInvoicesModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div id="invoicesLoading" class="text-center py-6 text-gray-500">
                    <i class="fas fa-spinner fa-spin text-2xl mb-2 text-indigo-600"></i>
                    <p>Loading client invoices...</p>
                </div>
                <div id="invoicesContent" class="hidden overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Issue Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody id="invoicesTableBody" class="divide-y divide-gray-200 text-sm">
                            <!-- Populated via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="px-6 py-3 bg-gray-50 rounded-b-lg flex justify-end">
                <button type="button" onclick="closeInvoicesModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">Close</button>
            </div>
        </div>
    </div>

    <!-- Submit Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-paper-plane text-green-600 mr-2 text-xl"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Submit Payment Proof</h3>
                </div>
                <button type="button" onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('license.submit-payment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction ID <span class="text-red-500">*</span></label>
                        <input type="text" name="transaction_id" placeholder="e.g. TRX9823719" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" placeholder="e.g. 600.00" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <input type="text" name="payment_method" placeholder="e.g. Bank Transfer / bKash / PayPal"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Screenshot Proof (Optional)</label>
                        <input type="file" name="screenshot" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2" placeholder="Additional details..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fas fa-paper-plane mr-1"></i> Submit Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Check Submission Status Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-search-dollar text-purple-600 mr-2 text-xl"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Check Payment Submission</h3>
                </div>
                <button type="button" onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                    <div class="flex space-x-2">
                        <input type="text" id="check_transaction_id" placeholder="e.g. TRX9823719"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        <button type="button" onclick="performStatusCheck()" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Search
                        </button>
                    </div>
                </div>
                <div id="statusResultBox" class="hidden p-4 rounded-md border text-sm">
                    <!-- Populated via JS -->
                </div>
            </div>
            <div class="px-6 py-3 bg-gray-50 rounded-b-lg flex justify-end">
                <button type="button" onclick="closeStatusModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">Close</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openLicenseModal() {
            document.getElementById('licenseModal').classList.remove('hidden');
        }
        function closeLicenseModal() {
            document.getElementById('licenseModal').classList.add('hidden');
        }

        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function openStatusModal() {
            document.getElementById('statusModal').classList.remove('hidden');
        }
        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function openInvoicesModal() {
            document.getElementById('invoicesModal').classList.remove('hidden');
            document.getElementById('invoicesLoading').classList.remove('hidden');
            document.getElementById('invoicesContent').classList.add('hidden');

            fetch('{{ route("license.invoices") }}')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('invoicesLoading').classList.add('hidden');
                    document.getElementById('invoicesContent').classList.remove('hidden');

                    const tbody = document.getElementById('invoicesTableBody');
                    tbody.innerHTML = '';

                    const invoices = data.invoices || [];

                    if (invoices.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No invoices found.</td></tr>`;
                        return;
                    }

                    invoices.forEach(inv => {
                        const statusClass = inv.status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                        tbody.innerHTML += `
                            <tr>
                                <td class="px-4 py-3 font-semibold text-gray-900">${inv.invoice_number}</td>
                                <td class="px-4 py-3 text-gray-600">${inv.issue_date || '-'}</td>
                                <td class="px-4 py-3 text-gray-600">${inv.due_date || '-'}</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">$${parseFloat(inv.total_amount).toFixed(2)}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold ${statusClass}">${inv.status ? inv.status.toUpperCase() : 'UNKNOWN'}</span>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(err => {
                    document.getElementById('invoicesLoading').classList.add('hidden');
                    alert('Error loading invoices: ' + err.message);
                });
        }
        function closeInvoicesModal() {
            document.getElementById('invoicesModal').classList.add('hidden');
        }

        function performStatusCheck() {
            const trxId = document.getElementById('check_transaction_id').value.trim();
            if (!trxId) {
                alert('Please enter a Transaction ID');
                return;
            }

            const box = document.getElementById('statusResultBox');
            box.classList.remove('hidden');
            box.className = 'p-4 rounded-md border text-sm bg-gray-50 border-gray-200 text-gray-600';
            box.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Checking submission status...';

            fetch('{{ route("license.submission-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ transaction_id: trxId })
            })
            .then(res => {
                const contentType = res.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return res.json();
                }
                throw new Error('Server response was not JSON (HTTP status ' + res.status + ')');
            })
            .then(data => {
                if (data.found || data.success) {
                    const status = (data.status || 'unknown').toLowerCase();
                    let badgeClass = 'bg-yellow-100 border-yellow-300 text-yellow-800';
                    if (status === 'approved') badgeClass = 'bg-green-100 border-green-300 text-green-800';
                    if (status === 'rejected') badgeClass = 'bg-red-100 border-red-300 text-red-800';

                    box.className = `p-4 rounded-md border ${badgeClass}`;
                    box.innerHTML = `
                        <div class="font-bold text-base mb-1">Submission: ${data.submission_number || trxId}</div>
                        <div><strong>Status:</strong> ${status.toUpperCase()}</div>
                        <div><strong>Amount:</strong> $${data.amount || 0}</div>
                        <div><strong>Message:</strong> ${data.message || 'No additional message.'}</div>
                        ${data.reviewed_at ? `<div class="text-xs mt-2 opacity-75">Reviewed at: ${data.reviewed_at}</div>` : ''}
                    `;
                } else {
                    box.className = 'p-4 rounded-md border bg-red-50 border-red-200 text-red-700';
                    box.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i> ${data.message || 'No submission found for this Transaction ID.'}`;
                }
            })
            .catch(err => {
                box.className = 'p-4 rounded-md border bg-red-50 border-red-200 text-red-700';
                box.innerHTML = 'Check error: ' + err.message;
            });
        }
    </script>
@endsection
