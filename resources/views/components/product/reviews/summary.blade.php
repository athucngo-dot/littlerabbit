<div class="w-full lg:w-1/4 bg-white p-4 rounded shadow space-y-4">
    {{-- Average Rating --}}
    <div class="text-center">
        <x-product.reviews.stars />

        <div class="text-lg font-bold"
             x-text="averageRate.toFixed(1) + ' out of 5'"></div>

        <div class="text-gray-600 text-sm"
             x-text="reviews.length + ' ratings'"></div>
    </div>

    {{-- Rating Breakdown --}}
    <div class="space-y-1">
        <template x-for="rate in [5,4,3,2,1]" :key="rate">
            <div class="flex items-center space-x-2">
                <span class="text-sm w-4" x-text="rate"></span>

                <div class="flex-1 h-3 bg-gray-200 rounded overflow-hidden">
                    <div
                        class="h-full"
                        :class="reviews.length ? 'bg-yellow-400' : 'bg-gray-300'"
                        :style="`width: ${(reviews.filter(r => r.rv_rate == rate).length / reviews.length) * 100}%`">
                    </div>
                </div>

                <span class="text-sm w-6 text-right"
                      x-text="reviews.filter(r => r.rv_rate == rate).length"></span>
            </div>
        </template>
    </div>
</div>
