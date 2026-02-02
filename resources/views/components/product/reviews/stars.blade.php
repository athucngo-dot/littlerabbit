@props([
    'rating' => null,
    'size' => 'md'
])

@php
    $sizeClass = $size === 'sm' ? 'w-4 h-4' : 'w-5 h-5';
@endphp

<div class="flex items-center justify-center space-x-1">
    <template x-for="i in 5" :key="i">
        <svg
            class="{{ $sizeClass }}"
            viewBox="0 0 20 20"
        >
            <defs>
                <linearGradient :id="'half-grad-' + i">
                    <stop offset="50%" stop-color="gold" />
                    <stop offset="50%" stop-color="lightgray" />
                </linearGradient>
            </defs>

            <path :fill="getStarFill(i, {{ $rating ?? 'averageRate' }})"
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.285-3.955a1 1 0 00-.364-1.118L2.063 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.951-.69l1.285-3.955z"
            />
        </svg>
    </template>
</div>
