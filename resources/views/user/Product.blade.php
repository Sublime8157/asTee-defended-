
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
                    @foreach(['Couple', 'Solo', 'Family', 'Kid\'s Wear'] as $key => $variation)
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="variation_id" value="{{ $key + 1 }}" class="clear w-3 h-3 cursor-pointer me-1"
                                {{ old('variations') == ($key + 1) ? 'checked' : '' }}>
                            <label for="{{ strtolower(str_replace('\'', '', $variation)) }}" style="font-size: 11px">{{ $variation }}</label>
                        </div>
                    @endforeach
                </ul>
                {{-- Filter by sizes --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs md:text-left text-center mb-2">
                        Sizes
                    </li>
                    <hr class="mb-2">
                    @foreach(['Extra Small','Small','Medium','Large','XL','2XL','3XL'] as $key => $sizes) 
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="size" value="{{ $key + 1 }}" class="clear w-3 h-3 cursor-pointer me-1" 
                                {{ old('sizes') == ($key + 1) ? 'checked' : '' }}>
                            <label for=" {{ strtolower(str_replace('\'','', $sizes)) }}" style="font-size: 11px"> {{ $sizes }} </label>
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
                       @foreach(['Male','Female','Unisex'] as $key => $gender) 
                            <div class="flex flex-row ps-3 p-1 items-center">
                                <input type="radio" name="gender" value=" {{ $key + 1 }}" class="clear w-3 h-3 cursor-pointer me-1"
                                {{ old('gender') == ($key + 1) ? 'checked' : ''}}>
                                <label for=" {{ strtolower(str_replace('\'','', $gender))}}" style="font-size: 11px"> {{ $gender }} </label>
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
          @if($data->isEmpty()) 
               <div class="flex justify-center items-center h-screen">
                    <h1>No Available Product</h1>
               </div>
          @else
                @foreach($data as $table)
                    <div class="w-80  gap-4 bg-white  flex flex-col border shadow rounded mt-2 border-gray-100 pb-2 me-2" >
                            <div class="relative productImage">   
                                {{-- product image  --}}
                                <img src="{{ asset('storage/images/' . $table->image_path) }}" alt="" class="w-full h-80">
                            <div class=" showIcons h-auto  ">
                                <div class="flex flex-row absolute left-0 bottom-0">
                                    {{-- cart icon  --}}
                                    @if(session('isLoggedin'))
                                      {{-- add to cart form --}}
                                    <form class="addToCartForm"  method="POST" id="addToCartForm{{$table->id}}">
                                        @csrf
                                        <input type="hidden" name="prodId" value="{{$table->id}}">
                                        <input type="hidden" name="userId" value="{{$user['id']}}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="addToCartBtn"><ion-icon name="cart" class="ps-2 text-green-600 text-xl"></button>
                                    </form> 
                                    @else
                                    <a href="/" class="cursor-pointer">
                                        <ion-icon name="cart" class="ps-2 text-green-600 text-xl">
                                        </ion-icon>
                                    </a>
                                    @endif
                                    {{-- share link icon  --}}
                                    <a href="/productDetails/{{$table->id}}"  onclick="copyLink(event, {{$table->id}})">
                                        <ion-icon name="share-social" class="text-green-600 text-xl"></ion-icon>
                                    </a>
                                </div>
                            
                            </div>
                            </div>
                            <div class="px-2 ">
                                <div class="px-1 mt-3">
                                    {{-- description w/ gender --}}
                                    <p class="text-sm">{{$table->displayDescription}}| {{$table->genderShirt()}}  | {{$table->variationType()}}</p>                       
                                </div> 
                                    {{-- Size  --}}
                                <div class="text-xs px-1">
                                    <b> Size:</b> {{$table->sizeShirt()}} 
                                </div>
                                <div class="text-xs px-1">
                                    <b> Qty:</b> {{$table->quantity}} 
                                </div>
                                <div class="px-1">
                                    {{-- Price --}}
                                    <h4 class="text-2xl font-semibold  tracking-wide">
                                        &#x20B1;{{$table->price}}.00
                                    </h4>
                                </div>
                                <div class="px-1">
                                    {{-- link --}}
                                    <a href="/productDetails/{{$table->id}}" class="text-xs text-blue-700 cursor-pointer hover:underline">More details..</a>
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