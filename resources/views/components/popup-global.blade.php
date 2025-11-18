<div 
    x-data="globalPopup()" 
    x-show="visible" 
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    x-transition
>
    <div class="relative bg-mint text-gray-700 rounded-xl shadow-lg p-6 max-w-md w-full mx-4">

        <!-- Close button (hidden for confirm modals) -->
        <template x-if="type !== 'confirm'">
            <button 
                @click="visible = false" 
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor" 
                    class="w-6 h-6">
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </template>

        <!-- Title -->
        <div x-text="title" class="font-bold text-center text-lg mb-2"></div>

        <!-- Message -->
        <div x-html="message" class="text-center"></div>

        <!-- Confirm buttons -->
        <template x-if="type === 'confirm'">
            <div class="flex justify-center gap-4 pt-6">
                <button 
                    @click="confirmCallback(); visible = false" 
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold"
                >
                    Yes
                </button>
                <button 
                    @click="visible = false" 
                    class="bg-white hover:bg-gray-100 text-gray-800 px-4 py-2 rounded-lg font-semibold border"
                >
                    Cancel
                </button>
            </div>
        </template>
    </div>
</div>
