@extends('components.header')
@section('docu', 'On-Hand Products')
@section('page','ON-HAND PRODUCTS')
<x-header />
<x-nav />
<x-notification />
<div class="p-3">
    {{ $products->links('pagination::simple-tailwind') }} 
</div>
@if($errors->any()) 
    <div class="text-center py-2 px-2 text-xs font-orange-700 font-bold">
        {{$errors->first()}}
    </div>
@endif
   <div class="bg-white my-2 mx-4">
        <x-sortingProducts sortProduct="sortProd" orderProduct="sortProd" display="hidden" filterByDate="" :columns="['id' => 'ID', 'description' => 'Description', 'price' => 'Price', 'stock' => 'Stock', 'created_at' => 'Date added']" :newProduct="true" />
            <div class="mx-10 pb-10 flex justify-center">
                    <table class="">
                    <tr class="">
                            <x-removeMultiple route="{{route('deleteFrom.OnHand')}}" status="hidden" 
                            toMoveRoute="{{route('moveMultipleFrom.onHand')}}"
                            processing="enabled"
                            cancelReturn="enabled"
                            onHand="disabled"
                            userId="block"
                            > 
                            </x-removeMultiple>
                            <th class="adminTable">ID</th>
                            <th class="adminTable w-20">Image</th>
                            <th class="adminTable">Variation</th>
                            <th class="adminTable">Description</th>
                            <th class="adminTable">Gender</th>
                            <th class="adminTable">Size</th>
                            <th class="adminTable">Price</th>
                            <th class="adminTable w-24">Quantity</th>                                                                       
                            <th class="adminTable w-24 text-center">Action</th>
                    </tr>
                        <tr>
                                <td colspan="10"><hr class="w-full mt-1 mb-3"></td>
                        </tr>
                        <tr>
                            {{-- Filter products  --}}
                                <form  method="get" id="filterOnHandForm">
                                    @csrf
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td>
                                        {{-- filter by id  --}}
                                            <input type="text" name="id" placeholder="ID" class="w-10 h-8 text-xs ">
                                    </td>
                                    <td class="w-12"></td>
                                    <td class="w-40 ">
                                        {{-- by variation --}}
                                            <select name="variation" class="w-32 h-8 text-xs  cursor-pointer">
                                                <option value=""></option>
                                                @foreach(\App\Enums\Variation::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                    </td>
                                    <td class="w-32"></td>
                                    <td class="w-20">
                                        {{-- by gender --}}
                                            <select name="gender" class="w-16 h-8 text-xs  cursor-pointer">
                                                    <option value=""></option>
                                                @foreach(\App\Enums\Gender::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    <td class="w-40">
                                        {{-- by size --}}
                                            <select name="size" class="w-32  h-8 text-xs cursor-pointer">
                                                    <option value=""></option>
                                                @foreach(\App\Enums\ShirtSize::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        {{-- by price --}}
                                    <td class="w-40"><input type="text" name="price" placeholder="Price" class="w-32 h-8 text-xs"></td>                
                                    <td></td>
                                    <td colspan="3" class="text-center w-24">
                                        <button type="submit" class="bg-yellow-500 flex items-center justify-center gap-1 text-xs rounded w-auto py-1 px-2 tracking-wider  hover:opacity-50 text-white cursor-pointer"><ion-icon name="funnel" class="text-white text-md"></ion-icon>FILTER</button></td>
                                </form>
                        </tr>
                        <tbody id="productTableBody">
                            @include('admin.products.onHandPartial')
                            
                        </tbody>
                    </table> 
            </div>
        </div>
      
       
        {{-- This is the add product form --}}
        <div>
            <dialog class=" modal bg-white shadow-lg rounded p-10  w-8/12" id="addProdForm"> 
                <h1 class="font-bold tracking-wide mb-2">ADD PRODUCT</h1>
                <div class=" text-xs font-bold text-yellow-600 text-center" id="successMessage" style="display: none;">Saving Successfully</div>
                <div id="errorMessage" class="text-xs text-red-500 text-center">  </div>
                <form action="" class="flex justify-center  items-start flex-row-reverse" method="POST" id="submitForm">
                    @csrf 
                    {{-- Hidden input thats hold the value of 1 that is equivalent to on hand  --}}
                   {{-- The hidden status/productStatus inputs are gone: they told the
                        server which lifecycle table to write the row into. --}}
                   <div class="flex flex-row items-start flex-wrap">
                     {{-- Choose Variation Type --}}
                        <div class="me-2">
                            <label for="" class="text-xs">Variation*</label> <br>
                                            <select name="variation" class="h-10 w-40 rounded text-sm cursor-pointer">
                                                @foreach(\App\Enums\Variation::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                        </div>
                        {{-- Choose t-shirt gender type --}}
                        <div class="me-2">
                            <label for="" class="text-xs">Gender*</label> <br>
                             <select name="gender" class="h-10 w-40 rounded text-sm cursor-pointer">
                                 @foreach(\App\Enums\Gender::options() as $value => $label)
                                     <option value="{{ $value }}">{{ $label }}</option>
                                 @endforeach
                             </select>
                        </div>
                        {{-- Choose size --}}
                        <div class="me-2">
                            <label for="size" class="text-xs">Size*</label> <br>
                             <select name="size" class="h-10 w-40 rounded text-sm cursor-pointer">
                                 @foreach(\App\Enums\ShirtSize::options() as $value => $label)
                                     <option value="{{ $value }}">{{ $label }}</option>
                                 @endforeach
                             </select>
                        </div> 
                        {{-- Input thep price --}}
                        <div class="me-2">
                            <label for="price" class="text-xs">Price*</label> <br>
                             <input type="number" step="0.01" min="0" name="price" class="h-10 w-40 rounded text-sm" id="price">
                        </div>
                        {{-- input the quantity --}}
                        <div class="me-2">
                            <label for="stock" class="text-xs">Stock*</label> <br>
                             <input type="number" min="0" name="stock" class="h-10 w-40 rounded text-sm" id="stock">
                        </div>
                        {{-- And the description of the product this includes the reason why it's on hand  --}}
                        <div class="me-2">
                            <label for="">Description*</label><br>
                            <textarea name="description" id="desc" cols="50" rows="2" class="text-xs rounded"></textarea>
                       </div>
                   </div>
                   {{-- Image input --}}
                    <div class="flex items-center flex-col">
                        <div class="relative border-2 border-dashed rounded-md me-5 self-center mb-5">
                                <ion-icon name="cloud-upload-outline" class="z-0 absolute absolute-center text-9xl text-gray-400 opacity-20"></ion-icon>
                                <input type="file"  name="image_path" onchange="previewImage(this)"  class="py-20 cursor-pointer opacity-0" >
                                <img src="#" alt="Image Preview" style="display: none; height: 200px;" class="absolute absolute-center bg-white" id="imagePreview" width="400px">
                        </div>
                        <div class="flex flex-wrap gap-1">
                            <button type="button" class="py-1 text-sm bg-blue-700 rounded-sm text-white font-light px-2 hover:opacity-50" id="updateBtn">Update Table</button>
                            <button type="submit" id="submitForm" class="py-1 text-sm bg-orange-600 rounded text-white font-light px-4 hover:opacity-50">Save & Add More</button>
                            <button type="button" id="closeBtn" class="border-2 px-2 py-1 text-sm rounded hover:opacity-50">Cancel</button>
                            <button type="reset" onclick="clearField()" class="text-sm underline absolute bottom-0 right-0 mr-16 pb-4">Clear</button>
                        </div>
                    </div>
                </form>
            </dialog>
        </div>
    </div>
</div>
<x-adminFooter />