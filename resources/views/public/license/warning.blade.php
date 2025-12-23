@extends('layouts.license')

@section('title', 'License Verification')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-blue-600 px-6 py-4">
                    <div class="flex items-center">
                        <i class="fas fa-certificate text-white text-2xl mr-3"></i>
                        <h1 class="text-2xl font-bold text-white">License Status</h1>
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
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">License Information</h2>

                        @php
                            // Determine status
                            $statusColor = 'green';
                            $statusBg = 'bg-green-100';
                            $statusTextColor = 'text-green-800';
                            $statusIcon = 'fa-check-circle';
                            $statusText = 'Active';

                            if (!$status['valid']) {
                                $blockedStatuses = ['suspended', 'cancelled', 'revoked', 'terminated'];

                                if (in_array($status['status'], $blockedStatuses)) {
                                    $statusColor = 'gray';
                                    $statusBg = 'bg-gray-100';
                                    $statusTextColor = 'text-gray-800';
                                    $statusIcon = 'fa-ban';
                                    $statusText = ucfirst($status['status']);
                                } elseif ($isInGracePeriod) {
                                    $statusColor = 'yellow';
                                    $statusBg = 'bg-yellow-100';
                                    $statusTextColor = 'text-yellow-800';
                                    $statusIcon = 'fa-clock';
                                    $statusText = 'Grace Period';
                                } elseif ($status['is_expired']) {
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
                                        <h3 class="text-xl font-bold text-gray-900">License {{ $statusText }}</h3>
                                        <p class="text-gray-500 text-sm">
                                            Last checked:
                                            {{ \Carbon\Carbon::parse($status['verified_at'])->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                @if ($status['api_unreachable'] ?? false)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                        <div class="flex">
                                            <i class="fas fa-wifi-slash text-yellow-400 mr-2"></i>
                                            <p class="text-sm text-yellow-700">Using cached data. Unable to reach license
                                                server.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Details -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Status:</span>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium {{ $statusBg }} {{ $statusTextColor }}">
                                            {{ $status['status'] }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Valid:</span>
                                        <span
                                            class="font-medium {{ $status['valid'] ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $status['valid'] ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Expired:</span>
                                        <span
                                            class="font-medium {{ $status['is_expired'] ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $status['is_expired'] ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client & Product Information -->
                        @if (!empty($status['client']))
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Client Details -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-building text-gray-400 mr-2"></i>
                                        <h4 class="font-semibold text-gray-900">Client Details</h4>
                                    </div>
                                    <div class="space-y-2">
                                        <div>
                                            <p class="text-sm text-gray-500">Company</p>
                                            <p class="font-medium">{{ $status['client']['company_name'] ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">License Type</p>
                                            <p class="font-medium">{{ $status['client']['license_type'] ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Expiration Date</p>
                                            <p class="font-medium">
                                                @if (isset($status['client']['license_expires_at']))
                                                    {{ \Carbon\Carbon::parse($status['client']['license_expires_at'])->format('M d, Y H:i') }}
                                                    <span class="text-gray-500 text-sm block">
                                                        ({{ $status['expires_at_human'] ?? 'N/A' }})
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Details -->
                                @if (!empty($status['product']))
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-box text-gray-400 mr-2"></i>
                                            <h4 class="font-semibold text-gray-900">Product Details</h4>
                                        </div>
                                        <div class="space-y-2">
                                            <div>
                                                <p class="text-sm text-gray-500">Product</p>
                                                <p class="font-medium">{{ $status['product']['name'] ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Version</p>
                                                <p class="font-medium">{{ $status['product']['version'] ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Days until expiry</p>
                                                <p
                                                    class="font-medium {{ ($status['days_until_expiry'] ?? 0) < 0 ? 'text-red-600' : (($status['days_until_expiry'] ?? 0) <= 30 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ $status['days_until_expiry'] ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                            <strong>{{ \Carbon\Carbon::parse($status['client']['license_expires_at'])->format('F j, Y') }}</strong>
                                            ({{ $status['expires_at_human'] }}).
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

                        <!-- Status-specific messages -->
                        @if (!$status['valid'])
                            <div class="mt-6">
                                @if (in_array($status['status'], ['suspended', 'cancelled', 'revoked', 'terminated']))
                                    <div class="bg-gray-800 text-white p-4 rounded-lg">
                                        <div class="flex items-start">
                                            <i class="fas fa-ban text-2xl mr-3 mt-1"></i>
                                            <div>
                                                <h4 class="font-bold text-lg">License {{ ucfirst($status['status']) }}</h4>
                                                <p class="mt-1">
                                                    This license has been {{ $status['status'] }} and cannot be used.
                                                    @if ($status['status'] === 'suspended')
                                                        Please contact support to resolve this issue.
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($status['is_expired'] && !$isInGracePeriod)
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                                        <div class="flex items-start">
                                            <i class="fas fa-calendar-times text-red-400 text-2xl mr-3"></i>
                                            <div>
                                                <h4 class="font-semibold text-red-800">License Expired</h4>
                                                <p class="text-red-700 mt-1">
                                                    Your license expired on
                                                    {{ \Carbon\Carbon::parse($status['client']['license_expires_at'])->format('F j, Y') }}
                                                    and the grace period has ended.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Refresh Status -->
                        <div
                            class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-blue-600 mb-4">
                                <i class="fas fa-sync-alt text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Refresh Status</h3>
                            <p class="text-gray-500 text-sm mb-4">Check for latest license status</p>
                            <form action="{{ route('license.refresh') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-white border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-sync-alt mr-2"></i> Refresh Now
                                </button>
                            </form>
                        </div>

                        <!-- Update License -->
                        <div
                            class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-yellow-600 mb-4">
                                <i class="fas fa-key text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Update License</h3>
                            <p class="text-gray-500 text-sm mb-4">Enter a new license key</p>
                            <button type="button" onclick="openLicenseModal()"
                                class="w-full bg-white border border-yellow-600 text-yellow-600 px-4 py-2 rounded-lg hover:bg-yellow-50 transition-colors">
                                <i class="fas fa-edit mr-2"></i> Update Key
                            </button>
                        </div>

                        <!-- Return Home -->
                        <div
                            class="bg-white border border-gray-200 rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                            <div class="text-gray-600 mb-4">
                                <i class="fas fa-home text-4xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Return Home</h3>
                            <p class="text-gray-500 text-sm mb-4">Go back to homepage</p>
                            <a href="{{ url('/') }}"
                                class="block w-full bg-white border border-gray-600 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-home mr-2"></i> Home
                            </a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 pt-6 text-center">
                        <p class="text-gray-500 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            License verification system powered by Octosync Software
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update License Modal -->
    <div id="licenseModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
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
                        <label for="license_key" class="block text-sm font-medium text-gray-700 mb-2">
                            License Key
                        </label>
                        <input type="text" id="license_key" name="license_key"
                            value="{{ old('license_key', config('license.license_key', '')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="Enter 36-character license key" required
                            pattern="[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}">
                        <p class="mt-2 text-sm text-gray-500">
                            Enter the 36-character license key provided by Octosync Software
                        </p>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded mb-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-blue-400 mr-2"></i>
                            <p class="text-sm text-blue-700">Updating the license key will immediately verify the new key.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" onclick="closeLicenseModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <i class="fas fa-save mr-2"></i> Update License
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openLicenseModal() {
            document.getElementById('licenseModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeLicenseModal() {
            document.getElementById('licenseModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLicenseModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('licenseModal').addEventListener('click', function(e) {
            if (e.target.id === 'licenseModal') {
                closeLicenseModal();
            }
        });
    </script>
@endsection
