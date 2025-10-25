import { renderProducts } from './components/products_render.js';

let filteredProducts = [];
let currentPage = 1;
const productsGrid = document.getElementById('products-grid');
const loadMoreBtn = document.getElementById('load-more');

async function fetchProducts(page = 1, reset = false) {
    const url = new URL(window.apiEndpoint);
    url.searchParams.append('page', page);

    console.log(url);
    const res = await fetch(url);
    const data = await res.json();

    if (!res.ok) {
        // handle errors
        alert(data.message);
        return;
    }

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

function initProductsPage() {
    fetchProducts();

    loadMoreBtn.addEventListener('click', () => fetchProducts(currentPage));
}

document.addEventListener('DOMContentLoaded', initProductsPage);

