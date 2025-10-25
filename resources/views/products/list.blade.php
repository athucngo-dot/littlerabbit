@extends('layouts.app')

@section('content')

@php
    switch ($listName ?? null) {
        case 'age-gender':
            $endpoint = route('api.products.byAgeAndGender', ['ageGroup' => $ageGroup, 'gender' => $gender]);
            $title = $ageGroup . '/' . $gender;
            break;

        case 'accessories':
            $endpoint = route('api.products.accessories');
            $title = 'Accessories';
            break;

        case 'category':
            $endpoint = route('api.products.byCategory', ['categorySlug' => $categorySlug]);
            $title = 'Categories / ' . $categoryName;
            break;

        default:
            $endpoint = route('api.products.allItems');
            $title = 'Shop All';
            break;
    }
@endphp

<section class="bg-gradient-to-b from-mint to-paper-2">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-ink mb-8 capitalize">{{$title}}</h2>

            <div>
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-6"></div>
                <div class="text-center mt-6">
                    <button id="load-more" class="bg-aqua hover:bg-aqua-2 px-6 py-2 text-white rounded">
                    More Products
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    window.apiEndpoint = @json($endpoint);
</script>

<!-- Load external JS -->
@vite('resources/js/products_list.js')
@endsection