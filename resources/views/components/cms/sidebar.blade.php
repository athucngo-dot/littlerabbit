<aside
    x-data="{
        open: localStorage.getItem('cmsSidebar') !== 'collapsed',
        toggle() {
            this.open = !this.open
            localStorage.setItem('cmsSidebar', this.open ? 'expanded' : 'collapsed')
        }
    }"
    :class="open ? 'w-64' : 'w-20'"
    class="bg-white shadow-xl flex flex-col transition-all duration-300 ease-in-out"
>

    <!-- Brand -->
    <div class="px-4 py-5 flex items-center gap-3 border-b">
        <span class="w-9 h-9 bg-mint rounded-lg grid place-items-center shadow-md shrink-0">
            <img src="{{ config('site.logo') }}" class="w-6 h-6 object-contain" />
        </span>

        <span
            x-show="open"
            x-transition
            class="text-lg font-semibold text-gray-800 whitespace-nowrap"
        >
            Little Rabbit CMS
        </span>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-6 space-y-2 text-sm font-medium">
        <x-cms.sidebar-link
            route="cms.products.*"
            href="{{ route('cms.products.list') }}"
            label="Products"
            :open="true"
        />

        <x-cms.sidebar-link
            route="cms.colors.*"
            href=""
            label="Colors"
        />

        <x-cms.sidebar-link
            route="cms.sizes.*"
            href=""
            label="Sizes"
        />

        <x-cms.sidebar-link
            route="cms.brands.*"
            href=""
            label="Brands"
        />
    </nav>

    <!-- Collapse Button -->
    <div class="border-t px-3 py-4">
        <button
            @click="toggle"
            class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg
                   text-gray-600 hover:bg-gray-100"
        >
            <svg class="w-5 h-5 transform transition-transform"
                 :class="open ? '' : 'rotate-180'"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>

            <span x-show="open" x-transition>Collapse</span>
        </button>
    </div>
</aside>
