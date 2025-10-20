export function renderProducts(products) {

    const productsGrid = document.getElementById('products-grid');

    products.forEach(product => {
        const card = document.createElement('a');

        let cardPrice = `<p class="text-ink-60 mt-1">$${parseFloat(product.price).toFixed(2)}</p>`;
        if (parseFloat(product.price_after_deals) != parseFloat(product.price)) {
            cardPrice = `<p class="text-ink-60 mt-1">
                            <span>$${parseFloat(product.price_after_deals).toFixed(2)} </span>
                            (<span class="text-red-500">-${parseFloat(product.discount)}% </span>)
                        </p>
                        <p class="text-ink-60 mt-1">
                            <span class="text-sm">Was: </span>
                            <span class="line-through text-sm">$${parseFloat(product.price).toFixed(2)}</span>
                        </p>`;

            cardPrice += `<p class="text-ink-60 mt-1 text-xs">Eligible for Deals: </p>`;

            product.deals.forEach(deal => {
                cardPrice += `<p class="text-xs text-ink-60">
                                <span>${deal.name} </span>
                                (<span class="text-red-500">-${parseFloat(deal.percentage_off)}%</span>)
                             </p>`;
            });
        }

        card.href = `/products/${product.slug}`;
        card.className = "block bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition-transform transform hover:scale-105";
        card.innerHTML = `
            <div class="aspect-[4/3] flex items-center justify-center bg-[#ffe7a3]">
                <img src="${product.image}" alt="${product.name}" class="h-full w-full object-cover">
            </div>
            <div class="p-4 text-center">
                <h3 class="font-semibold text-lg text-ink">${product.name}</h3>
                ` + cardPrice + `
            </div>
        `;
        productsGrid.appendChild(card);
    });
}