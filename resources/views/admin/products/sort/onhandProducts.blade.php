@foreach($productData as $product)
<tr class="text-xs">
    <td></td>
    <td><input type="checkbox" name="" id="" value="{{$product->id}}" class="checkBox"></td>
    <td class="text-center">{{$product->id}}</td>
    <td class="ps-2">
        {{-- pass the productId on revealImage  function --}}
        <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="50px" class="cursor-pointer" 
        onclick="revealImage('{{ $product->id}}')">
        {{-- change the the imageDialog to imageDialog + id --}}
        <dialog class="" id="imageDialog{{ $product->id }}"> 
            <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="auto" class="cursor-pointer">
        </dialog>
    </td> 
    <td class=" text-center">{{$product->variationType()}}</td>
    <td class="text-center ps-2 w-60 "> <textarea name="" id="" cols="20" rows="2" placeholder="{{$product->description}}" style=" font-size: 10px" class="border-none " disabled></textarea></td>
    <td class="text-center">{{$product->genderShirt()}}</td>
    <td class="text-center">{{$product->sizeShirt()}}</td>
    <td class="text-center">{{$product->price}}</td>
    <td class="text-center">{{$product->quantity}}</td>       
    <td class="text-center">
        {{-- remove product form --}}
        <form action="{{ route('product.remove', $product->id) }}" id="removeProduct{{ $product->id }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
        {{-- edit product dialog with form   --}}                                   
        <dialog id="editProductDialog{{$product->id}}" class="w-8/12 p-5 rounded">
            <x-editForm route="edit.Product" :id="$product->id" 
                variation="{{$product->variation_id}}" 
                gender="{{$product->gender}}"
                size="{{$product->size}}"
                price="{{$product->price}}"
                quantity="{{$product->quantity}}"
                description="{{$product->description}}"
                img="{{$product->image_path}}"> </x-editForm>
        </dialog>
        {{-- move product dialog with form  --}}
        <dialog id="moveProductDialog{{$product->id}}" class="rounded">
            <x-moveProduct  route="move.Product" :id="$product->id" 
                selectId="moveProductOption{{$product->id}}"
                onchangeFunction="moveProductOption({{$product->id}})"
                inputTypes="prodIdInput{{$product->id}}"
                option1="Processing"
                option2="Cancel Return"
                inputId="block"
                :cancel="true"
                > 
            </x-moveProduct>
        </dialog>
        {{-- button for showing the menu for edit and remove --}}
        <button type="button" onclick="showMenus({{ $product->id }})" >
            <div class="relative z-20">
                <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                {{-- menus --}}
                <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $product->id }}">
                    {{-- edit the product info  --}}
                    <a onclick="editProduct({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs" id="editProd">Edit</a>
                    {{-- move a product  --}}
                    <a onclick="moveProduct({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs" id="editProd">MoveTo</a>
                    {{-- remove a product   --}}
                    <a onclick="removeProduct({{ $product->id }})" class="hover:bg-gray-400 px-4 text-xs">Remove</a>
                    
                </div>
            </div>
        </button>
    </td>
</tr>
<tr>
    {{-- Horizontal line  --}}
     <td colspan="10"><hr class="w-full my-2"></td>
</tr>             

@endforeach