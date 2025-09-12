// resources/js/products.js
let filteredProducts = [];
let currentPage = 1;
const productsGrid = document.getElementById('products-grid');
const loadMoreBtn = document.getElementById('load-more');

async function fetchProducts(page = 1, reset = false) {
    const res = await fetch(`${window.apiEndpoint}?page=${page}`);
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
        card.href = `/products/${product.slug}`;
        card.className = "block bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition-transform transform hover:scale-105";
        card.innerHTML = `
            <div class="aspect-[4/3] flex items-center justify-center bg-[#ffe7a3]">
                <img src="${product.image}" alt="${product.name}" class="h-full w-full object-cover">
            </div>
            <div class="p-4 text-center">
                <h3 class="font-semibold text-lg text-[#1a1a1a]">${product.name}</h3>
                <p class="text-[#666] mt-1">$${parseFloat(product.price).toFixed(2)}</p>
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
