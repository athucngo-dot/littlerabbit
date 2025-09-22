@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-ink mb-8">New Arrivals</h2>

            <div class="flex gap-6">
                <!-- Filters (Left 1/4) -->
                <div class="w-1/4 bg-white p-4 rounded-xl shadow-md space-y-6">
                    <h3 class="font-semibold text-lg mb-2">Filter Products</h3>

                    <!-- Gender -->
                    <div>
                        <label class="block font-medium mb-1">Gender</label>
                        <select id="filter-gender" class="w-full border rounded px-2 py-1">
                            <option value="">All</option>
                            <option value="boy">Boy</option>
                            <option value="girl">Girl</option>
                            <option value="neutral">Neutral</option>
                        </select>
                    </div>

                    <!-- Size -->
                    <div>
                        <label class="block font-medium mb-1">Size</label>
                        <select id="filter-size" class="w-full border rounded px-2 py-1">
                            <option value="">All</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label class="block font-medium mb-1">Brand</label>
                        <select id="filter-brand" class="w-full border rounded px-2 py-1">
                            <option value="">All</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block font-medium mb-1">Category</label>
                        <select id="filter-category" class="w-full border rounded px-2 py-1">
                            <option value="">All</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Color -->
                    <div>
                        <label class="block font-medium mb-1">Color</label>
                        <select id="filter-color" class="w-full border rounded px-2 py-1">
                            <option value="">All</option>
                            @foreach($colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Discount -->
                    <div>
                        <label class="block font-medium mb-1">Discount</label>
                        <select id="filter-discount" class="w-full border rounded px-2 py-1">
                            <option value="">All</option>
                            <option value="25">Up to 25% Off</option>
                            <option value="50">Up to 50% Off</option>
                        </select>
                    </div>
                </div>

                <!-- Products (Right 3/4) -->
                <div class="w-3/4">
                    <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"></div>

                    <div class="text-center mt-6">
                        <button id="load-more" class="bg-aqua hover:bg-aqua-2 px-6 py-2 text-white rounded">
                            More Products
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pass products JSON to JS -->
<script>
    window.apiEndpoint = "{{ url('/api/products/new-arrivals') }}";
</script>

<!-- Load external JS -->
@vite('resources/js/products.js')
@endsection
