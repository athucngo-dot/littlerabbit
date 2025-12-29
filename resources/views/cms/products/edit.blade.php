@extends('cms.layouts.app')

@section('title', 'Edit Product')

@section('content')
<section class="px-6 py-8">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- TOP BAR -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
                <p class="text-sm text-gray-500">
                    Update product details
                </p>
            </div>

            <!-- Search -->
            <div class="flex items-center gap-3">

                <!-- Search -->
                <form method="GET" action="{{ route('cms.products.search') }}">
                    <input
                        type="text"
                        name="slug"
                        value="{{ request('slug') }}"
                        placeholder="Search by product slug..."
                        class="px-4 py-2 border rounded-lg focus:ring-aqua focus:border-aqua"
                    />
                </form>
            </div>
        </div>

        <!-- Product Form -->
        <form method="POST"
              @if($allowEdit) action="{{ route('cms.products.update', $product) }}" @endif
              enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-md p-6 space-y-6">

            @csrf
            @method('PUT')

            @if(!$allowEdit)
                <p class="bg-yellow-50 border border-yellow-200 rounded-lg mt-7 p-5 text-sm text-yellow-700">
                    You can view the product's details, but you cannot edit it.
                </p>
            @endif

            <!-- BASIC INFO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-cms.input label="Name" name="name" :value="$product->name" required />
                <x-cms.input label="Slug" name="slug" :value="$product->slug" message="⚠️ Changing the slug may break existing links." required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-cms.input label="Price" name="price" :value="$product->price" />
                <x-cms.input label="Stock" name="stock" type="number" :value="$product->stock" />
                <x-cms.input label="Items per product" name="nb_of_items" type="number" :value="$product->nb_of_items" />
            </div>

            <!-- DESCRIPTION -->
            <div>
                <label class="block font-bold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border rounded-lg p-3">{{ $product->description }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Features</label>
                <textarea name="features" rows="5"
                    class="w-full border rounded-lg p-3">{{ old('features', is_array($product->features) ? implode("\n", $product->features) : '') }}
                </textarea>

            </div>

            <!-- SELECTS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <x-cms.select label="Gender" name="gender" :options="$genders" :selected="$product->gender" />

                <x-cms.select label="Brand" name="brand_id" :options="$brands" :selected="$product->brand_id" />

                <x-cms.select label="Category" name="category_id" :options="$categories" :selected="$product->category_id" />

                <x-cms.select label="Material" name="material_id" :options="$materials" :selected="$product->material_id" />

            </div>

            <!-- MULTI SELECTS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Colors -->
                <div>
                    <label class="font-bold text-gray-700">Colors</label>
                    <select name="colors[]" multiple class="w-full border rounded-lg p-2 h-40">
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}"
                                @selected($product->colors->contains($color->id))>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('colors[]')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sizes -->
                <div>
                    <label class="font-bold text-gray-700">Sizes</label>
                    <select name="sizes[]" multiple class="w-full border rounded-lg p-2 h-40">
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}"
                                @selected($product->sizes->contains($size->id))>
                                {{ $size->size }} ({{ $size->child_cat }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('sizes[]')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Deals -->
                <div class="mb-3">
                    <label class="font-bold text-gray-700">Deals</label>
                    <select name="deals[]" multiple class="w-full border rounded-lg p-2 h-40">
                        @foreach($deals as $deal)
                            <option value="{{ $deal->id }}"
                                @selected($product->deals->contains($deal->id))>
                                {{ $deal->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('deals[]')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror                
            </div>
            
            <label class="font-medium">
                *<span class="font-bold underline">Note</span>: For Colors, Sizes and Deals, hold Ctrl / Cmd to select multiple
            </label>

            <!-- FLAGS -->
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked($product->is_active)>
                    Active
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="new_arrival" value="1" @checked($product->new_arrival)>
                    New Arrival
                </label>
            </div>

            <!-- IMAGES -->
            <div>
                <label class="block font-bold text-gray-700 mb-2">Product Images</label>

                <input type="file" name="images[]" multiple accept="image/*" class="mb-4">

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <div class="relative border rounded-lg p-2">

                            <div class="aspect-[3/4] w-full overflow-hidden rounded-lg mb-2">
                                <img
                                    src="{{ asset($image->getImgUrl()) }}"
                                    class="rounded-lg mb-2 w-full h-full object-cover"
                                >
                            </div>

                            <!-- PRIMARY IMAGE -->
                            <label class="flex items-center gap-2 text-sm mb-1">
                                <input
                                    type="radio"
                                    name="primary_image"
                                    value="{{ $image->id }}"
                                    {{ $image->is_primary ? 'checked' : '' }}
                                >
                                Primary image
                            </label>

                            <!-- REMOVE IMAGE -->
                            <label class="flex items-center gap-2 text-sm text-red-600">
                                <input
                                    type="checkbox"
                                    name="remove_images[]"
                                    value="{{ $image->id }}"
                                >
                                Remove
                            </label>

                        </div>
                    @endforeach
                </div>
            </div>
            
            @if($allowEdit)
                <!-- SAVE -->
                <div class="pt-6 border-t">
                    <button
                        type="submit"
                        class="bg-aqua text-white px-6 py-3 rounded-lg font-semibold hover:bg-aqua-2">
                        Save Changes
                    </button>
                </div>
            @endif

        </form>
    </div>
</section>
@endsection
