<x-header />
<x-navbar />
<body class="bg-gray-100">
    <div class="text-center py-1 text-sm  bg-blue-700 hidden" id="cartResponse">
        <h1 class="text-white">Successfully Added to Cart</h1>
    </div>
    <div class="bg-gray-100 flex justify-center  items-start   h-auto w-full " >
       <div class="flex justify-start md:flex-row  mt-12 flex-col  gap-2  md:gap-8 w-11/12 items-start  bg-white shadow p-5" >
        {{-- prod image  --}}
            <div>
                <img src="{{ $product->image_url }}" alt="{{ $product->description }}" class="h-96 w-80">
            </div>
            <div class="self-start py-4 justify-center w-auto flex flex-col gap-6">
                {{-- product description --}}
                <div class="font-bold tracking-wide ">
                    <h1 class="text-sm md:text-lg">{{ $product->description }}</h1>
                </div>
                {{-- product variation, size and gender  --}}
                <div class="flex flex-row gap-2">
                        <div>
                            <span class="text-sm md:text-md opacity-70 me-2">Variation:</span>{{ $product->variation->label() }}
                        </div>
                        <div>
                            <span class="text-sm md:text-md opacity-70  me-2">Size</span>{{ $product->size->label() }}
                        </div>
                        <div>
                            <span class="text-sm md:text-md  opacity-70 me-2">Gender</span>{{ $product->gender->label() }}
                        </div>
                </div>
                {{-- Price --}}
                <div class="w-full bg-gray-50 rounded p-2 md:p-5">
                    <h1 class="text-lg md:text-4xl text-red-500 font-bold tracking-wide ">&#x20B1;{{ $product->price }}</h1>
                </div>
                {{-- stock --}}
                <div class="flex flex-row justify-start gap-4 items-center">
                    <p class="self-center text-xs opacity-75">{{ $product->stock }} Products Available</p>
                </div>
                {{-- add to cart  --}}
                <div class="flex flex-row items-center gap-4">
                    @if(auth()->check())
                    <form class="addToCartForm"  method="POST" id="addToCartForm{{ $product->id }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button class="bg-blue-50 hover:opacity-90 border px-5 md:px-10 text-xs md:text-sm py-2 md:py-4 text-md  flex items-center gap-2 border-blue-400 rounded"><ion-icon name="cart-outline" class="text-sm md:text-md"></ion-icon>Add to Cart</button>
                    </form>
                    @else
                       <a href="/">
                        <button class="bg-blue-50 hover:opacity-90 border px-5 md:px-10 text-xs md:text-sm py-2 md:py-4 text-md  flex   items-center gap-2 border-blue-400 rounded"><ion-icon name="cart-outline" class="text-sm md:text-md"></ion-icon>Add to Cart</button></a>
                    @endif
                </div>
            </div>
       </div>
    </div>
</body>
   <script src="{{ asset('/js/products.js') }}"></script>
<x-scripts />
