export default function carousel(items = []) {
    return {
        items: items,
        start: 0,
        perPage: 5,

        get visibleItems() {
            return this.items.slice(this.start, this.start + this.perPage);
        },

        next() {
            if (this.start + this.perPage < this.items.length) {
                this.start++;
            }
        },

        prev() {
            if (this.start > 0) {
                this.start--;
            }
        }
    }
}