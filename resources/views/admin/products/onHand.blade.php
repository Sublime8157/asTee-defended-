@extends('components.header')
@section('docu', 'Products')
@section('page','ON-HAND PRODUCTS')
<x-header />
<x-nav />
        <div class="bg-white my-5 mx-4">
            <div class="">
                <div class="flex justify-between items-center flex-row p-3">
                    <div class="flex flex-row">
                        <div class="me-3">
                            <select name="" id="" class="h-8 text-xs cursor-pointer">
                                <option value="1" class="text-xs">Filter by Group</option>
                            </select>
                        </div>
                        <div>
                            <select name="" id="" class="h-8 text-xs cursor-pointer">
                                <option value="1" class="text-xs">Filter by Group</option>
                            </select>
                        </div>
                    </div>
                    <div>
                       <div class="flex items-center bg-blue-600 px-4 py-2 cursor-pointer hover:bg-blue-500">
                            <ion-icon name="add-circle-outline" class="pe-1 text-white text-lg"></ion-icon>
                            <span class="text-xs text-white">New Product</span>
                       </div>
                    </div>
                </div>
            </div>
            <div class="mx-10 pb-10">
                <table class="">
                   <tr class="">
                        <th class="adminTable">ID</th>
                        <th class="adminTable w-20">Image</th>
                        <th class="adminTable">Variation</th>
                        <th class="adminTable">Description</th>
                        <th class="adminTable">Gender</th>
                        <th class="adminTable">Size</th>
                        <th class="adminTable">Price</th>
                        <th class="adminTable w-24">Quantity</th>
                        <th class="adminTable w-24">Status</th>
                        <th class="adminTable w-24">Action</th>
                   </tr>
                   <tr>
                        <td colspan="10"><hr class="w-full mt-1 mb-3"></td>
                   </tr>
                   <tr>
                       <td class="w-12"><input type="text" placeholder="ID" class="w-10 h-8 text-xs "></td>
                       <td class="w-12"></td>
                       <td class="w-40 ">
                            <select name="" id="" class="w-32 h-8 text-xs  cursor-pointer">
                                <option value="1" class="text-xs">Couple</option>
                            </select>
                        </td>
                       <td class="w-40 "><input type="text" placeholder="Description" class="w-32 h-8 text-xs"></td>
                       <td class="w-20">
                            <select name="" id="" class="w-16 h-8 text-xs  cursor-pointer">
                                <option value="1">Male</option>
                            </select>
                        </td>
                       <td class="w-40">
                            <select name="" class="w-32  h-8 text-xs cursor-pointer" id="">
                                <option value="1">Small</option>
                            </select>
                        </td>
                       <td class="w-40"><input type="text" placeholder="Price" class="w-32 h-8 text-xs"></td>
                   </tr>
                   {{-- the variable onHandProducts is from controller and assigned it to a product variable to query in product table  --}}
                   {{-- Take note that the words after $product is a table name in product table from database --}}
                   {{-- We then loop to the database  and each data in product table these code below will execute  --}}
                   {{-- The  variationType() is a function from model that  convert the number into value--}}
                   @foreach($onHandProducts as $product) 
                   <tr class=" text-xs">
                        <td class="ps-2">{{$product->id}} </td>
                        {{-- Get the image path  --}}
                        <td class="ps-2"><img src="{{ asset('images/' . $product->image_path ) }}" alt="Product Image" width="50px"></td>
                        <td class="ps-2">{{$product->variationType()}}</td>
                        <td class="ps-2">{{$product->description}}</td>
                        <td class="ps-2">{{$product->genderShirt()}}</td>
                        <td class="ps-2">{{$product->sizeShirt()}}</td>
                        <td class="ps-2">{{$product->price}}</td>
                        <td class="ps-2">4</td>
                        <td class="ps-2">New</td>
                   </tr>
                   <tr>
                        <td colspan="10"> <hr class="w-full my-2"></td>
                   </tr>
                   @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<x-adminFooter />