<!-- Header -->
  <header class="sticky top-0 z-50 backdrop-blur-sm bg-white/75 border-b border-gray-200">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between p-4">
      <a href="/" class="flex items-center gap-2 text-inherit no-underline">
        <span class="w-9 h-9 bg-[#dff3ea] rounded-lg grid place-items-center shadow-md">
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
          <li><a href="/new-arrivals" class="font-medium text-gray-900 hover:text-[#6fb69e]">New Arrivals</a></li>
          <li><a href="/deals" class="font-medium text-gray-900 hover:text-[#6fb69e]">Deals</a></li>
          <li><a href="/baby" class="font-medium text-gray-900 hover:text-[#6fb69e]">Baby</a></li>
          <li><a href="/toddler" class="font-medium text-gray-900 hover:text-[#6fb69e]">Toddler</a></li>
          
          <!-- Kids with dropdown -->
          <li x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="font-medium text-gray-900 hover:text-[#6fb69e]">
              Kids
            </button>
            <ul x-show="open" 
                @click.away="open = false" 
                class="absolute left-0 mt-2 w-40 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
              <li><a href="#boys" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-[#6fb69e]">Boys</a></li>
              <li><a href="#girls" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-[#6fb69e]">Girls</a></li>
              <li><a href="#shoes" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-[#6fb69e]">Shoes</a></li>
            </ul>
          </li>

          <!-- Accessories with dropdown -->
          <li x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="font-medium text-gray-900 hover:text-[#6fb69e]">
              Accessories
            </button>
            <ul x-show="open" 
                @click.away="open = false" 
                class="absolute left-0 mt-2 w-44 bg-white/75 shadow-lg rounded-md p-2 space-y-2">
              <li><a href="#hats" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-[#6fb69e]">Hats</a></li>
              <li><a href="#bags" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-[#6fb69e]">Bags</a></li>
              <li><a href="#toys" class="block px-3 py-1 font-medium text-gray-900 hover:bg-gray-100 hover:text-[#6fb69e]">Toys</a></li>
            </ul>
          </li>
          <li><a href="contact" class="font-medium text-gray-900 hover:text-[#6fb69e]">Brands</a></li>
        </ul>
      </nav>

      <div class="flex items-center gap-3">
        <button class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer">🔎</button>
        <button class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer">♡</button>
        <button class="w-10 h-10 grid place-items-center rounded-full border border-gray-200 bg-white cursor-pointer">🛒</button>
      </div>
    </div>
  </header>