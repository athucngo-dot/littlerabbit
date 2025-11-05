@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2">
    @include('products.partials.filter-section', ['title' => 'New Arrivals'])
</section>

<!-- Pass products JSON to JS -->
<script>
    window.apiEndpoint = "{{ route('api.products.new-arrivals') }}";
</script>

<!-- Load external JS -->
@vite('resources/js/products_list_with_filters.js')
@endsection
