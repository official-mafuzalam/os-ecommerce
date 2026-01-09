<x-admin-layout>
    @section('title', 'Edit Customer')
    <x-slot name="main">
        <!-- Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Customer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Edit {{ $customer->full_name }}</h1>
                        <p class="text-xs text-gray-500">Update customer information</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Basic Information</h2>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" name="full_name"
                                        value="{{ old('full_name', $customer->full_name) }}" required
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Customer Type *</label>
                                    <select name="type"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="guest"
                                            {{ old('type', $customer->type) == 'guest' ? 'selected' : '' }}>Guest
                                        </option>
                                        <option value="registered"
                                            {{ old('type', $customer->type) == 'registered' ? 'selected' : '' }}>
                                            Registered</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Phone *</label>
                                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                        required
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Password Update (Only for registered customers) -->
                            @if ($customer->type === 'registered')
                                <div class="pt-3 border-t border-gray-100">
                                    <h3 class="text-xs font-medium text-gray-900 mb-3">Password Update</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">New
                                                Password</label>
                                            <input type="password" name="password"
                                                class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Confirm
                                                Password</label>
                                            <input type="password" name="password_confirmation"
                                                class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Leave blank to keep current password</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Additional Information</h2>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Date of Birth</label>
                                    <input type="date" name="date_of_birth"
                                        value="{{ old('date_of_birth', optional($customer->date_of_birth)->format('Y-m-d')) }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Gender</label>
                                    <select name="gender"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Gender</option>
                                        <option value="male"
                                            {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other"
                                            {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="is_active" value="1" id="is_active"
                                        {{ old('is_active', $customer->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="is_active" class="text-xs font-medium text-gray-700">Active
                                        Customer</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="accepts_marketing" value="1"
                                        id="accepts_marketing"
                                        {{ old('accepts_marketing', $customer->accepts_marketing) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="accepts_marketing" class="text-xs font-medium text-gray-700">Accepts
                                        Marketing</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses -->
                    @if ($customer->addresses && $customer->addresses->count() > 0)
                        <div class="bg-white rounded-lg border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h2 class="text-sm font-medium text-gray-900">Update Addresses</h2>
                            </div>
                            <div class="p-4 space-y-4">
                                @foreach ($customer->addresses as $index => $address)
                                    <div class="p-4 bg-gray-50 rounded border border-gray-200">
                                        <h3 class="text-xs font-medium text-gray-900 mb-3">Address {{ $index + 1 }}
                                        </h3>
                                        <input type="hidden" name="addresses[{{ $address->id }}][id]"
                                            value="{{ $address->id }}">

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Full
                                                    Name</label>
                                                <input type="text"
                                                    name="addresses[{{ $address->id }}][full_name]"
                                                    value="{{ old('addresses.' . $address->id . '.full_name', $address->full_name) }}"
                                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                                                <input type="text" name="addresses[{{ $address->id }}][phone]"
                                                    value="{{ old('addresses.' . $address->id . '.phone', $address->phone) }}"
                                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Address Line
                                                1</label>
                                            <input type="text"
                                                name="addresses[{{ $address->id }}][address_line_1]"
                                                value="{{ old('addresses.' . $address->id . '.address_line_1', $address->address_line_1) }}"
                                                class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>

                                        <div class="mt-3">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Address Line 2
                                                (Optional)</label>
                                            <input type="text"
                                                name="addresses[{{ $address->id }}][address_line_2]"
                                                value="{{ old('addresses.' . $address->id . '.address_line_2', $address->address_line_2) }}"
                                                class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>

                                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">City</label>
                                                <input type="text" name="addresses[{{ $address->id }}][city]"
                                                    value="{{ old('addresses.' . $address->id . '.city', $address->city) }}"
                                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">Area</label>
                                                <input type="text" name="addresses[{{ $address->id }}][area]"
                                                    value="{{ old('addresses.' . $address->id . '.area', $address->area) }}"
                                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Postal
                                                    Code</label>
                                                <input type="text"
                                                    name="addresses[{{ $address->id }}][postal_code]"
                                                    value="{{ old('addresses.' . $address->id . '.postal_code', $address->postal_code) }}"
                                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox"
                                                    name="addresses[{{ $address->id }}][is_default_shipping]"
                                                    value="1" id="default_shipping_{{ $address->id }}"
                                                    {{ old('addresses.' . $address->id . '.is_default_shipping', $address->is_default_shipping) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <label for="default_shipping_{{ $address->id }}"
                                                    class="text-xs font-medium text-gray-700">Default Shipping</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox"
                                                    name="addresses[{{ $address->id }}][is_default_billing]"
                                                    value="1" id="default_billing_{{ $address->id }}"
                                                    {{ old('addresses.' . $address->id . '.is_default_billing', $address->is_default_billing) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <label for="default_billing_{{ $address->id }}"
                                                    class="text-xs font-medium text-gray-700">Default Billing</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-4">
                    <!-- Actions -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="p-4 space-y-2">
                            <button type="submit"
                                class="w-full py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                                Save Changes
                            </button>
                            <a href="{{ route('admin.customers.show', $customer->id) }}"
                                class="block w-full py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors text-center">
                                Cancel
                            </a>
                        </div>
                    </div>

                    <!-- Customer Summary -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Customer Summary</h2>
                        </div>
                        <div class="p-4 space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Total Orders</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $customer->orders()->count() }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total Spent</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    ৳{{ number_format($customer->orders()->where('status', 'delivered')->sum('total_amount'), 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Last Order</p>
                                <p class="text-sm text-gray-900">
                                    @if ($customer->orders()->latest()->first())
                                        {{ $customer->orders()->latest()->first()->created_at->format('M j, Y') }}
                                    @else
                                        No orders yet
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Member Since</p>
                                <p class="text-sm text-gray-900">{{ $customer->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-lg border border-red-200">
                        <div class="px-4 py-3 border-b border-red-200 bg-red-50">
                            <h2 class="text-sm font-medium text-red-700">Danger Zone</h2>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors">
                                    Delete Customer
                                </button>
                            </form>
                            <p class="text-xs text-gray-500 mt-2">
                                Note: Customer can only be deleted if they have no orders.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>
</x-admin-layout>
