// resources/js/products_new_arrivals.js
let filteredProducts = [];
let currentPage = 1;
const productsGrid = document.getElementById('products-grid');
const loadMoreBtn = document.getElementById('load-more');

const genderFilter = document.getElementById('filter-gender');
const brandFilter = document.getElementById('filter-brand');
const sizeFilter = document.getElementById('filter-size');
const materialFilter = document.getElementById('filter-material');
const categoryFilter = document.getElementById('filter-category');
const colorFilter = document.getElementById('filter-color');
const discountFilter = document.getElementById('filter-discount');

async function fetchProducts(page = 1, reset = false) {
    const gender = document.getElementById('filter-gender').value;
    const brandId = document.getElementById('filter-brand').value;
    const sizeId = document.getElementById('filter-size').value;
    const materialId = document.getElementById('filter-material').value;
    const categoryId = document.getElementById('filter-category').value;
    const colorId = document.getElementById('filter-color').value;
    const discount = document.getElementById('filter-discount').value;

    const url = new URL(window.apiEndpoint);
    url.searchParams.append('page', page);

    // filter by gender
    if (gender) {
        url.searchParams.append('gender', gender);
    }

    // filter by brand
    if (brandId) {
        url.searchParams.append('brand_id', brandId);
    }

    // filter by size
    if (sizeId) {
        url.searchParams.append('size_id', sizeId);
    }

    // filter by material
    if (materialId) {
        url.searchParams.append('material_id', materialId);
    }

    // filter by category
    if (categoryId) {
        url.searchParams.append('category_id', categoryId);
    }

    // filter by color
    if (colorId) {
        url.searchParams.append('color_id', colorId);
    }

    // filter by discount
    if (discount) {
        url.searchParams.append('discount', discount);
    }

    console.log(url);
    const res = await fetch(url);
    const data = await res.json();

    if (reset) {
        productsGrid.innerHTML = '';
        currentPage = 1;
        filteredProducts = [];
    }

    filteredProducts = [...filteredProducts, ...data.data]; // Laravel paginate => data[]
    renderProducts(data.data);

    currentPage++;
    loadMoreBtn.style.display = data.next_page_url ? 'block' : 'none';
}

function renderProducts(products) {
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

function initProductsPage() {
    fetchProducts();

    loadMoreBtn.addEventListener('click', () => fetchProducts(currentPage));
}

document.addEventListener('DOMContentLoaded', initProductsPage);

genderFilter.addEventListener('change', () => {
    // Fetch products with the selected gender, reset the list
    fetchProducts(1, true);
});

brandFilter.addEventListener('change', () => {
    // Fetch products with the selected brand, reset the list
    fetchProducts(1, true);
});

sizeFilter.addEventListener('change', () => {
    // Fetch products with the selected size, reset the list
    fetchProducts(1, true);
});

materialFilter.addEventListener('change', () => {
    // Fetch products with the selected material, reset the list
    fetchProducts(1, true);
});

categoryFilter.addEventListener('change', () => {
    // Fetch products with the selected category, reset the list
    fetchProducts(1, true);
});

colorFilter.addEventListener('change', () => {
    // Fetch products with the selected color, reset the list
    fetchProducts(1, true);
});

discountFilter.addEventListener('change', () => {
    // Fetch products with the selected discount, reset the list
    fetchProducts(1, true);
});
