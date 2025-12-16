document.addEventListener('DOMContentLoaded', () => {
    const stripe = Stripe(import.meta.env.VITE_STRIPE_PUBLIC);
    const elements = stripe.elements();

    const card = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                fontSize: '16px',
                color: '#1a1a1a',
                '::placeholder': {
                    color: '#888',
                },
            },
            invalid: {
                color: '#ff4d4f',
            },
        },
    });

    card.mount('#card-element');

    const payBtn = document.getElementById('pay-btn');
    const errors = document.getElementById('card-errors');

    payBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        errors.textContent = '';
        payBtn.disabled = true;
        payBtn.innerText = 'Processing...';

        try {
            const first_name = document.getElementById('first_name').value;
            const last_name = document.getElementById('last_name').value;
            const phone_number = document.getElementById('phone_number').value;

            const addressSelected = document.querySelector('input[name="address_id"]:checked');
            const address_id = addressSelected ? addressSelected.value : 0;

            const street = document.getElementById('street').value;
            const city = document.getElementById('city').value;
            const province = document.getElementById('province').value;
            const postal_code = document.getElementById('postal_code').value;
            const country = document.getElementById('country').value;

            const amount = parseFloat(document.querySelector('[data-total]').value, 10);

            // Create PaymentIntent on the backend
            const res = await fetch('/checkout/payment-intent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify({
                    amount, first_name, last_name, phone_number,
                    address_id, street, city,
                    province, postal_code, country
                }),
            });

            const errorFields = ['first_name', 'last_name', 'phone_number', 'street', 'city', 'province', 'postal_code', 'country'];
            setErrorFields(errorFields, true);

            if (!res.ok) {
                if (res.status === 422) {
                    const errorData = await res.json();

                    console.log('Validation errors:', errorData.errors);

                    setErrorFields(errorFields, false, errorData);

                } else {
                    throw new Error(`Server returned ${res.status}`);
                }
            }

            let data;
            try {
                data = await res.json();
            } catch (jsonErr) {
                throw new Error('Invalid JSON response from server');
            }

            const clientSecret = data.clientSecret;
            const orderNumber = data.orderNumber;
            if (!clientSecret) {
                throw new Error('No clientSecret returned from server');
            }

            // Confirm card payment
            const result = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card },
            });

            if (result.error) {
                errors.textContent = result.error.message;
                payBtn.disabled = false;
                payBtn.innerText = 'Place Order';
            } else if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                // redirect to success page
                window.location.href = `/checkout/success/${orderNumber}`;
            }
        } catch (err) {
            console.error(err);
            errors.textContent = `Payment failed: ${err.message}`;
            payBtn.disabled = false;
            payBtn.innerText = 'Place Order';
        }
    });

    // live card validation
    card.on('change', (event) => {
        errors.textContent = event.error ? event.error.message : '';
    });
});

// Set or clear error messages for specified fields
function setErrorFields(errorFields, reset = true, errorData = []) {
    errorFields.forEach(field => {
        const el = document.getElementById(`${field}-error`);
        if (el) {
            let errorDataLocal = '';
            if (!reset) {
                errorDataLocal = errorData.errors[field] ? errorData.errors[field][0] : '';
            }
            el.textContent = errorDataLocal;
        }
    });
}
