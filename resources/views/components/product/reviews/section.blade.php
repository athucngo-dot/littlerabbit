@props(['productSlug'])

<div
    x-data="reviewsManager(@js($productSlug))"
    x-init="init()"
    class="space-y-6"
>
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">Customer Reviews</h2>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <x-product.reviews.summary />
        <x-product.reviews.list />
    </div>
</div>
