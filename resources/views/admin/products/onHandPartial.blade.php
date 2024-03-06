@foreach($filterOnHand as $product)
<tr class="text-xs">
    <td>{{$product->id}}</td>
    <td class="ps-2">
        {{-- pass the productId on revealImage  function --}}
        <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="50px" class="cursor-pointer" 
        onclick="revealImage('{{ $product->id}}')">
        {{-- change the the imageDialog to imageDialog + id --}}
        <dialog class="" id="imageDialog{{ $product->id }}"> 
            <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="auto" class="cursor-pointer">
        </dialog>
    </td> 
    <td class="ps-2">{{$product->variationType()}}</td>
    <td class="ps-2">{{$product->description}}</td>
    <td class="ps-2">{{$product->genderShirt()}}</td>
    <td class="ps-2">{{$product->sizeShirt()}}</td>
    <td class="ps-2">{{$product->price}}</td>
    <td class="ps-2">{{$product->quantity}}</td>       
    <td>
        <form action="{{ route('product.remove', $product->id) }}" id="removeProduct{{ $product->id }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <button type="button" onclick="showMenus({{ $product->id }})" >
            <div class="relative z-20">
                <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $product->id }}">
                    
                    {{-- <a onclick="unblockUser({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs">Block</a> --}}
                  {{-- set the product id to removeUser parameter to pass it to adminScripts--}}

                    <a onclick="removeProduct({{ $product->id }})" class="hover:bg-gray-400 px-4 text-xs">Remove</a>
                    
                </div>
            </div>
        </button>
    </td>
</tr>
<tr>
     <td colspan="10"><hr class="w-full my-2"></td>
</tr>

@endforeach