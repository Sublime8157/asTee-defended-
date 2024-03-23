@extends('components.header')
@section('docu', 'Shopping Cart')
<x-header />
<x-navbar />
<body class="bg-gray-100">
    <div class="min-h-screen mb-5 w-full flex justify-center items-star">
        <div class="mt-5">
            <div class="">             
                <table>
                    {{-- table header  --}}
                    <thead class="bg-gray-50  mb-2  border-1 border-orange-300 shadow flex py-4 px-8">
                        <tr>       
                        {{-- checkbox --}}
                            <th class="text-gray-500 font-normal text-sm w-80  text-left">
                                <input type="checkbox" class="me-2 h-3 w-3 cursor-pointer" id="checkAll">
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
                            <tr class="item border-1 border-orange-300  flex items-center  py-4 px-8">     
                                {{-- Product Description --}}
                                <td class="w-80 flex flex-row items-center">
                                    <div class="me-2">
                                        <input type="checkbox" name="" id="" class="h-3 w-3 cursor-pointer">
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
                                <span class="">₱{{$userCart->price}}.00</span>
                                </td>
                                {{-- quantity  --}}
                                <td class="text-center flex justify-center w-40 text-sm  ">
                                    <div class="flex items-center  justify-center border p-0  w-24">
                                        <button class="border-r pe-2" id="minusButton">-</button>
                                        <input type="ext" id="quantityValue" value="1" class=" w-10 text-center border-none h-4 text-xs">
                                        <button class="border-l ps-2" id="addButton">+</button>
                                    </div>  
                                </td>
                                {{-- Total Price --}}
                                <td class="text-center text-sm text-orange-600 w-40">
                                    ₱150.00
                                </td>
                                {{-- Action --}}
                                <td class="text-center text-sm text-orange-800 w-40">
                                    <a onclick="removeCartItem({{$userCart->id}})" class="cursor-pointer">Remove</a>
                                    <form action="{{ route('remove.cart', $userCart->id) }}"  id="removeItemForm{{$userCart->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr class=" border-gray-200">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50  mb-2  border-1 border-orange-300 shadow flex py-4 px-8 mt-2">
                        <tr class="flex justify-between items-center w-full">
                           <div>
                                <td class="w-80 flex flex-row items-center gap-4">
                                   <div>
                                        <input type="checkbox" class="w-3 h-3">
                                        <label for="" class="text-sm">Select All</label>
                                   </div>
                                    <form action="">
                                        @csrf
                                        <button class="text-sm text-orange-600">Delete</button>
                                    </form>
                                </td>
                                <td></td>
                                <td></td>
                           </div>
                           <div class="flex items-center flex-row gap-2">
                                <td class="text-sm flex items-center">Total (0Item): 
                                <span class="text-orange-600 text-3xl font-extralight me-2"> ₱0.00</span>
                                <button class="px-2 py-1 w-40 h-10 text-sm rounded-sm bg-blue-700  text-white hover:opacity-40">Checkout</button>
                                </td>   
                           </div>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="8/12">
    
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