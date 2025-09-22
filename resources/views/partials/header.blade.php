 {{-- Header --}}
  <header class="sticky top-0 z-50 backdrop-blur-sm bg-white/75 border-b border-gray-200">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between p-4">
      <a href="/" class="flex items-center gap-2 text-inherit no-underline">
        <span class="w-9 h-9 bg-mint rounded-lg grid place-items-center shadow-md">
          <svg viewBox="0 0 24 24" fill="none" stroke="#1f2937" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="7" r="3"/>
            <path d="M7 22c0-3 2-5 5-5s5 2 5 5"/>
            <path d="M5 10c-1.5 0-2.5-1.2-2.5-2.5S3.5 5 5 5c.9 0 1.7.5 2.1 1.2M19 10c1.5 0 2.5-1.2 2.5-2.5S20.5 5 19 5c-.9 0-1.7.5-2.1 1.2"/>
          </svg>
        </span>
        <span class="font-poppins font-bold tracking-tight">Little Rabbit</span>
      </a>

      <nav class="hidden md:flex">
        <ul class="flex gap-5">
          <li><a href="/new-arrivals" class="font-medium text-gray-900 hover:text-mint-600">New Arrivals</a></li>
          <li><a href="/deals" class="font-medium text-gray-900 hover:text-mint-600">Deals</a></li>
          <li><a href="/baby" class="font-medium text-gray-900 hover:text-mint-600">Baby</a></li>
          <li><a href="/toddler" class="font-medium text-gray-900 hover:text-mint-600">Toddler</a></li>
          
          {{-- Kids with dropdown --}}
          <li x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="font-medium text-gray-900 hover:text-mint-600">
              Kids
            </button>
            <ul x-show="open" 
                @click.away="open = false" 
                class="absolute left-0 mt-2 w-40 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
              <li><a href="#boys" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Boys</a></li>
              <li><a href="#girls" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Girls</a></li>
              <li><a href="#shoes" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Shoes</a></li>
            </ul>
          </li>

          {{-- Accessories with dropdown --}}
          <li x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="font-medium text-gray-900 hover:text-mint-600">
              Accessories
            </button>
            <ul x-show="open" 
                @click.away="open = false" 
                class="absolute left-0 mt-2 w-44 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
              <li><a href="#hats" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Hats</a></li>
              <li><a href="#bags" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Bags</a></li>
              <li><a href="#toys" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Toys</a></li>
            </ul>
          </li>
          <li><a href="contact" class="font-medium text-gray-900 hover:text-mint-600">Brands</a></li>
        </ul>
      </nav>

      <div class="flex items-center gap-3">
        {{-- Search Icon --}}
        <a href="/search" 
          class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
          </svg>
        </a>
        
        {{-- Account Login Icon --}}
        @if(Auth::guard('customer')->check())
            <span class="capitalize">Hi {{ Auth::guard('customer')->user()->last_name }}</span>
        @else
            <a href="/auth" 
            class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="w-5 h-5 text-gray-700" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z" />      
                </svg>
            </a>
        @endif

        {{-- Cart Icon --}}
        <a href="/cart" 
          class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 3h2l.344 2M7 13h10l4-8H5.344M7 13L5.344 5M7 13l-1.5 6m13-6l1.5 6M6 19a1 1 0 100 2 1 1 0 000-2zm12 0a1 1 0 100 2 1 1 0 000-2z"/>
          </svg>
        </a>
      </div>
    </div>
  </header>