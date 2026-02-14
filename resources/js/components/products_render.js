export function renderProducts(products) {

    const productsGrid = document.getElementById('products-grid');

    products.forEach(product => {

        const card = document.createElement('a');
        card.href = `/products/${product.slug}`;
        card.className =
            "block bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition-transform transform hover:scale-105";

        // Image section
        const imageWrapper = document.createElement('div');
        imageWrapper.className =
            "aspect-[3/4] flex items-center justify-center bg-[#ffe7a3]";

        const img = document.createElement('img');
        img.src = product.image;
        img.alt = product.name;
        img.className = "h-full w-full object-cover";
        img.loading = "lazy";
        img.decoding = "async";

        img.style.opacity = "0";
        img.style.transition = "opacity 0.2s ease";

        img.onload = () => img.style.opacity = "1";
        img.onerror = () => {
            img.src = "/images/default_img.png";
            img.style.opacity = "1";
        };

        imageWrapper.appendChild(img);

        // Content section
        const contentWrapper = document.createElement('div');
        contentWrapper.className = "p-4 text-center";

        const title = document.createElement('h3');
        title.className = "font-semibold text-lg text-ink";
        title.textContent = product.name;

        contentWrapper.appendChild(title);

        const price = parseFloat(product.price);
        const dealPrice = parseFloat(product.price_after_deals);

        // Price section
        if (dealPrice !== price) {

            // Discounted price
            const dealPriceEl = document.createElement('p');
            dealPriceEl.className = "text-ink-60 mt-1";

            dealPriceEl.innerHTML = `
                <span>$${dealPrice.toFixed(2)}</span>
                (<span class="text-red-500">-${parseFloat(product.discount)}%</span>)
            `;

            // Original price
            const originalPriceEl = document.createElement('p');
            originalPriceEl.className = "text-ink-60 mt-1";

            originalPriceEl.innerHTML = `
                <span class="text-sm">Was: </span>
                <span class="line-through text-sm">$${price.toFixed(2)}</span>
            `;

            contentWrapper.appendChild(dealPriceEl);
            contentWrapper.appendChild(originalPriceEl);

            // Deals label
            const dealsLabel = document.createElement('p');
            dealsLabel.className = "text-ink-60 mt-1 text-xs";
            dealsLabel.textContent = "Eligible for Deals:";
            contentWrapper.appendChild(dealsLabel);

            // deal list
            product.deals.forEach(deal => {
                const dealEl = document.createElement('p');
                dealEl.className = "text-xs text-ink-60";
                dealEl.innerHTML = `
                    <span>${deal.name}</span>
                    (<span class="text-red-500">-${parseFloat(deal.percentage_off)}%</span>)
                `;
                contentWrapper.appendChild(dealEl);
            });

        } else {

            // Regular price
            const priceEl = document.createElement('p');
            priceEl.className = "text-ink-60 mt-1";
            priceEl.textContent = `$${price.toFixed(2)}`;
            contentWrapper.appendChild(priceEl);
        }

        // Append image and content to card
        card.appendChild(imageWrapper);
        card.appendChild(contentWrapper);
        productsGrid.appendChild(card);
    });
}
