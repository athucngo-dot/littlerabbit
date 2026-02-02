@props([
    'products' => [],
])

<div x-data="carousel(@js($products))" class="relative">

    {{-- Left Arrow --}}
    <button @click="prev"
            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">
        &lt;
    </button>

    {{-- Items --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 overflow-hidden">
        <template x-for="item in visibleItems" :key="item.id">
            <a :href="`{{ route('products.show', ':slug') }}`.replace(':slug', item.slug)"
               class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                <div class="aspect-[3/4] w-full overflow-hidden">    
                    <img :src="item.url" :alt="item.name" class="w-full h-full object-cover">
                </div>

                <div class="p-4 text-center">
                    <h3 class="font-semibold text-lg" x-text="item.name"></h3>
                    <p class="text-gray-600">$<span x-text="Number(item.price).toFixed(2)"></span></p>
                </div>
            </a>
        </template>
    </div>

    {{-- Right Arrow --}}
    <button @click="next"
            class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">
        &gt;
    </button>
</div>
