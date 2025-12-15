<h1 class="text-2xl font-bold mb-4">Addresses</h1>

@php
    $maxAddressesAllow = config('site.customer.max_addresses');
@endphp

<div x-data="window.loadDashboardAddress({{ $maxAddressesAllow }})" 
     x-init="addresses = @js($addresses)">

    <!-- Address List -->
    <template x-for="address in addresses" :key="address.id">
        <div class="mb-4 p-4 border rounded-xl bg-white">
            
            <!-- Address Show -->
            <div x-show="editing !== address.id">
                <p class="border-b pb-1 flex justify-between items-center">
                    <span x-text="`${address.street}, ${address.city}, ${address.province}, ${(address.postal_code || '').toUpperCase()}, ${address.country}`"></span>

                    <span class="flex gap-4">

                        <!-- Edit -->
                        <button 
                            @click="openEdit(address.id)"
                            class="text-gray-900 hover:text-mint-600 flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                            Edit
                        </button>

                        <!-- Delete -->
                        <button 
                            @click="deleteAddress(address.id)"
                            class="text-gray-900 hover:text-red-600 flex items-center gap-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 6h8" />
                                <path d="M10 6V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2" />
                                <path d="M19 6l-1 12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M9 11v6" />
                                <path d="M14 11v6" /> 
                            </svg>
                            Delete
                        </button>

                    </span>
                </p>
            </div>

            <!-- Edit Mode -->
            <div x-show="editing === address.id" x-transition>
                <form @submit.prevent="saveAddress(address)" class="space-y-3 p-4">

                    <div>
                        <label class="font-semibold block mb-1">Street</label>
                        <input type="text" x-model="address.street" class="w-full border rounded-lg p-1">
                    </div>

                    <div>
                        <label class="font-semibold block mb-1">City</label>
                        <input type="text" x-model="address.city" class="w-full border rounded-lg p-1">
                    </div>

                    <div>
                        <label class="font-semibold block mb-1">Province</label>
                        <select x-model="address.province" class="w-full border rounded-lg p-2">
                            @include('dashboard.partials.list-province')
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold block mb-1">Postal Code</label>
                        <input type="text" x-model="address.postal_code" class="w-full border rounded-lg p-1">
                        <span class="text-xs text-gray-700">Eg. A1AA1A or A1A A1A</span>
                    </div>

                    <div>
                        <label class="font-semibold block mb-1">Country</label>
                        <select x-model="address.country" class="w-full border rounded-lg p-2">
                            <option value="Canada">Canada</option>
                        </select>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-aqua hover:bg-aqua-2 px-4 py-2 rounded-lg text-white font-semibold">
                            Save
                        </button>

                        <button type="button" 
                            @click="cancelEdit()"
                            class="bg-aqua hover:bg-aqua-2 px-4 py-2 rounded-lg text-white font-semibold">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </template>

    <!-- New Address Button + Form -->
    <div class="mt-6">
        @include('dashboard.partials.new-address')
    </div>

</div>
