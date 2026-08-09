
@extends('components.header')
@section('docu', 'Products')
<x-header />
<x-navbar />
<div class="text-center py-1 text-sm  bg-blue-700 hidden" id="cartResponse">
    <h1 class="text-white">Successfully Added to Cart</h1>
</div>
    <div class="flex justify-evenly md:flex-row flex-col items-start "> 
        {{-- Filtering section  --}}
        <a onclick="" class="p-5 md:hidden  top-0 flex items-center">
            <ion-icon name="caret-forward-outline" class="me-2 cursor-pointer" onclick="displayFilter(this)"></ion-icon> Filter
        </a>
        <div class="mx-4 justify-center md:block hidden md:w-64 w-screen md:p-8 p-0 me-5" id="filterSettings">
            {{-- Form for filtering products --}}
           <form  method="GET" id="filterForm" class="w-full md:block md:flex-col flex flex-row justify-center">
            @csrf
                <div>
                    <ul>
                        <li class="font-bold text-xs mb-2">
                            Filter
                        </li>
                        <hr class="mb-2">
                    </ul>
                    {{-- Filter All --}}
                    <ul class="ps-3 p-1 mb-2 ">
                        <input type="radio" id="all" name="all" value="" class="clear w-3 h-3">
                        <label for="all" class="text-xs">All</label>
                    </ul>
                </div>
                {{-- Filter by Variations --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs mb-2  md:text-left text-center ">
                        Variation
                    </li>
                    <hr class="mb-2">
                    @foreach(\App\Enums\Variation::options() as $value => $label)
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="variation" value="{{ $value }}" class="clear w-3 h-3 cursor-pointer me-1"
                                {{ old('variation') === $value ? 'checked' : '' }}>
                            <label for="{{ $value }}" style="font-size: 11px">{{ $label }}</label>
                        </div>
                    @endforeach
                </ul>
                {{-- Filter by sizes --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs md:text-left text-center mb-2">
                        Sizes
                    </li>
                    <hr class="mb-2">
                    @foreach(\App\Enums\ShirtSize::options() as $value => $label)
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="size" value="{{ $value }}" class="clear w-3 h-3 cursor-pointer me-1"
                                {{ old('size') === $value ? 'checked' : '' }}>
                            <label for="{{ $value }}" style="font-size: 11px">{{ $label }}</label>
                        </div>
                    @endforeach
                </ul>
                {{-- Filter by Gender --}}
                <div>
                    <ul class="flex flex-col mb-2">
                        <li class="font-bold text-xs md:text-left text-center">
                            Gender
                        </li>
                        <hr class="mb-2">
                       @foreach(\App\Enums\Gender::options() as $value => $label)
                            <div class="flex flex-row ps-3 p-1 items-center">
                                {{-- The old markup wrote value=" 1" with a leading space, so the gender filter never matched. --}}
                                <input type="radio" name="gender" value="{{ $value }}" class="clear w-3 h-3 cursor-pointer me-1"
                                    {{ old('gender') === $value ? 'checked' : '' }}>
                                <label for="{{ $value }}" style="font-size: 11px">{{ $label }}</label>
                            </div>
                       @endforeach
                       <a onclick="clearRadio()" class="text-xs text-center cursor-pointer underline text-blue-500 ">Clear Fields</a>
                    </ul>
                <div class="w-auto">
                    <ul class="flex gap-1  w-6/12 flex-col mb-2">
                        <li class="font-bold text-xs md:text-left text-center">
                            <h6>
                                Price range
                            </h6>
                            <hr class="mb-2">
                            <div class="flex flex-row gap-1">
                                <div>
                                    <label for="" class="text-xs">min:</label>
                                    <input type="number" name="priceFrom" id="" class="p-1 w-16 text-xs h-6">
                               </div>
                               <div>
                                    <label for="" class="text-xs">max:</label>
                                    <input type="number" name="priceTo" id="" class="p-1 w-16 text-xs h-6">
                               </div>
                            </div>
                        </li>
                        <li class="w-full">
                            <button type="submit" class="px-2 w-full py-1 bg-red-600 text-white text-sm text-center rounded">Apply</button>
                        </li>
                    </ul>
                </div>
                </div>
              
           </form>
        </div>
        {{-- List of available products  --}}
        <div class="w-screen flex justify-center  flex-row flex-wrap h-screen " style="overflow-y: auto" id="filteredData">
            {{-- Get all the data in products table and assign it to filterData variable --}}
          @if($products->isEmpty()) 
               <div class="flex justify-center items-center h-screen">
                    <h1>No Available Product</h1>
               </div>
          @else
                @foreach($products as $product)
                    <div class="w-80  gap-4 bg-white  flex flex-col border shadow rounded mt-2 border-gray-100 pb-2 me-2" >
                            <div class="relative productImage">   
                                {{-- product image  --}}
                                <img src="{{ $product->image_url }}" alt="{{ $product->shortDescription }}" class="w-full h-80">
                            <div class=" showIcons h-auto  ">
                                <div class="flex flex-row absolute left-0 bottom-0">
                                    {{-- cart icon  --}}
                                    @if(auth()->check())
                                      {{-- add to cart form --}}
                                    <form class="addToCartForm"  method="POST" id="addToCartForm{{ $product->id }}">
                                        @csrf
                                        {{-- The owner is the signed-in user; userId no longer travels in the body. --}}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="addToCartBtn"><ion-icon name="cart" class="ps-2 text-green-600 text-xl"></button>
                                    </form> 
                                    @else
                                    <a href="/" class="cursor-pointer">
                                        <ion-icon name="cart" class="ps-2 text-green-600 text-xl">
                                        </ion-icon>
                                    </a>
                                    @endif
                                    {{-- share link icon  --}}
                                    <a href="/productDetails/{{ $product->id }}"  onclick="copyLink(event, {{ $product->id }})">
                                        <ion-icon name="share-social" class="text-green-600 text-xl"></ion-icon>
                                    </a>
                                </div>
                            
                            </div>
                            </div>
                            <div class="px-2 ">
                                <div class="px-1 mt-3">
                                    {{-- description w/ gender --}}
                                    <p class="text-sm">{{ $product->shortDescription }} | {{ $product->gender->label() }} | {{ $product->variation->label() }}</p>                       
                                </div> 
                                    {{-- Size  --}}
                                <div class="text-xs px-1">
                                    <b> Size:</b> {{ $product->size->label() }} 
                                </div>
                                <div class="text-xs px-1">
                                    <b> Qty:</b> {{ $product->stock }} 
                                </div>
                                <div class="px-1">
                                    {{-- Price --}}
                                    <h4 class="text-2xl font-semibold  tracking-wide">
                                        &#x20B1;{{ $product->price }}
                                    </h4>
                                </div>
                                <div class="px-1">
                                    {{-- link --}}
                                    <a href="/productDetails/{{ $product->id }}" class="text-xs text-blue-700 cursor-pointer hover:underline">More details..</a>
                                </div>
                                
                            </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

<x-footer />
<script src="/js/products.js"></script>
<x-scripts />