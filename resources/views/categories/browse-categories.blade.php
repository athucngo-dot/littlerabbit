@extends('layouts.app')

@section('content')

<section class="bg-gradient-to-b from-mint to-paper-2">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-ink mb-8 capitalize">Category List</h2>
            <div>
                <div class="grid grid-rows-5 md:grid-rows-8 [grid-auto-flow:column] gap-6">
                    @foreach ($categoryList as $category)
                    <a href="{{route('products.byCategory', ['categorySlug' => $category->slug])}}" class="hover:bg-gray-100 hover:text-mint-600">
                         {{$category->name}}
                    </a>                   
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection