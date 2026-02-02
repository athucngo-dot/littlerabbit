<div class="w-full lg:w-3/4 space-y-4">
    <template x-for="review in displayedReviews" :key="review.id">
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center mb-1">
                <span class="font-semibold"
                      x-text="review.customer_name"></span>

                <x-product.reviews.stars
                    size="sm"
                    rating="review.rv_rate"
                />

            </div>

            <p class="text-gray-700" x-text="review.rv_comment"></p>
        </div>
    </template>

    <button
        x-show="moreReviews.length > 0"
        @click="loadMore()"
        class="bg-aqua hover:bg-aqua-2 text-white px-4 py-2 rounded-lg"
    >
        Load More Reviews
    </button>
</div>
