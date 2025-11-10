<div x-data="globalPopup()" x-show="visible" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >

    <div class="relative bg-mint text-gray-500 rounded-xl shadow-lg p-6 max-w-md w-full">
        
        <!-- Close button -->
        <button @click="visible = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
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

        <div x-text="title" class="font-bold text-center mb-2"></div>
        <div x-html="message" class="text-center"></div>
    </div>
</div>