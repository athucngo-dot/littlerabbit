export default function imageCarousel(urls = []) {
    return {
        images: urls.length ? urls : ['https://placehold.co/600x600?text=No+Image'],
        current: 0,
        zoom: false,
        startX: 0,
        endX: 0,

        get currentImage() {
            return this.images[this.current];
        },

        prev() {
            this.current = (this.current === 0) ? this.images.length - 1 : this.current - 1;
        },

        next() {
            this.current = (this.current === this.images.length - 1) ? 0 : this.current + 1;
        },

        touchStart(e) {
            this.startX = e.touches[0].clientX;
        },

        touchEnd(e) {
            this.endX = e.changedTouches[0].clientX;
            const diff = this.startX - this.endX;
            if (diff > 50) this.next();
            if (diff < -50) this.prev();
        },

        keydown(e) {
            if (e.key === 'ArrowLeft') this.prev();
            if (e.key === 'ArrowRight') this.next();
            if (e.key === 'Escape') this.zoom = false;
        }
    }
}