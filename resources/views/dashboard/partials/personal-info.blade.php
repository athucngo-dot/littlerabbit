<h1 class="text-2xl font-bold mb-4">Personal Info</h1>
<div x-data="{
    nameTab: 'fullname',
    first_name: '{{ $customer->first_name }}',
    last_name: '{{ $customer->last_name }}',
    edit_first_name: '{{ $customer->first_name }}',
    edit_last_name: '{{ $customer->last_name }}',

    openEdit() {
        // Open name edit form, set edit fields to current values
        this.edit_first_name = this.first_name;
        this.edit_last_name = this.last_name;
        this.nameTab = 'edit_name';
    },
    cancelEdit() {
        // Cancel name edit, reset edit fields
        this.edit_first_name = this.first_name;
        this.edit_last_name = this.last_name;
        this.nameTab = 'fullname';
    },

    async saveName() {
        try {
            const res = await fetch('{{ route('customer.update-name') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    first_name: this.edit_first_name,
                    last_name: this.edit_last_name
                })
            });

            const data = await res.json();

            // Handle validation errors
            if (!res.ok && res.status === 422) {
                let items = '';
                
                Object.values(data.errors).forEach(fieldErrors => {
                    fieldErrors.forEach(err => items += `<li>${err}</li>`);
                });
                popup.error(`<ul class='text-left list-disc pl-5 space-y-1'>${items}</ul>`);
                
                return;
            }

            if (data.success) {
                popup.success('Name updated!');

                // Update original values on success
                this.first_name = this.edit_first_name;
                this.last_name = this.edit_last_name;
                this.nameTab = 'fullname';

                return;
            }
                    
            // fall back : general error message
            popup.error(data.message || 'Something went wrong!');

        } catch (err) {
            popup.error('Network or server error!');
        }
    }
}">
    <div x-show="nameTab === 'fullname'" x-transition>
        <label class="font-semibold block mb-1">Full Name</label>

        <p class="border-b border-gray-300 pb-1 flex justify-between items-center">
            <span x-text="first_name + ' ' + last_name"></span>

            <button @click="nameTab = 'edit_name'" 
                    class="text-gray-900 hover:text-mint-600 flex items-center gap-1 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                    <path d="M12 20h9" />
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
                Edit
            </button>
        </p>
    </div>
    <div x-show="nameTab === 'edit_name'"  x-transition>
        <form @submit.prevent="saveName()" class="bg-white p-6 rounded-xl space-y-4">
            @csrf
            <div>
                <label class="font-semibold block mb-1">First Name</label>
                <input type="text" x-model="edit_first_name" class="w-full border rounded-lg p-1">
            </div>

            <div>
                <label class="font-semibold block mb-1">Last Name</label>
                <input type="text" x-model="edit_last_name" class="w-full border rounded-lg p-1">
            </div>

            <button type="submit"
                    class="bg-aqua hover:bg-aqua-2 px-4 py-2 rounded-lg text-white font-semibold">
                Save
            </button>

            <button type="button"
                    @click="cancelEdit()"
                    class="bg-aqua hover:bg-aqua-2 px-4 py-2 rounded-lg text-white font-semibold">
                Cancel
            </button>
        </form>
    </div>
</div>