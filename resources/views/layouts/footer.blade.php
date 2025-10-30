<!-- Footer -->
  <footer class="bg-gray-900 text-gray-200 py-5 mt-6">
    <div class="max-w-[1200px] mx-auto grid lg:grid-cols-4 gap-7 text-sm py-9">
        <div>            
            <div class="flex items-center gap-2 mb-3">
            <span class="w-9 h-9 bg-gray-800 grid place-items-center">
                <img src="{{ config('site.logo_footer') }}" alt="Logo" class="w-6 h-6 object-contain">
            </span>
            <strong>Little Rabbit</strong>
            </div>
            <p class="opacity-80 max-w-[36ch] mb-2">Soft, stylish clothing for little ones. Ethically sourced, parent‑approved.</p>
            <div class="flex flex-wrap gap-2 mt-2">
            <span class="px-2 py-1 rounded bg-gray-800 border border-gray-700 text-xs">Visa</span>
            <span class="px-2 py-1 rounded bg-gray-800 border border-gray-700 text-xs">Mastercard</span>
            </div>
        </div>
        <div>
            <h4 class="font-bold mb-2">Help</h4>
            <ul class="grid gap-2">
            <li><a href="/shipping-return" class="hover:underline">Shipping & Returns</a></li>
            <li><a href="/size-guide" class="hover:underline">Size Guide</a></li>
            <li><a href="/faq" class="hover:underline">FAQs</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-2">Company</h4>
            <ul class="grid gap-2">
            <li><a href="/about" class="hover:underline">About Us</a></li>
            <li><a href="/contact" class="hover:underline">Contact</a></li>
            </ul>
        </div>
        <div>
            {{-- Logout will be in the account dashboard. For now, leave it at footer for easy access. --}}
            @if(Auth::guard('customer')->check())
            <a href="/auth/logout" class="hover:underline">Logout</a>
            @endif
        </div>
    </div>

    <div class="bg-gray-800 border border-gray-700 text-gray-300 text-sm p-4 mt-4 rounded-lg flex items-start gap-2">
        <span class="text-yellow-400 text-lg">⚠️</span>
        <p>
            <strong class="text-gray-100">Please Note:</strong> This is not a real e-commerce website. It has been
            created for personal portfolio and learning purposes only. No actual sales or shipping will occur.
            Some content is sourced from other websites for demonstration purposes.
        </p>
    </div>
  </footer>