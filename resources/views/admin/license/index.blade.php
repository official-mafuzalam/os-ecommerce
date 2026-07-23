<x-admin-layout>
    @section('title', 'Subscription & License Management')
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Subscription & License Management</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage OctoSync client subscription, view invoices, and submit payment proofs.</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <form action="{{ route('admin.license.refresh') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Refresh Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @php
                $isValid = $status['valid'] ?? false;
                $currentStatus = $status['subscription']['status'] ?? $status['status'] ?? 'unknown';
                $isExpired = $status['subscription']['is_expired'] ?? $status['is_expired'] ?? false;

                $badgeBg = $isValid ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($isInGracePeriod ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300');
            @endphp

            <!-- Status Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Card 1: Subscription Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Subscription Status</div>
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 text-sm font-bold rounded-full {{ $badgeBg }}">
                            {{ strtoupper($currentStatus) }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $isValid ? 'Valid' : 'Action Required' }}
                        </span>
                    </div>
                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                        <p><strong>Auto Renew:</strong> {{ ($status['subscription']['auto_renew'] ?? false) ? 'Enabled' : 'Disabled' }}</p>
                        <p class="mt-1"><strong>Checked:</strong> {{ \Carbon\Carbon::parse($status['checked_at'] ?? $status['verified_at'] ?? now())->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Card 2: Client & Product Info -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Client Info</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $status['client']['company_name'] ?? 'Client Company' }}</h3>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                        <p><strong>Email:</strong> {{ $status['client']['company_email'] ?? 'N/A' }}</p>
                        <p><strong>Product:</strong> {{ $status['product']['name'] ?? 'School Management System' }} ({{ $status['product']['version'] ?? 'v1.0' }})</p>
                    </div>
                </div>

                <!-- Card 3: Expiration Details -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Expiration Details</div>
                    @php
                        $expiresAtStr = $status['subscription']['expires_at'] ?? $status['client']['license_expires_at'] ?? null;
                    @endphp
                    <div class="text-2xl font-extrabold text-gray-900 dark:text-white">
                        {{ $status['subscription']['days_until_expiry'] ?? $status['days_until_expiry'] ?? 'N/A' }} Days
                    </div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        <p><strong>Expires On:</strong> {{ $expiresAtStr ? \Carbon\Carbon::parse($expiresAtStr)->format('M d, Y') : 'Lifetime' }}</p>
                        <p class="text-xs text-gray-500 mt-1">({{ $status['subscription']['expires_at_human'] ?? $status['expires_at_human'] ?? 'N/A' }})</p>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation for Sections -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6 border border-gray-200 dark:border-gray-700">
                <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Manage Key & Billing Operations</h2>
                </div>

                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left: Update License Key & Status Search -->
                    <div class="space-y-6">
                        <!-- Update License Key Card -->
                        <div class="p-5 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3">Update License Key</h3>
                            <form action="{{ route('admin.license.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">License Key</label>
                                    <input type="text" name="license_key"
                                        value="{{ old('license_key', config('license.license_key', '')) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="e.g. OCTO-SCHOOL-2026-X89B2" required>
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                    Save & Refresh License
                                </button>
                            </form>
                        </div>

                        <!-- Check Submission Status Card -->
                        <div class="p-5 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3">Check Payment Submission Status</h3>
                            <div class="space-y-3">
                                <div class="flex space-x-2">
                                    <input type="text" id="admin_trx_id" placeholder="Transaction ID (e.g. TRX9823719)"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm">
                                    <button type="button" onclick="checkAdminTrxStatus()" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700">
                                        Check
                                    </button>
                                </div>
                                <div id="adminTrxResult" class="hidden p-3 rounded text-sm border"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Submit Manual Payment Form -->
                    <div class="p-5 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3">Submit Manual Payment Proof</h3>
                        <form action="{{ route('admin.license.submit-payment') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transaction ID <span class="text-red-500">*</span></label>
                                <input type="text" name="transaction_id" placeholder="e.g. TRX9823719" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="amount" placeholder="600.00" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                                    <input type="text" name="payment_method" placeholder="Bank / bKash"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Screenshot Proof (Optional)</label>
                                <input type="file" name="screenshot" accept="image/*"
                                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                <textarea name="notes" rows="2" placeholder="Notes..."
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm"></textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                Submit Payment Proof
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Client Invoices Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Client Invoices</h2>
                    <button type="button" onclick="loadAdminInvoices()" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                        Reload Invoices
                    </button>
                </div>
                <div class="p-6">
                    <div id="adminInvoicesLoading" class="text-center py-6 text-gray-500">
                        <svg class="animate-spin h-6 w-6 text-indigo-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Loading client invoices...</span>
                    </div>
                    <div id="adminInvoicesContent" class="hidden overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Invoice #</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Issue Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Due Date</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody id="adminInvoicesTableBody" class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <!-- JavaScript Filled -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                loadAdminInvoices();
            });

            function loadAdminInvoices() {
                const loading = document.getElementById('adminInvoicesLoading');
                const content = document.getElementById('adminInvoicesContent');
                loading.classList.remove('hidden');
                content.classList.add('hidden');

                fetch('{{ route("admin.license.invoices") }}')
                    .then(res => res.json())
                    .then(data => {
                        loading.classList.add('hidden');
                        content.classList.remove('hidden');

                        const tbody = document.getElementById('adminInvoicesTableBody');
                        tbody.innerHTML = '';
                        const invoices = data.invoices || [];

                        if (invoices.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No invoices found for this license key.</td></tr>`;
                            return;
                        }

                        invoices.forEach(inv => {
                            const badge = inv.status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300';
                            tbody.innerHTML += `
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">${inv.invoice_number}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">${inv.issue_date || '-'}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">${inv.due_date || '-'}</td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-900 dark:text-white">$${parseFloat(inv.total_amount).toFixed(2)}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold ${badge}">${(inv.status || 'unknown').toUpperCase()}</span>
                                    </td>
                                </tr>
                            `;
                        });
                    })
                    .catch(err => {
                        loading.classList.add('hidden');
                        console.error('Invoices load error:', err);
                    });
            }

            function checkAdminTrxStatus() {
                const trxId = document.getElementById('admin_trx_id').value.trim();
                const box = document.getElementById('adminTrxResult');

                if (!trxId) {
                    alert('Please enter a Transaction ID');
                    return;
                }

                box.classList.remove('hidden');
                box.className = 'p-3 rounded text-sm border bg-gray-50 border-gray-200 text-gray-600';
                box.innerHTML = 'Searching...';

                fetch('{{ route("admin.license.submission-status") }}', {
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
                        box.className = 'p-3 rounded text-sm border bg-green-50 border-green-300 text-green-800';
                        box.innerHTML = `
                            <div><strong>Submission:</strong> ${data.submission_number || trxId}</div>
                            <div><strong>Status:</strong> ${status.toUpperCase()}</div>
                            <div><strong>Amount:</strong> $${data.amount || 0}</div>
                            <div><strong>Message:</strong> ${data.message || ''}</div>
                        `;
                    } else {
                        box.className = 'p-3 rounded text-sm border bg-red-50 border-red-200 text-red-700';
                        box.innerHTML = data.message || 'No submission found for this Transaction ID.';
                    }
                })
                .catch(err => {
                    box.className = 'p-3 rounded text-sm border bg-red-50 border-red-200 text-red-700';
                    box.innerHTML = 'Check error: ' + err.message;
                });
            }
        </script>
    </x-slot>
</x-admin-layout>
