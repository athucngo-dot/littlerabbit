<div>
    <!-- Button -->
    <button 
        x-show="!open && !isOverLimit" 
        @click="open = true" 
        x-transition
        class="bg-aqua hover:bg-aqua-2 px-4 py-2 rounded-lg text-white font-semibold">
        New Address
    </button>

    <!-- Form -->
    <form x-show="open" x-transition @submit.prevent="submitNewAddress" class="space-y-3 p-4">

        <h2 class="text-xl font-bold mb-4">New Address</h2>

        <div>
            <label class="font-semibold block mb-1">Street</label>
            <input type="text" x-model="new_street" class="w-full border rounded-lg p-1">
        </div>

        <div>
            <label class="font-semibold block mb-1">City</label>
            <input type="text" x-model="new_city" class="w-full border rounded-lg p-1">
        </div>

        <div>
            <label class="font-semibold block mb-1">Province</label>
            <select x-model="new_province" class="w-full border rounded-lg p-2">
                @include('dashboard.partials.list-province')
            </select>
        </div>

        <div>
            <label class="font-semibold block mb-1">Postal Code</label>
            <input type="text" x-model="new_postal_code" class="w-full border rounded-lg p-1">
            <span class="text-xs text-gray-700">Eg. A1AA1A or A1A A1A</span>
        </div>

        <div>
            <label class="font-semibold block mb-1">Country</label>
            <select x-model="new_country" class="w-full border rounded-lg p-2">
                <option value="Canada">Canada</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-aqua px-4 py-2 rounded-lg text-white font-semibold">
                Save
            </button>

            <button type="button"
                @click="open = false; reset()"
                class="bg-gray-300 px-4 py-2 rounded-lg font-semibold">
                Cancel
            </button>
        </div>
    </form>
</div>
