@extends('layouts.app')

@section('content')
  <!-- Hero -->
  <section class="bg-gradient-to-b from-mint to-paper-2" id="home">
    <div class="max-w-[1200px] mx-auto grid md:grid-cols-[1.1fr_0.9fr] gap-7 py-14 md:items-center bg-right bg-no-repeat" style="background-image: url('images/banner_3_children_homepage.webp');">
      <div class="md:pl-10">
        <div class="text-mint-600 uppercase tracking-widest text-xs font-bold mb-2">New • Cozy • Cute</div>
        <h1 class="font-poppins font-bold text-[clamp(28px,5vw,48px)] leading-tight mb-4">Soft, Stylish, and Made with Love</h1>
        <p class="text-gray-500 mb-4 md:mb-6 max-w-[36ch]">Comfort-first clothing for babies and toddlers. Thoughtful materials and playful colors parents adore.</p>
        <div class="flex flex-wrap gap-2">
          <a href="/baby-toddler-kids-clothings" class="inline-flex items-center justify-center px-4 py-2 rounded-full font-bold shadow-md bg-mint-600 text-white hover:bg-mint transition">Shop Now</a>
          <a href="#categories" class="inline-flex items-center justify-center px-4 py-2 rounded-full font-bold shadow-md border border-gray-300 text-gray-900 bg-transparent hover:border-mint-600 hover:text-mint-600 transition">Browse Categories</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Categories -->
  <section class="py-12" id="categories">
    <div class="max-w-[1200px] mx-auto">
      <h2 class="font-poppins text-[clamp(22px,3.6vw,32px)] text-center mb-6">Featured Items</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($featureProducts as $product)
            <a href="/products/{{$product->slug}}" class="block bg-white rounded-xl shadow-md overflow-hidden text-center">
                <div class="aspect-[3/4] flex items-center justify-center bg-butter">
                <img src="{{$product->image}}" alt="Baby onesie" class="h-full w-full object-cover">
                </div>
                <div class="py-3 font-bold">
                    <p>{{$product->name}}</p>
                    <p class="text-ink-60 mt-1">${{number_format($product->price, 2)}}</p>
                </div>
            </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Best Sellers -->
  <section class="py-12" id="products">
    <div class="max-w-[1200px] mx-auto">
      <h2 class="font-poppins text-[clamp(22px,3.6vw,32px)] text-center mb-6">Best Sellers</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Product 1 -->
        <article class="bg-white rounded-xl shadow-md flex flex-col overflow-hidden">
          <div class="aspect-square flex items-center justify-center bg-paper-2">
            <img src="https://placehold.co/600x600/FFF8E8/1A1A1A?text=Organic+Tee" alt="Beige organic cotton t‑shirt" class="object-cover w-full h-full">
          </div>
          <div class="p-3 grid gap-2">
            <h3 class="m-0">Organic Tee</h3>
            <div class="font-bold">$15.00</div>
            <button class="px-4 py-2 rounded-full font-bold shadow-md bg-mint-600 text-white hover:bg-mint transition">Add to Cart</button>
          </div>
        </article>
        <!-- Product 2 -->
        <article class="bg-white rounded-xl shadow-md flex flex-col overflow-hidden">
          <div class="aspect-square flex items-center justify-center bg-paper-2">
            <img src="https://placehold.co/600x600/FFF0C6/1A1A1A?text=Sunshine+Dress" alt="Yellow toddler dress" class="object-cover w-full h-full">
          </div>
          <div class="p-3 grid gap-2">
            <h3 class="m-0">Sunshine Dress</h3>
            <div class="font-bold">$20.00</div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellowish border border-yellowish-2 font-bold">Quick View</div>
          </div>
        </article>
        <!-- Product 3 -->
        <article class="bg-white rounded-xl shadow-md flex flex-col overflow-hidden">
          <div class="aspect-square flex items-center justify-center bg-paper-2">
            <img src="https://placehold.co/600x600/D7E9FB/1A1A1A?text=Soft+Pants" alt="Blue soft pants" class="object-cover w-full h-full">
          </div>
          <div class="p-3 grid gap-2">
            <h3 class="m-0">Soft Pants</h3>
            <div class="font-bold">$15.00</div>
            <button class="px-4 py-2 rounded-full font-bold shadow-md bg-mint-600 text-white hover:bg-mint transition">Add to Cart</button>
          </div>
        </article>
        <!-- Product 4 -->
        <article class="bg-white rounded-xl shadow-md flex flex-col overflow-hidden">
          <div class="aspect-square flex items-center justify-center bg-paper-2">
            <img src="https://placehold.co/600x600/F6D1C7/1A1A1A?text=Knit+Cardigan" alt="Peach knit cardigan" class="object-cover w-full h-full">
          </div>
          <div class="p-3 grid gap-2">
            <h3 class="m-0">Knit Cardigan</h3>
            <div class="font-bold">$25.00</div>
            <button class="px-4 py-2 rounded-full font-bold shadow-md bg-mint-600 text-white hover:bg-mint transition">Add to Cart</button>
          </div>
        </article>
      </div>

      <!-- Promo -->
      <div class="py-7">
        <div class="bg-butter shadow-md rounded-xl text-center font-extrabold tracking-wide py-4">More Sales — Up to 75% Off!</div>
      </div>
    </div>
  </section>

  <!-- Testimonials & Newsletter -->
  <section class="py-12">
    <div class="max-w-[1200px] mx-auto grid md:grid-cols-[1.1fr_0.9fr] gap-6">
      <!-- Testimonial -->
      <div class="bg-white p-4 rounded-xl shadow-md grid gap-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full overflow-hidden">
            <img src="https://placehold.co/96x96/E5E7EB/1A1A1A?text=%F0%9F%91%A9" alt="Parent avatar" class="w-full h-full object-cover">
          </div>
          <div>
            <strong>Amelia R.</strong><br>
            <small class="text-gray-500">Toronto, ON</small>
          </div>
        </div>
        <p>“The clothes are adorable and the quality is outstanding. My daughter loves the soft fabrics!”</p>
      </div>

      <!-- Newsletter -->
      <aside class="bg-white p-4 rounded-xl shadow-md grid gap-3">
        <h3 class="m-0">Join for exclusive discounts & new arrivals</h3>
        <form class="grid grid-cols-[1fr_auto] gap-2" onsubmit="event.preventDefault(); newsletterThanks();">
          <label for="email" class="sr-only">Email</label>
          <input type="email" id="email" name="email" placeholder="you@example.com" required class="border border-gray-300 rounded-full px-4 py-2">
          <button type="submit" class="px-4 py-2 rounded-full font-bold shadow-md bg-mint-600 text-white hover:bg-mint transition">Subscribe</button>
        </form>
        <small class="text-gray-500">We respect your privacy. Unsubscribe anytime.</small>
      </aside>
    </div>
  </section>

@endsection
