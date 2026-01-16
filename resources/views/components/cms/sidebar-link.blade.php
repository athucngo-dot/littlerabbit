@props(['href', 'label', 'route'])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-4 py-2 text-lg font-semibold  rounded-lg transition-colors
          {{ request()->routeIs($route)
                ? 'bg-aqua text-white'
                : 'text-gray-600 hover:bg-gray-100' }}"
>
    <!-- Icon placeholder -->
    <span class="w-5 h-5 bg-gray-300 rounded shrink-0"></span>

    <span
        x-show="open"
        x-transition
        class="whitespace-nowrap"
    >
        {{ $label }}
    </span>
</a>
