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
        <td class="text-center ps-2 w-32 "> <textarea name="" id="" cols="20" rows="2" placeholder="{{$product->description}}" style=" font-size: 10px" class="border-none " disabled></textarea></td>
        <td class="text-center ps-2">{{$product->genderShirt()}}</td>
        <td class="text-center ps-2">{{$product->sizeShirt()}}</td>
        <td class="text-center ps-2">{{$product->total}}</td>
        @if ($product->reason == 7)
         <td class="text-center ps-2">{{$product->specify}}</td>
        @else
            <td class="text-center ps-2">{{$product->reason()}}</td>
        @endif
        <td class="text-center">{{$product->created_at}}</td>
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