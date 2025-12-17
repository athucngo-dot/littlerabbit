<h1 class="text-2xl font-bold mb-4">Your Orders</h1>

@if($orders->isEmpty())
    <div class="mb-4 p-4 border rounded-xl bg-white">
        <p class="text-gray-500 text-lg mb-6">You have no orders yet.</p>
        <a href="{{ route('products.all-items') }}"
            class="px-6 py-3 bg-aqua hover:bg-aqua-2 text-white font-semibold rounded-xl">
            Continue Shopping
        </a>
    </div>
@else
    <!-- Order Show -->
    @foreach($orders as $order)
        <div class="mb-4 p-4 border border-gray-500 rounded-xl bg-white">
            <div class="border-b pb-1 flex justify-between items-center">
            
                <!-- Order Info -->
                <div class="py-4">
                    <p class="text-gray-800 font-semibold text-lg">Order #{{ $order->order_number }}</p>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                    <p class="text-gray-600">Total: ${{ number_format($order->total, 2) }}</p>
                    <p class="text-gray-600">Status: <span class="capitalize">{{ $order->status }}</span></p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-3">Items:</h3>
                <div>
                    @foreach($order->products as $item)
                        <div class="flex p-4 border-b last:border-0">  
                            <img src="{{ $item->thumbnail() }}" alt="{{ $item->name }}" 
                                    class="w-28 h-28 object-cover rounded-lg">

                            <div class="px-4 mt-2 mb-4 text-gray-700">
                                <p>
                                    <a href="{{ route('products.show', $item->slug) }}"
                                        class="font-semibold text-base text-gray-700 hover:text-mint-600">
                                        <h3>{{ $item->name }}</h3>
                                    </a>
                                </p> 
                                <p>
                                    <span class="inline-block w-6 h-6 rounded-full border align-middle"
                                        style="background-color: {{ $item->pivot->color?->hex ?? '#000' }}">
                                    </span>
                                    <span class="text-sm pl-2">{{ $item->pivot->color?->name ?? '—' }}</span>
                                    <span class="text-sm"> / {{ $item->pivot->size->size }}</span>
                                </p>
                                @if($item->pivot->price === $item->pivot->org_price)
                                    <p class="px-2 mt-2">
                                        ${{ number_format($item->pivot->price, 2) }}
                                    </p>
                                    <p> Quantity: {{ $item->pivot->quantity }} </p>
                                @else
                                    <div class="flex flex-col gap-1 mt-2">
                                        <p>
                                            <span class="text-red-500">-{{ $item->pivot->percentage_off }}%</span>
                                            <span class="px-2">
                                                ${{ number_format($item->pivot->price, 2) }}
                                            </span>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            (Was: <span class="px-1 line-through">${{ number_format($item->pivot->org_price, 2) }}</span>)
                                        </p>
                                        <p> Quantity: {{ $item->pivot->quantity }} </p>
                                    </div>
                                @endif                                                                   
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

@endif
