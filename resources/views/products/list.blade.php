@extends('layouts.app')

@section('content')

<section class="bg-gradient-to-b from-mint to-paper-2">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-ink mb-8 capitalize">
                @if(isset($listName) && $listName === 'age-gender')
                    {{ $ageGroup }} / {{$gender}}
                @else
                    Accessories
                @endif
            </h2>

            <div>
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6"></div>
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
    @if(isset($listName) && $listName === 'age-gender')
        window.apiEndpoint = "{{ route('api.products.byAgeAndGender', ['ageGroup' => $ageGroup, 'gender' => $gender]) }}";
    @else
        window.apiEndpoint = "{{ route('api.products.accessories') }}";
    @endif
</script>

<!-- Load external JS -->
@vite('resources/js/products_list.js')
@endsection