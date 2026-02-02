@props(['images'])

<div
    x-data="imageCarousel(@js($images))"
    tabindex="0"
    @keydown.window="keydown($event)"
    class="relative space-y-4"
>
    {{-- Main Image --}}
    <div class="relative">
        <img
            :src="currentImage"
            alt="Product Image"
            class="w-full h-auto rounded-2xl shadow-md"
            @touchstart="touchStart($event)"
            @touchend="touchEnd($event)"
        >

        <button @click="prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow">
            <
        </button>

        <button @click="next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow">
            >
        </button>

        <button @click="zoom = true"
            class="absolute top-2 right-2 bg-white p-2 rounded-full shadow"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="w-5 h-5 text-gray-700"
            >
                <circle cx="11" cy="11" r="7" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </button>
    </div>

    {{-- Thumbnails --}}
    <div class="flex space-x-2 justify-center">
        <template x-for="(img, index) in images" :key="index">
            <img
                :src="img"
                @click="current = index"
                class="w-16 h-16 object-cover rounded-md border cursor-pointer"
                :class="{ 'border-blue-500': current === index }"
            >
        </template>
    </div>

    {{-- Zoom Modal --}}
    <div
        x-show="zoom"
        class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
        @click.self="zoom = false"
    >
        <img :src="currentImage" class="max-w-3xl max-h-[90vh] rounded-xl shadow-lg">
        <button @click="zoom = false" class="absolute top-4 right-4 text-white text-3xl">✕</button>
    </div>
</div>
