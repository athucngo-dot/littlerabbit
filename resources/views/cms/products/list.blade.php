@extends('cms.layouts.app')

@section('content')
<section class="px-6 py-8">
    <div class="max-w-7xl mx-auto">

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Products
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage and search all products
            </p>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
            <form method="GET" action="" class="flex items-center gap-4">
                <div class="flex-1">
                    <input
                        type="text"
                        name="slug"
                        value="{{ request('slug') }}"
                        placeholder="Search by product slug..."
                        class="w-full px-4 py-2 border rounded-lg
                               focus:outline-none focus:ring-aqua focus:border-aqua"
                    />
                </div>

                <button
                    type="submit"
                    class="bg-aqua hover:bg-aqua-2 text-white px-5 py-2 rounded-lg font-semibold"
                >
                    Search
                </button>
            </form>
        </div>

        <!-- Product List -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-200 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">ID</th>
                        <th class="px-6 py-3 text-left font-semibold">Name</th>
                        <th class="px-6 py-3 text-left font-semibold">Slug</th>
                        <th class="px-6 py-3 text-left font-semibold">Price</th>
                        <th class="px-6 py-3 text-left font-semibold">Stock</th>
                        <th class="px-6 py-3 text-left font-semibold">Brand</th>
                        <th class="px-6 py-3 text-left font-semibold">Category</th>
                        <th class="px-6 py-3 text-left font-semibold">Gender</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($products as $product)
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                            <td class="px-6 py-4 text-gray-700">
                                {{ $product->id }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $product->slug }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $product->price }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $product->stock }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $product->brand->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $product->category->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $product->gender }}
                            </td>                            

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('cms.products.edit', $product) }}"
                                   class="text-aqua hover:underline font-medium">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->withQueryString()->links() }}
        </div>

    </div>
</section>

@endsection