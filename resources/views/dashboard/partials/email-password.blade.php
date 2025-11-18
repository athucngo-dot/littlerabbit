<h1 class="text-2xl font-bold mb-4">Email & Password</h1>
<div x-data="{
    nameTab: 'password-tab',
    current_password: '',
    new_password: '',
    new_password_confirmation: '',

    openEdit() {
        // Open password edit form, reset fields
        this.nameTab = 'edit-password';
        this.current_password = '';
        this.new_password = '';
        this.new_password_confirmation = '';
    },
    cancelEdit() {
        // Cancel password edit, reset fields
        this.nameTab = 'password-tab';
        this.current_password = '';
        this.new_password = '';
        this.new_password_confirmation = '';
    },

    async savePass() {
        try {
            const res = await fetch('{{ route('customer.update-password') }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    current_password: this.current_password,
                    new_password: this.new_password,
                    new_password_confirmation: this.new_password_confirmation
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
                popup.success('Password updated!');
                this.nameTab = 'password-tab';

                return;
            }
                    
            // fall back : general error message
            popup.error(data.message || 'Something went wrong!');
                
        } catch (err) {
            popup.error('Network or server error!');
        }
    }
}">
    <div>
        <!-- Email -->
        <div class="py-3">
            <label class="font-semibold block mb-1">Email:</label>

            <p class="border-b border-gray-300 pb-1 flex justify-between items-center">
                <span>{{$customer->email}}</span>
            </p>
        </div>
        
        <!-- Password -->
        <div x-show="nameTab === 'password-tab'" x-transition>
            <label class="font-semibold block mb-1">Password:</label>

            <p class="border-b border-gray-300 pb-1 flex justify-between items-center">
                <span>**********</span>

                <button @click="nameTab = 'edit-password'" 
                        class="text-gray-900 hover:text-mint-600 flex items-center gap-1 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                    </svg>
                    Edit
                </button>
            </p>
        </div>
    </div>

    <div x-show="nameTab === 'edit-password'"  x-transition>
        <form @submit.prevent="savePass()" class="bg-white p-6 rounded-xl space-y-4">
            @csrf
            <div>
                <label class="font-semibold block mb-1">Current Password:</label>
                <input type="password" x-model="current_password" class="w-full border rounded-lg p-1">
            </div>

            <div>
                <label class="font-semibold block mb-1">New Password</label>
                <input type="password" x-model="new_password" class="w-full border rounded-lg p-1">
            </div>

            <div>
                <label class="font-semibold block mb-1">Confirm Password:</label>
                <input type="password" x-model="new_password_confirmation" class="w-full border rounded-lg p-1">
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