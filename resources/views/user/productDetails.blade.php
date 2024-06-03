<x-header />
<x-navbar />
<body class="bg-gray-100">
    <div class="text-center py-1 text-sm  bg-blue-700 hidden" id="cartResponse">
        <h1 class="text-white">Successfully Added to Cart</h1>
    </div>
    <div class="bg-gray-100 flex justify-center  items-start   h-auto w-full " >
        {{-- get the product --}}
        @foreach($productDet as $data)
       <div class="flex justify-start md:flex-row  mt-12 flex-col  gap-2  md:gap-8 w-11/12 items-start  bg-white shadow p-5" >
        {{-- prod image  --}}
            <div>
                <img src="{{asset('storage/images/'. $data->image_path)}}"  alt="" style="width: 1000px">
            </div>
            <div class="self-start py-4 justify-center w-auto flex flex-col gap-6">
                {{-- product description --}}
                <div class="font-bold tracking-wide ">
                    <h1 class="text-sm md:text-lg">{{$data->description}}</h1>
                </div>
                {{-- product ratings and sold number  --}}
                <div>
                    <p class="text-xs md:text-sm opacity-75 ">No Ratings Yet | <span class="font-bold">0</span> Sold</p>
                </div>
                {{-- product variation, size and gender  --}}
                <div class="flex flex-row gap-2">
                        <div>
                            <span class="text-sm md:text-md opacity-70 me-2">Variation:</span>{{$data->variationType()}}
                        </div>
                        <div>
                            <span class="text-sm md:text-md opacity-70  me-2">Size</span>{{$data->sizeShirt()}}
                        </div>
                        <div>
                            <span class="text-sm md:text-md  opacity-70 me-2">Gender</span>{{$data->genderShirt()}}
                        </div>
                </div>
                {{-- Price --}}
                <div class="w-full bg-gray-50 rounded p-2 md:p-5">
                    <h1 class="text-lg md:text-4xl text-red-500 font-bold tracking-wide ">&#x20B1;{{$data->price}}.00</h1>
                </div>
                {{-- quantity --}}
                <div class="flex flex-row justify-start gap-4 items-center">
                    <p class="opacity-75 text-xs md:text-sm ">Quantity</p>
                    <div class="flex items-center  justify-center border p-0  w-24"">
                        <button class="border-r pe-2" id="minusButton">-</button>
                        <input type="ext" id="quantityValue" value="1" class=" w-10 text-center border-none h-4 text-xs">
                        <button class="border-l ps-2" id="addButton">+</button>
                    </div>
                    <p class="self-center text-xs opacity-75">{{$data->quantity}} Products Available</p> 
                </div> 
                {{-- add to cart and buy now button  --}}
                <div class="flex flex-row items-center gap-4">
                    {{-- if session isLoggedin is present  --}}
                    @if(session('isLoggedin'))
                    <form class="addToCartForm"  method="POST" id="addToCartForm{{$data->id}}">
                        @csrf
                        <input type="hidden" name="prodId" value="{{$data->id}}">
                        <input type="hidden" name="userId" value="{{$user['id']}}">
                        <button class="bg-blue-50 hover:opacity-90 border px-5 md:px-10 text-xs md:text-sm py-2 md:py-4 text-md  flex items-center gap-2 border-blue-400 rounded"><ion-icon name="cart-outline" class="text-sm md:text-md"></ion-icon>Add to Cart</button>
                    </form> 
                    {{-- if not  --}}
                    @else
                       <a href="/">
                        <button class="bg-blue-50 hover:opacity-90 border px-5 md:px-10 text-xs md:text-sm py-2 md:py-4 text-md  flex   items-center gap-2 border-blue-400 rounded"><ion-icon name="cart-outline" class="text-sm md:text-md"></ion-icon>Add to Cart</button></a>
                    @endforelse
                   
                </div>
            </div>
       </div>
        @endforeach
    </div>
</body>
   <script src="{{ asset('/js/products.js') }}"></script>
<x-scripts />