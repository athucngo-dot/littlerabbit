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
          <a href="{{ route('products.all-items') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-full font-bold shadow-md bg-mint-600 text-white hover:bg-mint transition">Shop Now</a>
          <a href="{{ route('categories.browse-categories') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-full font-bold shadow-md border border-gray-300 text-gray-900 bg-transparent hover:border-mint-600 hover:text-mint-600 transition">Browse Categories</a>
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
            <a href="{{ route('products.show', $product->slug) }}" class="block bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition-transform hover:scale-105 text-center">
                <div class="aspect-[3/4] flex items-center justify-center bg-butter">
                <img src="{{$product->thumbnail()}}" alt="{{$product->name}}" class="h-full w-full object-cover">
                </div>
                <div class="py-3 font-bold">
                    <p>{{$product->name}}</p>
                    @if($product->price_after_deals != $product->price)
                        <p class="text-ink-60 mt-1">
                            <span class="font-bold px-2">${{ number_format($product->price_after_deals, 2) }}</span>
                            (<span class="text-red-500">-{{ number_format($product->deals[0]->percentage_off) }}%</span>)
                        </p>
                        <p class="text-ink-60 mt-1">
                            <span class="text-sm">Was: </span>
                            <span class="line-through text-sm">${{ number_format($product->price, 2) }}</span>
                        </p>
                    @else
                        <p class="text-ink-60 mt-1">${{number_format($product->price, 2)}}</p>
                    @endif
                </div>
            </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Promo Discounts -->
  <section class="py-12" id="products">
    <div class="max-w-[1200px] mx-auto">
      <h2 class="font-poppins text-[clamp(22px,3.6vw,32px)] text-center mb-6">Checkout Our Discounts</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        @foreach ($deals as $deal)
            <article class="bg-white rounded-xl shadow-md flex flex-col overflow-hidden">
                <div class="relative aspect-square bg-paper-2">
                    <!-- Discount badge -->
                    <div class="absolute top-2 left-2 bg-red-500 text-white text-xl font-bold px-3 py-1 rounded-lg shadow">
                        -{{number_format($deal->percentage_off)}}%
                    </div>

                    <!-- Image -->
                    <img src="/{{$deal->img_url}}"
                        alt="{{$deal->name}}"
                        class="object-cover w-full h-full">
                </div>
                <div class="p-3 grid gap-2">
                    <h3 class="m-0">{{$deal->name}}</h3>
                    <a href="{{ route('products.byDeal', $deal->slug) }}" class="inline-flex items-center justify-center text-center h-10 px-4 rounded-full bg-yellowish hover:bg-yellowish-2 border border-yellowish-2 font-bold">Quick View</a>
                </div>
            </article>
        @endforeach
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
        <!-- Testimonial 1 -->
        <div class="bg-white p-4 rounded-xl shadow-md grid gap-3">
                <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden">
                    <img src="https://placehold.co/96x96/E5E7EB/1A1A1A?text=AR" alt="Parent avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <strong>Amelia R.</strong><br>
                    <small class="text-gray-500">Toronto, ON</small>
                </div>
                </div>
                <p>“The clothes are adorable and the quality is outstanding. My daughter loves the soft fabrics!”</p>
        </div>

        <!-- Testimonial 2 -->
        <div class="bg-white p-4 rounded-xl shadow-md grid gap-3">
            <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full overflow-hidden">
                <img src="https://placehold.co/96x96/E5E7EB/1A1A1A?text=SM" alt="Parent avatar" class="w-full h-full object-cover">
            </div>
            <div>
                <strong>Sarah M., happy mom</strong><br>
                <small class="text-gray-500">Montreal, QC</small>
            </div>
            </div>
            <p>“I absolutely love shopping here for my little one! I appreciate that the fabrics are gentle on sensitive skin, and the designs are so fun and unique. Every outfit we’ve bought has gotten compliments everywhere we go. Highly recommend!”</p>
        </div>
    </div>
  </section>

@endsection
