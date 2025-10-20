import { renderProducts } from './components/products_render.js';

let filteredProducts = [];
let currentPage = 1;
const productsGrid = document.getElementById('products-grid');
const loadMoreBtn = document.getElementById('load-more');

const filterIds = [
    'gender', 'brand', 'size', 'material', 'category', 'color', 'discount'
];

function getFilters() {
    const filters = {};
    filterIds.forEach(id => {
        const el = document.getElementById(`filter-${id}`);
        if (el && el.value) {
            filters[id] = el.value;
        }
    });

    return filters;
}

async function fetchProducts(page = 1, reset = false) {

    const filters = getFilters();

    const url = new URL(window.apiEndpoint);
    url.searchParams.append('page', page);

    // Append filters
    Object.entries(filters).forEach(([key, value]) => {
        url.searchParams.append(key, value);
    });

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

function initProductsPage() {
    fetchProducts();

    loadMoreBtn.addEventListener('click', () => fetchProducts(currentPage));

    // Attach event listeners for all filters
    filterIds.forEach(id => {
        const el = document.getElementById(`filter-${id}`);
        if (el) {
            el.addEventListener('change', () => fetchProducts(1, true));
        }
    });
}

document.addEventListener('DOMContentLoaded', initProductsPage);

