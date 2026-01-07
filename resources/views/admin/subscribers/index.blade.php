<x-admin-layout>
    @section('title', 'Subscribers Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Subscribers</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage newsletter subscribers</p>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <form action="{{ route('admin.subscribers.bulkAction') }}" method="POST" id="bulkForm">
                @csrf
                <div id="bulk-actions-container"
                    class="hidden mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span id="selected-count" class="text-sm font-medium text-yellow-800">0 selected</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <select name="action" id="bulkAction"
                                class="text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Action</option>
                                <option value="delete">Delete Selected</option>
                                <option value="send_deal">Send Deal</option>
                            </select>
                            <button type="submit" id="applyAction"
                                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                Apply
                            </button>
                            <button type="button" id="cancel-bulk-action"
                                class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Subscribers Table Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-12 px-4 py-3 text-left">
                                    <input type="checkbox" id="selectAll"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subscription Date
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subscribers as $subscriber)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="selected[]" value="{{ $subscriber->id }}"
                                            class="selectItem w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">{{ $subscriber->email }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            {{ $subscriber->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $subscriber->created_at->format('h:i A') }}</div>
                                    </td>

                                    <td class="px-4 py-3 flex justify-end">
                                        <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}"
                                            method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                onclick="return confirm('Unsubscribe this email?')" title="Unsubscribe">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <div>No subscribers found</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($subscribers->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $subscribers->firstItem() }}</span> to
                            <span class="font-medium">{{ $subscribers->lastItem() }}</span> of
                            <span class="font-medium">{{ $subscribers->total() }}</span> subscribers
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($subscribers->onFirstPage())
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $subscribers->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($subscribers->hasMorePages())
                                <a href="{{ $subscribers->nextPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Next
                                </a>
                            @else
                                <span
                                    class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Next
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Deal Selection Modal -->
        <div id="dealModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Send Deal to Subscribers</h3>

                    <form id="dealForm" action="{{ route('admin.subscribers.sendBulkDeal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subscribers" id="selectedSubscribers">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="dealSelect">
                                Choose a Deal
                            </label>
                            <select name="deal_id" id="dealSelect"
                                class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a Deal</option>
                                @foreach ($deals as $deal)
                                    <option value="{{ $deal->id }}">
                                        {{ Str::limit($deal->title, 30) }}
                                        ({{ $deal->discount_percentage ?? $deal->discount }}% OFF)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" id="closeModal"
                                class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                Send Deal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.selectItem');
                const bulkActionsContainer = document.getElementById('bulk-actions-container');
                const selectedCountElement = document.getElementById('selected-count');
                const bulkAction = document.getElementById('bulkAction');
                const applyButton = document.getElementById('applyAction');
                const cancelBulkAction = document.getElementById('cancel-bulk-action');
                const dealModal = document.getElementById('dealModal');
                const closeModal = document.getElementById('closeModal');
                const selectedSubscribers = document.getElementById('selectedSubscribers');
                const dealForm = document.getElementById('dealForm');

                // Update selected count
                function updateSelectedCount() {
                    const selectedCount = document.querySelectorAll('.selectItem:checked').length;
                    selectedCountElement.textContent = `${selectedCount} selected`;

                    if (selectedCount > 0) {
                        bulkActionsContainer.classList.remove('hidden');
                    } else {
                        bulkActionsContainer.classList.add('hidden');
                        bulkAction.value = '';
                    }

                    selectAll.checked = selectedCount === checkboxes.length && checkboxes.length > 0;
                    selectAll.indeterminate = selectedCount > 0 && selectedCount < checkboxes.length;
                }

                // Select all functionality
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateSelectedCount();
                });

                // Individual checkbox functionality
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });

                // Cancel bulk action
                cancelBulkAction.addEventListener('click', function() {
                    checkboxes.forEach(cb => cb.checked = false);
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                    bulkActionsContainer.classList.add('hidden');
                    bulkAction.value = '';
                });

                // Handle bulk action form submission
                document.getElementById('bulkForm').addEventListener('submit', function(e) {
                    const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);

                    if (selected.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one subscriber.');
                        return;
                    }

                    if (bulkAction.value === 'delete') {
                        if (!confirm(`Delete ${selected.length} subscriber(s)?`)) {
                            e.preventDefault();
                        }
                    } else if (bulkAction.value === 'send_deal') {
                        e.preventDefault();
                        // Show the deal modal
                        selectedSubscribers.value = JSON.stringify(selected);
                        dealModal.classList.remove('hidden');
                    } else {
                        e.preventDefault();
                        alert('Please select an action.');
                    }
                });

                // Close modal
                closeModal.addEventListener('click', function() {
                    dealModal.classList.add('hidden');
                });

                // Close modal when clicking outside
                dealModal.addEventListener('click', function(e) {
                    if (e.target === dealModal) {
                        dealModal.classList.add('hidden');
                    }
                });

                // Initialize selected count
                updateSelectedCount();
            });
        </script>
    </x-slot>
</x-admin-layout>
