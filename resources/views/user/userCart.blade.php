@extends('components.header')
@section('docu', 'Shopping Cart')
<x-header />
<x-navbar />
<body class="bg-gray-100 overflow-x-hidden">
    <div class="min-h-screen mb-5 w-screen  flex justify-center items-start">
        <div class="mt-5 w-screen  hidden lg:flex justify-center mx-5 ">
            <div class="w-full flex justify-center">        
                {{-- this the table for desktop view  --}}
                <table class=" justify-center flex-col ">
                    {{-- table header  --}}
                    <thead class="bg-gray-50 lg:flex hidden   mb-2  border-1 border-orange-300 shadow  py-4 px-8">
                        <tr>       
                        {{-- checkbox --}}
                            <th class="text-gray-500 font-normal text-sm w-80  text-left">
                                <input type="checkbox" class="me-2 h-3 w-3 cursor-pointer checkAll" value="">
                                <span>Product</span>
                            </th>
                            <th class="text-gray-500 text-sm font-normal text-center w-40  ">Unit Price</th>
                            <th class="text-gray-500 text-sm font-normal text-center w-40 ">Quantity</th>
                            <th class="text-gray-500 text-sm font-normal text-center w-40">Total Price</th>
                            <th class="text-gray-500 text-sm font-normal text-center w-40">Action</th>
                        </tr>
                    </thead>
                     {{-- products added to cart  --}}
                     <tbody class="bg-gray-50">
                       @foreach($products as $userCart)
                            <tr class=" item border-1 border-orange-300  flex items-center  py-4 px-8">   
                                <div>
                                    {{-- Product Description --}}
                                    <td class="w-80 flex flex-row items-center">
                                        {{-- checkbox --}}
                                        <div class="me-2">
                                            <input type="checkbox" name="" onclick="updateCart({{$userCart->id}})" value="{{$userCart->id}}" class="h-3 w-3 cursor-pointer list" id="cart{{$userCart->id}}">
                                        </div>
                                        <div>
                                            <img src="{{ asset('storage/images/'. $userCart->image_path) }}" alt="" width="100" class="bg-gray-200 rounded">
                                        </div>
                                        <div class="self-start ms-2 text-sm w-60">
                                            <p class="text-gray-700 text-sm mb-1">{{$userCart->description}}</p>
                                            <p class="text-gray-500 text-xs">{{$userCart->variationType()}}| {{$userCart->sizeShirt()}} | {{$userCart->genderShirt()}} </p>
                                        </div>
                                    </td>  
                                    {{-- unit price  --}}
                                    <td class="text-center  w-40 text-sm ">
                                        <span class="" >₱{{$userCart->price}}.00
                                            <input type="hidden" name="price" value="{{$userCart->price}}" id="unitPrice{{$userCart->id}}">
                                        </span>
                                    </td>
                                    {{-- quantity  --}}
                                    <td class="text-center flex justify-center w-40 text-sm  ">
                                        <div class="flex items-center  justify-center border p-0  w-24" id="quantityDiv{{$userCart->id}}">
                                            <button class="border-r pe-2" id="minusButton{{$userCart->id}}" onclick="minusButton({{$userCart->id}})" disabled>-</button>
                                            <input type="ext" name="quantity" id="quantityValue{{$userCart->id}}" value="1" class=" w-10 text-center border-none h-4 text-xs" disabled>
                                            <button class="border-l ps-2"  id="addButton{{$userCart->id}}" onclick="addButton({{$userCart->id}})" disabled>+</button>
                                        </div>  
                                    </td>
                                    {{-- Total Price --}}
                                    <td class="text-center text-sm text-orange-600 w-40" >
                                        ₱<span id="textPrice{{$userCart->id}}">{{$userCart->price}}</span>
                                        <input type="hidden" class="total" name="totalPrice" value="{{$userCart->price}}" id="totalPrice{{$userCart->id}}">
                                    </td>
                                </div>
                                {{-- Action --}}
                                <td class="text-center text-sm text-orange-800 w-40">
                                    <a onclick="removeCartItem({{$userCart->id}})" class="cursor-pointer">Remove</a>
                                    <form action="{{ route('remove.cart', $userCart->id) }}"  id="removeItemForm{{$userCart->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        {{-- remove all items  --}}
                    </tbody>
                    {{-- table footer --}}
                    <tfoot class="bg-gray-50  mb-2  border-1 border-orange-300 shadow flex py-4 px-8 mt-2">
                        <tr class="flex justify-between items-center w-full">
                            {{-- checkbox for deleting all items in cart --}}
                           <div>
                                <td class="w-80 flex flex-row items-center gap-4">
                                   <div>
                                        <input type="checkbox" class="w-3 h-3 checkAll  cursor-pointer" value="">
                                        <label for="" class="text-sm">Select All</label>
                                   </div>
                                   {{-- delete all form --}}
                                   <form action="{{route('remove.All')}}" method="POST" id="removeAllForm">
                                        @csrf
                                        <input type="hidden" value="" id="removeAll" name="toRemove">
                                        <button class="text-sm  text-orange-500">Delete</button>
                                    @method('DELETE')
                                </form>
                                </td>
                                <td></td>
                                <td></td>
                           </div>
                           {{-- total amount and checkout button  --}}
                           <div class="flex items-center flex-row gap-2">
                                {{-- total number of items selected in cart  --}}
                                <td class="text-sm flex items-center">Total (<span id="countItems" class="font-bold pe-1"></span> Item/s): 
                                {{-- total amount of items selected in cart  --}}
                                <h1 class="text-orange-600 text-3xl font-extralight me-2">
                                    ₱<span id="totalAmountTxt"></span>
                                    <input type="hidden" value="" id="totalAmountVal"  disabled>
                                </h1>
                                {{-- checkout button --}}
                                <button class="px-2 py-1 w-40 h-10 text-sm rounded-sm bg-blue-700  text-white hover:opacity-40">Checkout</button>
                                </td>   
                           </div>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- table for mobile view --}}
        </div>
        {{-- <div class=" lg:hidden w-full  justify-center flex">
            <table class="w-auto mt-5">
                <thead class="bg-gray-50 lg:hidden flex   mb-2  border-1 border-orange-300 shadow  py-4 px-8">
                    <tr>       
                    
                        <th class="text-gray-500 font-normal text-sm w-80  text-left">
                            <input type="checkbox" class="me-2 h-3 w-3 cursor-pointer checkAll" value="">
                            <span>Product</span>
                        </th>
                    </tr>
                </thead>
               <tbody class="">
                @foreach($products as $userCart)
                    <tr class=" border-b px-4 flex items-center justify-between bg-white ">
                        <td class="text-xs "><input type="checkbox" class="me-2">Check All</td>
                        <td></td>
                       <td class="text-right p-2 text-gray-400 text-xs cursor-pointer" id="editBtn">Edit</td>
                    </tr>
                    <tr class="px-4 py-2 bg-white shadow rounded flex items-start w-full ">
                        <td class="self-center"><input type="checkbox" name="" id=""></td>
                        <td class="px-2 "><img src="{{ asset('storage/images/'. $userCart->image_path) }}" alt="" width="150px" class="bg-gray-300 rounded"></td>
                        <td class="w-48 md:w-80 flex gap-2 flex-col">
                            <p class="text-xs md:text-sm">{{$userCart->description}}</p>
                            <p class="text-xs md:text-sm text-gray-400">{{$userCart->variationType()}}| {{$userCart->sizeShirt()}} | {{$userCart->genderShirt()}}</p>
                            <p class="text-xs md:text-sm text-orange-600 font-bold">{{$userCart->price}}</p>
                            <p class="text-center flex justify-center w-40 text-sm  ">
                                <div class="flex items-center  justify-center border p-0  w-24" id="quantityDiv{{$userCart->id}}">
                                    <button class="border-r pe-2" id="minusButton{{$userCart->id}}" onclick="minusButton({{$userCart->id}})" disabled>-</button>
                                    <input type="ext" name="quantity" id="quantityValue{{$userCart->id}}" value="1" class=" w-10 text-center border-none h-4 text-xs" disabled>
                                    <button class="border-l ps-2"  id="addButton{{$userCart->id}}" onclick="addButton({{$userCart->id}})" disabled>+</button>
                                </div>  
                            </p>
                        </td>
                        <td class="self-center hidden text-xs text-orange-500" id="removeItem">
                            Remove
                        </td>
                    </tr>
                @endforeach
               </tbody>
            </table>
        </div> --}}
    </div>
</body>
<script src="{{ asset('/js/products.js') }}"></script>
<script>
      var counts = $('.item').length;
      localStorage.setItem('count', counts);
</script>
<x-footer />
<x-scripts />