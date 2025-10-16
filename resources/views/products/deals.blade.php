@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-mint to-paper-2">
    @include('products.partials.filter-section', ['title' => 'Shopping Deals'])
</section>

<!-- Pass products JSON to JS -->
<script>
    const params = new URLSearchParams(window.location.search);

    window.apiEndpoint = "{{ url('/api/products/deals') }}" + (params.toString() ? '?' + params.toString() : '');
</script>

<!-- Load external JS -->
@vite('resources/js/products_lists.js')
@endsection
