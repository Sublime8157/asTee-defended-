@extends('components.header')
@section('docu', 'Dashboard')
@section('page','ON-PROCCESS PRODUCTS')
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
               <div class="flex items-center bg-blue-600 px-4 py-2 cursor-pointer hover:bg-blue-500" onclick="revealForm()" >
                    <ion-icon name="add-circle-outline" class="pe-1 text-white text-lg"></ion-icon>
                    <button class="text-xs text-white" >New Product</button>
               </div>
            </div>
        </div>
    </div>
    <div class="mx-10 pb-10 flex justify-center">
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
               <td class="w-32"></td>
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
           @foreach($onProcessProducts as $product) 
           <tr class=" text-xs">
                <td class="ps-2">{{$product->id}} </td>
                {{-- Get the image path  --}}
                <td class="ps-2"><img src="{{ asset('images/' . $product->image_path ) }}" alt="Product Image" width="50px"></td>
                <td class="ps-2">{{$product->variationType()}}</td>
                <td class="ps-2">{{$product->description}}</td>
                <td class="ps-2">{{$product->genderShirt()}}</td>
                <td class="ps-2">{{$product->sizeShirt()}}</td>
                <td class="ps-2">{{$product->price}}</td>
                <td class="ps-2">{{$product->quantity}}</td>
                <td class="ps-2">{{$product->producStats()}}</td>
               
           </tr>
           <tr>
                <td colspan="10"> <hr class="w-full my-2"></td>
           </tr>
           @endforeach
        </table>
    </div>
</div>
{{-- This is the add product form --}}
<div>
    <dialog class=" modal bg-white shadow-lg rounded p-10  w-8/12" id="addProdForm"> 
        <h1 class="font-bold tracking-wide mb-2">ADD PRODUCT</h1>
        <form action="/addProduct" class="flex justify-center  items-start flex-row-reverse">
            @csrf 
            
           <div class="flex flex-row items-start flex-wrap">
             {{-- Choose Variation Type --}}
                <div class="me-2">
                    <label for="" class="text-xs">Variation*</label> <br>
                     <select name="" id="" class="h-10 w-40 rounded text-sm cursor-pointer">
                        <option value=""">Couple</option>
                    </select>
                </div>
                {{-- Choose t-shirt gender type --}}
                <div class="me-2">
                    <label for="" class="text-xs">Gender*</label> <br>
                     <select name="" id="" class="h-10 w-40 rounded text-sm cursor-pointer">
                        <option value=""">Male</option>
                    </select>
                </div>
                {{-- Choose size --}}
                <div class="me-2">
                    <label for="" class="text-xs">Size*</label> <br>
                     <select name="" id="" class="h-10 w-40 rounded text-sm cursor-pointer">
                        <option value=""">Small</option>
                    </select>
                </div> 
                {{-- Input thep price --}}
                <div class="me-2">
                    <label for="" class="text-xs">Price*</label> <br>
                     <input type="text" class="h-10 w-40 rounded text-sm ">
                </div>
                {{-- input the quantity --}}
                <div class="me-2">
                    <label for="" class="text-xs">Quantity*</label> <br>
                     <input type="text" class="h-10 w-40 rounded text-sm ">
                </div>
                {{-- And the description of the product this includes the reason why it's on hand  --}}
                <div class="me-2">
                    <label for="">Description*</label><br>
                    <textarea name="" id="" cols="50" rows="2" class="text-xs rounded"></textarea>
               </div>
           </div>
           {{-- Image input --}}
            <div class="flex items-center flex-col">
                <div class="relative border-2 border-dashed rounded-md me-5 self-center mb-5">
                    <ion-icon name="cloud-upload-outline" class="z-0 absolute absolute-center text-9xl text-gray-400 opacity-20"></ion-icon>
                    <input type="file" name="prodImage" class="py-20 cursor-pointer opacity-0">
                </div>
                <div>
                    <button type="submit" class="py-1 text-sm bg-blue-700 rounded-sm text-white font-light px-2 hover:opacity-50">Save</button>
                    <button type="button" class="py-1 text-sm bg-orange-600 rounded text-white font-light px-4 hover:opacity-50">Save & Add More</button>
                    <button type="button" id="closeBtn" class="border-2 px-2 py-1 text-sm rounded hover:opacity-50">Cancel</button>
                </div>
            </div>
        </form>
    </dialog>
</div>
</div>
</div>

<x-adminFooter />