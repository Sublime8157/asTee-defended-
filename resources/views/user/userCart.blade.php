@extends('components.header')
@section('docu', 'Shopping Cart')
<x-header />
<x-navbar />
<body class="bg-gray-100 ">
    <div class="text-center mt-2 ">
        @if(session()->has('error'))
            <span class="text-sm text-orange-800 font-bold ">{{ session()->get('error') }}</span>
        @endif
    </div>
    <div class="min-h-screen mb-5 w-full  flex justify-center items-start">
        <div class="mt-5 w-full  flex justify-center">
            <div class="w-full flex justify-center">        
                {{-- this the table for desktop view  --}}
              <div class="flex flex-col justify-center mx-0 lg:mx-10 items-center w-full h-full gap-2 ">
                {{-- cart header desktop view--}}
                    <div class="lg:flex w-full  justify-evenly  hidden h-10 lg:px-10 xl:px-10 py-8 items-center lg:gap-16 xl:gap-28  bg-white shadow flex-row">
                        {{-- table header --}}
                        <div class="me-72">
                            <input type="checkbox" class="me-2 h-4 w-4 cursor-pointer checkAll" value="">
                            <span class="text-gray-500 text-sm font-normal text-center">Product</span>
                        </div>
                        <div class="ms-4">
                            <div class="text-gray-500 text-sm font-normal text-center ">Unit Price</div>
                        </div>
                       
                        <div>
                            <div class="text-gray-500 text-sm font-normal text-center ">Quantity</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm font-normal text-center ">Total Price</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm font-normal text-center ">Action</div>
                        </div>
                        
                    </div>
                    {{-- table header mobile view --}}
                    <div class="xl:hidden lg:hidden flex w-full justify-start  items-start flex-row  ">
                           <div class="w-full bg-white py-2 px-4 mx-2">
                                <input type="checkbox" class="me-2 h-4 w-4 cursor-pointer checkAll" value="">
                                <span class="text-gray-500 text-sm font-normal text-center">Product</span>
                           </div>
                    </div>
                    {{-- table body --}}    
                    @foreach($cartItems as $item)
                    <input type="hidden" value="{{ $item->product_id }}" id="productId{{ $item->product_id }}" class="prodId">
                    <div class="item rounded flex justify-evenly lg:px-6 lg:py-8 items-start lg:items-center mx-2 xl:gap-36 lg:gap-20   w-auto  bg-white shadow flex-col lg:flex-row">
                        {{-- edit btn visible only on mobile --}}
                        <div class="lg:hidden relative border-b border-gray-200 mb-2 w-full  flex-row-reverse p-2 flex text-gray-500 text-xs" >
                            <span id="editBtnCart" class="cursor-pointer">Edit</span>
                            <div class="absolute top-6 bg-white shadow px-2 py-1 hidden " id="removeBtnCart">
                                <a onclick="removeCartItem({{ $item->product_id }})" class="cursor-pointer">Remove</a>
                                <form action="{{ route('remove.cart', $item->id) }}"  id="removeItemForm{{ $item->product_id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                        <div class="flex-row items-center justify-center flex   px-2 py-2">
                           
                            {{-- checkbox --}}
                           <div class="me-4">
                                <input type="checkbox" name="" onclick="updateCart({{ $item->product_id }})" value="{{ $item->product_id }}" class="h-4 w-4 cursor-pointer list" id="cart{{ $item->product_id }}">
                           </div>
                            <div class="flex flex-row items-center  gap-2">
                                {{-- image --}}
                                <div>
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->shortDescription }}" class="bg-gray-200 w-64 h-48  rounded">
                                </div>
                                {{-- description --}}
                                <div class="flex flex-col gap-1 w-auto">
                                        <p class="text-gray-700 text-xs md:text-base lg:text-base mb-1">{{ $item->product->description }}</p>
                                        {{-- details  --}}
                                   <div>
                                        <p class="text-gray-500 text-sm flex flex-col">{{ $item->product->variation->label() }} | {{ $item->product->size->label() }} | {{ $item->product->gender->label() }} </p>
                                   </div>
                                   {{-- total price (MobileV) --}}
                                   <div class="lg:hidden flex flex-row gap-2 items-center">
                                        <div>
                                            ₱<span id="textPrice{{ $item->product_id }}" class="txtPriceMobile">{{ $item->product->price }}</span>
                                            <input type="hidden" class="total" name="totalPrice" value="{{ $item->product->price }}" id="totalPrice{{ $item->product_id }}">
                                        </div>
                                        <div class="text-xs text-gray-400 flex flex-row items-center">
                                            <span>Stock:</span><input type="text" id="stockMobile{{ $item->product_id }}" value="{{ $item->product->stock }}" class="text-xs w-10  border-none" disabled>
                                        </div>
                                    </div>
                                    {{--  quantity mobile View--}}
                                    
                                    <div class="lg:hidden flex  items-center  justify-center border p-0  w-24  quantityDivMobile" id="quantityDiv{{ $item->product_id }}">
                                        <button class="border-r minusBtn pe-2 minusButtonMobile" id="minusButton{{ $item->product_id }}" onclick="minusButton({{ $item->product_id }})" disabled>-</button>
                                        <input type="ext" name="quantity" id="quantityValue{{ $item->product_id }}" value="{{ $item->quantity }}" class="quantityValueMobile w-10 text-center border-none h-4 text-xs" disabled>
                                        <button class="border-l ps-2 addBtn addButtonMobile"  id="addButton{{ $item->product_id }}" onclick="addButton({{ $item->product_id }})" disabled>+</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        {{-- unit price Desktop View--}}
                        <div class="lg:flex hidden">
                            <span class="" >₱{{ $item->product->price }}
                                <input type="hidden" name="price" value="{{ $item->product->price }}" id="unitPrice{{ $item->product_id }}" class="unitPrice">
                            </span>
                        </div>
                        {{-- quantity Desktop View--}}
                        <div class="lg:flex hidden flex-col items-center ">
                            <div class="flex items-center  justify-center border p-0  w-24 quantityDivDesktop" id="desktopQuantityDiv{{ $item->product_id }}">
                                <button class="border-r pe-2 desktopMinusBtn " id="desktopMinusButton{{ $item->product_id }}" onclick="minusButton({{ $item->product_id }})" disabled>-</button>    
                                <input type="text" name="quantity[]" onchange="updateQuantities()" id="desktopQuantityValue{{ $item->product_id }}" value="{{ $item->quantity }}" class="desktopQuantityValue w-10 text-center border-none h-4 text-xs" disabled>
                                <button class="border-l ps-2 desktopAddButton"  id="desktopAddButton{{ $item->product_id }}" onclick="addButton({{ $item->product_id }})" disabled>+</button>
                            </div>  
                            <div class="text-xs text-gray-400 flex flex-row items-center">
                                <span>Stock:</span><input type="text" id="stockDesktop{{ $item->product_id }}" value="{{ $item->product->stock }}" class="stockDesktop text-xs w-10  border-none" disabled>
                            </div>
                        </div>
                        {{-- total price Desktop View--}}
                        <div class="lg:flex hidden w-4">
                            ₱<span id="desktopTextPrice{{ $item->product_id }}" class="desktopTextPrice">{{ $item->product->price }}</span>
                        </div>
                        {{-- action --}}
                        <div class="lg:flex hidden">
                            <a onclick="removeCartItem({{ $item->product_id }})" class="cursor-pointer">Remove</a>
                            <form action="{{ route('remove.cart', $item->id) }}"  id="removeItemForm{{ $item->product_id }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    @endforeach
                    {{-- table footer --}}
                    <div class="w-full xl:relative lg:relative  flex items-center justify-center h-auto fixed" style="bottom: 0px;">
                        <div class="flex bg-white justify-between  ps-8 py-2 px-4 w-full items-center h-16 flex-row xl:mx-8 mx-2 ">
                            <div>
                                <div class=" flex flex-row items-center gap-0 md:gap-8">
                                    <div class="flex flex-row items-center">
                                        <input type="checkbox" class="w-3 h-3 checkAll  me-4 4cursor-pointer" value="">
                                        <span class="md:block hidden">Select All    </span>
                                    </div>
                                    {{-- delete all form --}}
                                    <form action="{{route('remove.All')}}" method="POST" id="removeAllForm">
                                        @csrf
                                        <input type="hidden" value="" id="removeAll" name="toRemove">
                                        <button class=" text-orange-500 md:text-base text-sm">Delete</button>
                                    @method('DELETE')
                                </form>
                                </div>
                            </div>
                            <div>
                                
                                {{-- total number of items selected in cart  --}}
                                <div class="text-xs sm:text-base flex items-center">Total (<span id="countItems" class="font-bold pe-1"></span> Item/s): 
                                {{-- total amount of items selected in cart  --}}
                                <h1 class="text-orange-600 md:text-3xl text-base font-extralight me-2">
                                    ₱<span id="totalAmountTxt" class="md:text-2xl text-sm"></span>
                                    
                                </h1>
                                {{-- checkout button --}}
                                <form action="{{route('checkout.process')}}" method="GET">
                                    @csrf
                                    {{-- The owner comes from the guard, and the total is computed
                                         server-side from products.price. Both used to be editable
                                         inputs whose values were written straight to the database. --}}
                                    <input type="hidden" value="" id="itemsId" name="items">
                                    <input type="hidden" name="quantity" id="quantitiesInput">
                                    {{-- <input type="text" value="" id="arrayList"> --}}
                                    <button type="submit" class="  bg-blue-700  text-white text-xs md:text-sm  w-20 md:w-40 text-center rounded hover:opacity-40 px-2 py-1 md:px-4 md:py-2" >
                                        Checkout </button>
                                </form>
                                    {{-- checkout dialog  --}}
                                    <dialog id="checkoutDialog">
                                        
                                    </dialog>
                                </div>   
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    </div> 
</body>
<script src="{{ asset('/js/products.js') }}"></script>
<script>
      var counts = $('.item').length;
      localStorage.setItem('count', counts);
</script>
<x-footer />
<x-scripts />