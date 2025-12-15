export default function cart() {
    function notifyValidationMsg(errors) {
        let items = '';

        Object.values(errors).forEach(fieldErrors => {
            fieldErrors.forEach(err => items += `<li>${err}</li>`);
        });
        popup.error(`<ul class='text-left list-disc pl-5 space-y-1'>${items}</ul>`);

        return;
    }

    return {
        cartItems: [],
        freeShippingThreshold: 50, // free shipping for orders over $50

        // Initialize the component
        async init() {
            console.log("cart loaded");

            // fetch cart items
            await this.fetchCartItems();
        },

        // fetch cart items from server
        async fetchCartItems() {
            console.log("fetch Cart Items");
            try {
                const res = await fetch('cart/cartList', {
                    headers: { 'Accept': 'application/json' }
                });

                const data = await res.json();
                this.cartItems = data.cartItems ?? [];

            } catch (err) {
                popup.error("Failed to load cart.");
            }
        },

        // check if cart is empty
        get cartIsEmpty() {
            return this.cartItems.length === 0;
        },

        // check if order is eligible for free shipping
        get isFreeShipping() {
            return this.subTotalPrice() >= this.freeShippingThreshold;
        },

        // calculate subtotal price
        subTotalPrice() {
            const total = this.cartItems.reduce((total, item) => {
                const price = item.product.price_after_deals || item.product.price || 0;
                const qty = item.quantity || 0;
                return total + (price * qty);
            }, 0);

            return total;
        },

        // calculate subtotal price
        shippingCost(checkThreshold = true) {
            const subtotal = this.subTotalPrice();

            if (checkThreshold &&
                subtotal >= this.freeShippingThreshold) {
                return 0;
            }

            return subtotal * 0.1; // 10% of subtotal
        },

        // calculate total price
        totalPrice() {
            const total = this.subTotalPrice() + this.shippingCost(true);
            return total;
        },

        // calculate total price for an item
        getItemTotal(item) {
            return (item.quantity * item.product.price_after_deals).toFixed(2);
        },

        // update quantity of an item in cart
        async updateQuantity(item) {
            try {
                let updateItem = {
                    product_id: item.product.id,
                    color_id: item.color_id,
                    size_id: item.size_id,
                    quantity: item.quantity
                };

                const res = await fetch(`/cart/updateQuantity`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify(updateItem)
                });

                const data = await res.json();

                // Handle validation errors
                if (!res.ok && res.status === 422) {
                    notifyValidationMsg(data.errors || 'Failed to update quantity.');
                    return;
                }

                if (res.ok) {
                    // Update cart count in header
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cartCount }));

                    if (data.warning) {
                        item.quantity = data.quantityAllowed;

                        popup.info(data.warning, 'Warning: ');
                    }
                } else {
                    popup.error(data.message || 'Update failed.');
                }
            } catch (err) {
                popup.error('Network error updating quantity.');
            }
        },

        // remove item from cart
        async removeItem(item) {
            popup.confirm(
                "Delete Item",
                "This will delete this item in your cart. Do you confirm to do that ?",
                async () => {
                    try {
                        const res = await fetch(
                            `/cart/remove-item/${item.product.id}/${item.color_id}/${item.size_id}`,
                            {
                                method: 'DELETE',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                }
                            });

                        const data = await res.json();

                        if (res.ok) {
                            // Update cart count in header
                            window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cartCount }));

                            const id = item.product.id + '-' + item.color_id + '-' + item.size_id;
                            this.cartItems = this.cartItems.filter(a =>
                                `${a.product.id}-${a.color_id}-${a.size_id}` !== id
                            );
                        } else {
                            notifyValidationMsg(data.errors || 'Failed to delete item.');
                        }

                    } catch (err) {
                        popup.error('Network error deleting cart item.');
                    }
                }
            );
        },
    };
}
