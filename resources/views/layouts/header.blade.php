 {{-- Header --}}
  <header class="sticky top-0 z-50 backdrop-blur-sm bg-white/75 border-b border-gray-200">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between p-4">
      <a href="{{ route('homepage') }}" class="flex items-center gap-2 text-inherit no-underline">
        <span class="w-9 h-9 bg-mint rounded-lg grid place-items-center shadow-md">
          <img src="{{ config('site.logo') }}" alt="Logo" class="w-6 h-6 object-contain">
        </span>
        <span class="font-poppins font-bold tracking-tight">Little Rabbit</span>
      </a>

      <nav class="hidden md:flex">
        <ul class="flex gap-5">
          <li><a href="{{ route('products.new-arrivals') }}" class="font-medium text-gray-900 hover:text-mint-600">New Arrivals</a></li>
          <li><a href="{{ route('products.deals') }}" class="font-medium text-gray-900 hover:text-mint-600">Deals</a></li>
          <li x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="font-medium text-gray-900 hover:text-mint-600">
                    Baby
                </button>
                <ul x-show="open" 
                    @click.away="open = false" 
                    class="absolute left-0 mt-2 w-40 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
                    <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'baby', 'gender' => 'boy']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Boys</a></li>
                    <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'baby', 'gender' => 'girl']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Girls</a></li>
                    <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'baby', 'gender' => 'unisex']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Unisex</a></li>
                </ul>
          </li>
          <li x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="font-medium text-gray-900 hover:text-mint-600">
                    Toddler
                </button>
                <ul x-show="open" 
                    @click.away="open = false" 
                    class="absolute left-0 mt-2 w-40 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
                    <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'toddler', 'gender' => 'boy']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Boys</a></li>
                    <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'toddler', 'gender' => 'girl']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Girls</a></li>
                    <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'toddler', 'gender' => 'unisex']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Unisex</a></li>
                </ul>
          </li>
          
          {{-- Kids with dropdown --}}
          <li x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="font-medium text-gray-900 hover:text-mint-600">
              Kids
            </button>
            <ul x-show="open" 
                @click.away="open = false" 
                class="absolute left-0 mt-2 w-40 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
              <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'kid', 'gender' => 'boy']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Boys</a></li>
              <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'kid', 'gender' => 'girl']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Girls</a></li>
              <li><a href="{{ route('products.byAgeAndGender', ['ageGroup' => 'kid', 'gender' => 'unisex']) }}" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-mint-600">Unisex</a></li>
            </ul>
          </li>

          {{-- Accessories with dropdown --}}
          <li><a href="{{ route('products.accessories') }}" class="font-medium text-gray-900 hover:text-mint-600">Accessories</a></li>
          
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
        @php
            $isLoggedIn = false;
            $customerLastname = '';
            $urlLink = '/auth';

            if(Auth::guard('customer')->check()){
                $isLoggedIn = true;
                $customerLastname = Auth::guard('customer')->user()->last_name;
                $urlLink = '/dashboard';
            }
        @endphp

        @if($isLoggedIn)
            <span class="capitalize">Hi {{ $customerLastname }}</span>
        @endif

            <a href="{{$urlLink}}" 
            class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="w-5 h-5 text-gray-700" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z" />      
                </svg>
            </a>

        {{-- Cart Icon --}}
        <div x-data="{ cartCount: {{ $cartCount ?? 0 }} }" @cart-updated.window="cartCount = $event.detail"  class="relative">
            <a href="/cart" 
                class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 3h2l.344 2M7 13h10l4-8H5.344M7 13L5.344 5M7 13l-1.5 6m13-6l1.5 6M6 19a1 1 0 100 2 1 1 0 000-2zm12 0a1 1 0 100 2 1 1 0 000-2z"/>
                </svg>
            </a>
            <template x-if="cartCount > 0">
                <span x-text="cartCount" 
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 grid place-items-center">
                </span>
            </template>
        </div>
      </div>
    </div>
  </header>