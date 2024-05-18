@extends('components.header')
@section('docu', 'Return & Cancel Products')
@section('page','RETURN & CANCEL ')
<x-header />
<x-nav />
<x-notification />
<div class="p-3">
    {{ $filterReturnCancel->links('pagination::simple-tailwind') }}
</div>
<div class="bg-white my-5 mx-4">
    <div class="">
        <x-sortingProducts sortProduct="sortCancelReturnProduct" orderProduct="sortCancelReturnProduct"></x-sortingProducts>
    </div>
    <div class="mx-10 pb-10 flex justify-center">
        <table class="">
           <tr class="">
                <x-removeMultiple route="{{route('deleteFrom.cancel')}}" status="hidden" 
                toMoveRoute="{{route('moveMultipleFrom.cancel')}}" processing="enabled" cancelReturn="disabled" onHand="enabled" userId="hidden"> </x-removeMultiple>                         
                <th class="adminTable">ID</th>
                <th class="adminTable w-20">User Id</th>
                <th class="adminTable w-20">Image</th>
                <th class="adminTable">Variation</th>
                <th class="adminTable">Description</th>   
                <th class="adminTable">Gender</th>
                <th class="adminTable">Size</th>      
                <th class="adminTable w-24">Total</th>
                <th class="adminTable w-20">Reason</th>                                                               
                <th class="adminTable w-24">Action</th>
           </tr>
           <tr>
                <td colspan="10"><hr class="w-full mt-1 mb-3"></td>
           </tr>
           <tr>
            <form id="filterReturnCancelForm"  method="get">
                <td></td>
                <td></td>
                <td class="w-12">
                    {{-- filter by id  --}}
                        <input type="text" name="id" placeholder="ID" class="w-10 h-8 text-xs ">
                </td>
                <td><input type="text" name="userId" placeholder="User Id" class="w-20 h-8 text-xs "></td>
                <td class="w-12"></td>
                <td class="w-40 ">
                    {{-- by variation --}}
                        <select name="variation_id" id="" class="w-32 h-8 text-xs  cursor-pointer">    
                                <option value=" "></option>                        
                                <option value="1">Couple Shirt</option>
                                <option value="2">Solo Shirt</option>
                                <option value="3">Family Shirt</option>
                                <option value="4">Kids Wear</option>                              
                        </select>
                    </td>
                <td class="w-32"></td>
                <td class="w-20">
                    {{-- by gender --}}
                        <select name="gender" id="" class="w-16 h-8 text-xs  cursor-pointer">
                            <option value=" "></option>  
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Unisex</option>
                        </select>
                    </td>
                <td class="w-40">
                    {{-- by size --}}
                        <select name="size" class="w-32  h-8 text-xs cursor-pointer" id="">
                            <option value=" "></option>  
                            <option value="1">XS</option>
                            <option value="2">Small</option>
                            <option value="3">Medium</option>
                            <option value="4">Large</option>
                            <option value="5">XL</option>
                            <option value="6">2XL</option>
                            <option value="7">3XL</option>
                        </select>
                    </td>
                    {{-- by price --}}
                <td></td>             
                <td></td>
                <td colspan="3" class=" w-24">
                    <button type="submit" class="bg-yellow-500 flex items-center justify-center gap-1 text-xs rounded w-auto py-1 px-2 tracking-wider  hover:opacity-50 text-white cursor-pointer"><ion-icon name="funnel" class="text-white text-md"></ion-icon>FILTER</button></td>
                </td>
            </form>
           </tr>
           <tbody id="productTableBody">
            {{-- the variable onHandProducts is from controller and assigned it to a product variable to query in product table  --}}
            {{-- Take note that the words after $product is a table name in product table from database --}}
            {{-- We then loop to the database  and each data in product table these code below will execute  --}}
            {{-- The  variationType() is a function from model that  convert the number into value--}}
            @foreach($filterReturnCancel as $product) 
            <tr class=" text-xs px-2">
                    <td></td>
                    <td><input type="checkbox" name="" id="" value="{{$product->id}}" class="checkBox"></td>
                    <td class="text-center ps-2">{{$product->id}} </td>
                    <td class="text-center w-10">{{$product->userId}}</td>
                    {{-- Get the image path  --}}
                    <td class="text-center ps-2">
                        {{-- pass the product id on revealImage  function --}}
                        <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="50px" class="cursor-pointer" 
                        onclick="revealImage('{{ $product->id}}')">
                        {{-- change the the imageDialog ooto imageDialog + id --}}
                        <dialog class="" id="imageDialog{{ $product->id }}"> 
                            <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="auto" class="cursor-pointer">
                        </dialog>
                    </td>                                 
                    <td class="text-center ps-2">{{$product->variationType()}}</td>
                    <td class="text-center ps-2 w-60 "> <textarea name="" id="" cols="20" rows="2" placeholder="{{$product->description}}" style=" font-size: 10px" class="border-none " disabled></textarea></td>
                    <td class="text-center ps-2">{{$product->genderShirt()}}</td>
                    <td class="text-center ps-2">{{$product->sizeShirt()}}</td>
                    <td class="text-center ps-2">{{$product->total}}</td>
                    @if ($product->reason == 7)
                     <td class="text-center ps-2">{{$product->specify}}</td>
                    @else
                        <td class="text-center ps-2">{{$product->reason()}}</td>
                    @endif
                  
                    <td class="text-center">
                        <form action="{{ route('cancelReturn.remove', $product->id) }}" method="POST" id="removeProduct{{ $product->id }}">
                            @csrf
                            @method('DELETE');
                        </form>
                        <dialog id="editProductDialog{{$product->id}}" class="w-8/12 p-5 rounded">
                            <x-editForm route="edit.cancelReturn" :id="$product->id" 
                                variation="{{$product->variation_id}}" 
                                gender="{{$product->gender}}"
                                size="{{$product->size}}"
                                price="{{$product->price}}"
                                quantity="{{$product->quantity}}"
                                description="{{$product->description}}"
                                img="{{$product->image_path}}"> </x-editForm>
                        </dialog>
                        {{-- move product dialog with form  --}}
                        <dialog id="moveProductDialog{{$product->id}}">
                            <x-moveProduct  route="move.cancelReturnProduct" :id="$product->id"
                                selectId="moveProductOption{{$product->id}}"
                                onchangeFunction="moveProductOption({{$product->id}})"
                                option1="On Hand"
                                option2="Processing"
                                :cancel="false"
                                :onHand="false"> 
                            </x-moveProduct>
                        </dialog>
                        <button type="button" onclick="showMenus({{ $product->id }})" >
                            <div class="relative z-20">
                                <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                                <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $product->id }}">
                                   {{-- edit the product info  --}}
                                   <a onclick="editProduct({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs" id="editProd">Edit</a>
                                   {{-- move a product  --}}
                                   <a onclick="moveProduct({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs" id="editProd">MoveTo</a>
                                    {{-- remove a product --}}
                                    <a onclick="removeProduct({{ $product->id }})" class="hover:bg-gray-400 px-4 text-xs">Remove</a>
                                    
                                </div>
                            </div>
                        </button>
                    </td>
            </tr>          
            <tr>
                <td colspan="10"> <hr class="w-full"></td>
            </tr>
            @endforeach
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
        <form action="" class="flex justify-center  items-start flex-row-reverse" method="POST" id="submitFormCancelReturn">
            @csrf 
            {{-- Hidden input thats hold the value of 1 that is equivalent to on hand  --}}
           <div class="hidden">
            <input type="text" name="status" value="3" id="status">
            <input type="text" name="productStatus" value="4" id="productStatus">
           </div>                    
           <div class="flex flex-row items-start flex-wrap">
             {{-- Choose Variation Type --}}
                <div class="me-2">
                    <label for="" class="text-xs">Variation*</label> <br>
                     <select name="variation_id" id="variation_id" class="h-10 w-40 rounded text-sm cursor-pointer">
                        <option value="1">Couple Shirt</option>
                        <option value="2">Solo Shirt</option>
                        <option value="3">Family Shirt</option>
                        <option value="4">Kids Wear</option>
                    </select>
                </div>
                {{-- Choose t-shirt gender type --}}
                <div class="me-2">
                    <label for="" class="text-xs">Gender*</label> <br>
                     <select name="gender" id="gender" class="h-10 w-40 rounded text-sm cursor-pointer">
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Unisex</option>
                    </select>
                </div>
                {{-- Choose size --}}
                <div class="me-2">
                    <label for="size" class="text-xs">Size*</label> <br>
                     <select name="size" id="size" class="h-10 w-40 rounded text-sm cursor-pointer">
                        <option value="1">XS</option>
                        <option value="2">Small</option>
                        <option value="3">Medium</option>
                        <option value="4">Large</option>
                        <option value="5">XL</option>
                        <option value="6">2XL</option>
                        <option value="7">3XL</option>
                    </select>
                </div> 
                {{-- Input thep price --}}
                <div class="me-2">
                    <label for="price" class="text-xs">Price*</label> <br>
                     <input type="text" name="price" class="h-10 w-40 rounded text-sm" id="price">
                </div>
                {{-- input the quantity --}}
                <div class="me-2">
                    <label for="quantity" class="text-xs">Quantity*</label> <br>
                     <input type="text" name="quantity" class="h-10 w-40 rounded text-sm" id="quantity">
                </div>
                <div class="me-2">
                    <label for="" class="text-xs">User ID*</label> <br>
                     <input type="text" name="userId" class="h-10 w-40 rounded text-sm" id="userId">
                </div>
                {{-- And the description of the product this includes the reason why it's on hand  --}}
                <div class="me-2">
                    <label for="">Description*</label><br>
                    <textarea name="description" id="desc" cols="50" rows="2" class="text-xs rounded"></textarea>
               </div>
               {{-- Reason why it was return --}}
               <div class="me-2">
                    <label for="">Reason*</label><br>
                        <select name="reason" id="reason" class="w-40 text-xs text-center cursor-pointer">
                            <option value="1">Wrong Product</option> 
                            <option value="2">Different Color</option> 
                            <option value="3">Wrong Design</option> 
                            <option value="4">Reason 1 </option> 
                            <option value="5">Reason 2</option> 
                            <option value="6">Reason 3</option> 
                            <option value="7">Other</option> 
                        </select>
                </div>
                <div class="me-2 hidden" id="specify">
                    <label for="">Specify</label> <br>
                    <textarea name="specify" id="specify" cols="50" rows="2" class="text-xs rounded"></textarea>
                </div>
           </div>
           {{-- Image input --}}
           <div class="flex items-center flex-col">
            <div class="relative border-2 border-dashed rounded-md me-5 self-center mb-5">
                <ion-icon name="cloud-upload-outline" class="z-0 absolute absolute-center text-9xl text-gray-400 opacity-20"></ion-icon>
                <input type="file" name="image_path" onchange="previewImage(this)" class="py-20 cursor-pointer opacity-0">
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