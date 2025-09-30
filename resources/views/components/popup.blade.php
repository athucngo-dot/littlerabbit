<div x-data="popupHandler()" x-ref="popup" x-init="initAddToCart($data)" x-cloak>
    <!-- Overlay -->
    <div 
        x-show="show"
        x-transition.opacity.duration.300ms
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex items-center justify-center"
        @click="close()"
    >

        <!-- Modal -->
        <div
            x-show="show"
            x-transition.scale.duration.300ms
            class="bg-mint text-gray-500 px-10 py-6 rounded-lg shadow-lg w-full max-w-md relative z-50"
            @click.stop
        >
            <!-- Close button -->
            <button @click="close()" class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
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

            <!-- Error message -->
            <p x-show="type === 'error'" class="text-gray-500 font-medium text-center" x-text="message"></p>
            
            <!-- Success Message -->
            <div x-show="type === 'success'">
                <div class="flex items-center justify-center">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <img :src="image" alt="Product Image" class="h-40 w-40 object-cover mx-auto mb-4">
                            <h4 class="font-bold text-gray-800" x-text="name"></h4>
                            $<span class="font-semibold text-center" x-text="Number(price).toFixed(2)"></span>
                        </div>
                        <div class="text-center">
                            <!-- Success Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor" 
                                class="w-16 h-16 text-green-500 text-center mx-auto mb-4">
                                <path stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    stroke-width="2" 
                                    d="M9 12l2 2l4 -4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg font-medium mb-4 text-center" x-text="message"></p>
                            <button type="button" id="viewCartBtn" @click="window.location.href='/cart'"
                                    class="bg-aqua hover:bg-aqua-2 text-white px-6 py-3 rounded-lg font-semibold">
                                View Cart
                            </button>
                        </div>
                    </div>
                </div>
                <div x-show="suggested.length > 0" class="mt-4 text-left">
                    <h4 class="font-semibold mb-2 text-2xl">You may also like:</h4>
                    <ul class="grid grid-cols-3 gap-2">
                        <template x-for="item in suggested" :key="item.id">
                            <li class="text-center text-xs">
                                <a :href="`/products/${item.slug}`">
                                    <img :src="item.image" class="w-full h-16 object-cover rounded mb-1">
                                    <h4 class="font-bold text-gray-800" x-text="item.name"></h4>
                                    $<span class="font-semibold text-center" x-text="Number(item.price).toFixed(2)"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Alpine.js component for popup handling
function popupHandler() {
    return {
        //initial states
        show: false,
        type: null,
        message: '',
        suggested: [],
        image: '',
        name: '',
        price: '',
        initAddToCart(popup) {
            let selectedColorId = null;
            let selectedSizeId = null;

            // Color selection
            document.querySelectorAll("#colorOptions button").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.querySelectorAll("#colorOptions button").forEach(b => b.classList.remove("ring-2", "ring-aqua"));
                    btn.classList.add("ring-2", "ring-aqua");
                    selectedColorId = btn.getAttribute("data-color-id");
                });
            });

            // Size selection
            document.querySelectorAll("#sizeOptions button").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.querySelectorAll("#sizeOptions button").forEach(b => b.classList.remove("bg-aqua", "text-white"));
                    btn.classList.add("bg-aqua", "text-white");
                    selectedSizeId = btn.getAttribute("data-size-id");
                });
            });

            const addBtn = document.getElementById("addToCartBtn");
            // Prevent multiple event listeners
            if (!addBtn || addBtn.dataset.listenerAttached) 
                return;

            addBtn.addEventListener("click", async function () {
                if (!selectedColorId || !selectedSizeId) {
                    popup.open({ type: 'error', message: "Please select both size and color before adding to cart." });
                    return;
                }

                try {
                    // Send AJAX request to add to cart
                    const res = await fetch("/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            product_slug: this.getAttribute("data-product-slug"),
                            size_id: selectedSizeId,
                            color_id: selectedColorId,
                            quantity: document.getElementById("quantity").value
                        })
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        // handle errors, including Laravel validation errors
                        const firstError = data.errors ? Object.values(data.errors)[0][0] : data.message;
                        popup.open({ type: 'error', message: firstError || "Failed to add to cart." });
                        return;
                    }

                    if (data.success) {
                        // Update cart count in header
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.popup.cartCount }));
                        
                        // Show success popup with suggested items
                        popup.open({ type: 'success', 
                            message: data.popup.message, 
                            suggested: data.popup.suggested || [],
                            image: data.popup.product.image || '',
                            name: data.popup.product.name || '',
                            price: data.popup.product.price || ''
                        });
                    } else {
                        // handle errors, including Laravel validation errors (422)
                        popup.open({ type: 'error', message: "Failed to add to cart: " + (data.message || "Unknown error") });
                    }
                } catch (err) {
                    // Network or server error
                    console.error("Network or server error:", err);
                    popup.open({ type: 'error', message: "Something went wrong. Please try again." });
                }
            });
        },
        open(data) {
            // Set popup data and show
            this.type = data.type || 'success';
            this.message = data.message || '';
            this.suggested = data.suggested || [];
            this.image = data.image || '';
            this.name = data.name || '';
            this.price = data.price || '';
            this.show = true;
        },
        close() {
            // Hide popup
            this.show = false;
        }
    }
}
</script>
