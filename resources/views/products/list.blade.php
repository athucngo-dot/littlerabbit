@extends('layouts.app')

@section('content')

@php
    $message = '';
    $loadList = true;
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

        case 'deal':
            $endpoint = route('api.products.byDeal', ['dealSlug' => $dealSlug]);
            $title = $dealName;
            break;

        case 'search':
            $endpoint = route('api.products.search') . '?' . http_build_query($searchParams);
            $title = 'Search Results';

            $message = $emptyQuery ? 'Please enter a search term.' : '';
            $loadList = !$emptyQuery;

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
                @if($message)
                    <p class="text-center text-gray-500 mb-6">{{ $message }}</p>
                @endif

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

@if($loadList)
    <script>
        window.apiEndpoint = @json($endpoint);
    </script>

    <!-- Load external JS -->
    @vite('resources/js/products_list.js')
@endif

@endsection