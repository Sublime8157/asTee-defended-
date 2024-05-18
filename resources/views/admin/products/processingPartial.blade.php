@foreach($filterOnProcess as $product) 
<tr class=" text-xs ">
     <td></td>
     <td><input type="checkbox" name="" id="" value="{{$product->id}}" class="checkBox"></td>
 {{-- product Id --}}
     <td class="text-center ps-2">{{$product->id}} </td>
     {{-- User Id --}}
     <td class="text-center ps-2 w-20">{{$product->userId}} </td>
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
     <td class="text-center ps-2">
         <span id="status{{$product->id}}">{{$product->producStats()}}</span>
         <ion-icon name="create-outline" class="font-bold text-sm cursor-pointer" onclick="editStatus({{ $product->id }})"></ion-icon>
     </td>
     {{-- settings  --}}
     <td class="text-center">
         <form action="{{ route('productProcess.remove', $product->id) }}" method="POST" id="removeProduct{{$product->id}}">
             @csrf
             @method('DELETE')
         </form>
         {{-- dialog for editing a product --}}
         <dialog id="editProductDialog{{$product->id}}" class="w-8/12 p-5 rounded">
             <x-editForm route="productProcess.edit" :id="$product->id" 
                 variation="{{$product->variation_id}}" 
                 gender="{{$product->gender}}"
                 size="{{$product->size}}"
                 price="{{$product->price}}"
                 quantity="{{$product->quantity}}"
                 description="{{$product->description}}"
                 img="{{$product->image_path}}"> </x-editForm>
         </dialog>
         {{-- dialog for moving a product --}}
         <dialog id="moveProductDialog{{$product->id}}">       
             <x-moveProduct  route="move.processProduct" :id="$product->id" 
                 selectId="moveProductOption{{$product->id}}"
                 onchangeFunction="moveProductOption({{$product->id}})"
                 option1="On Hand"
                 option2="Return Cancel"
                 inputTypes="prodIdInput{{$product->id}}"
                 :cancel="true"> 
             </x-moveProduct>
         </dialog>
         {{-- dialog for editing a product status  --}}
         <dialog id="prodStatus{{$product->id}}" class="p-5">
               <form id="updateStatusForm{{$product->id}}" action="{{route('update.status', $product->id)}}" method="POST" class="text-center">
                     @csrf
                     @method('PATCH')
                     <select name="productStatus" id="updateStatusSelect{{$product->id}}" class="text-xs text-center w-full mb-2">
                         <option value="1">To Pay</option>
                         <option value="2">To Ship</option>
                         <option value="3">To Recieve</option>
                         <option value="4">To Review</option>
                         <option value="5">To Cancel</option>
                     </select>
                     <button id="updateStatusBtn{{$product->id}}" type="button" class="text-sm text-white  rounded px-2 py-1 w-full" style="background-color: #ff8906">Update</button>
               </form>
         </dialog>
         <button type="button" onclick="showMenus({{ $product->id }})" >
             <div class="relative z-20">
                 <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                 <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $product->id }}">
                     
                     {{-- edit a product --}}
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
<script src="{{ asset('js/adminScripts.js') }}"></script>