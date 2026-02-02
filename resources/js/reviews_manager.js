export default function reviewsManager(productSlug = '') {
    return {
        reviews: [],
        displayedReviews: [],
        moreReviews: [],

        init() {
            // Fetch reviews from API
            fetch(`/api/products/${productSlug}/reviews`)
                .then(res => {
                    if (!res.ok) {
                        // Handle error
                        throw new Error('Failed to fetch reviews.');
                    }
                    return res.json();
                })
                .then(data => {
                    // Populate reviews when data is received
                    this.reviews = data.map(r => ({
                        id: r.id,
                        rv_rate: r.rv_rate,
                        rv_comment: r.rv_comment,
                        customer_name: r.customer_name || 'Anonymous'
                    }));
                    this.displayedReviews = this.reviews.slice(0, 5);
                    this.moreReviews = this.reviews.slice(5);
                })
                .catch(err => console.error(err));
        },

        // Load more reviews
        loadMore() {
            // Take the next 5 reviews from moreReviews
            const nextFiveReviews = this.moreReviews.splice(0, 5);

            // Loop through each of them and push to displayedReviews
            nextFiveReviews.forEach((review) => {
                this.displayedReviews.push(review);
            });
        },

        // Calculate average rating
        get averageRate() {
            if (this.reviews.length === 0) return 0;
            return this.reviews.reduce((sum, r) => sum + Number(r.rv_rate), 0) / this.reviews.length;
        },

        // Determine star fill based on rating
        getStarFill(i, rating) {
            if (i <= Math.floor(rating)) return 'gold';
            if (i === Math.ceil(rating) && rating % 1 !== 0)
                return `url(#half-grad-${i})`;
            return 'lightgray';
        },
    }
}