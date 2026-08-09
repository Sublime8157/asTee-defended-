@foreach($products as $product)
<tr class="text-xs">
    <td></td>
    <td><input type="checkbox" value="{{ $product->id }}" class="checkBox"></td>
    <td class="text-center">{{ $product->id }}</td>
    <td class="ps-2">
        <img src="{{ $product->image_url }}" alt="{{ $product->shortDescription }}" width="50px" class="cursor-pointer"
        onclick="revealImage('{{ $product->id }}')">
        <dialog id="imageDialog{{ $product->id }}">
            <img src="{{ $product->image_url }}" alt="{{ $product->shortDescription }}" width="auto" class="cursor-pointer">
        </dialog>
    </td>
    <td class=" text-center">{{ $product->variation->label() }}</td>
    <td class="text-center ps-2 w-60 "><textarea cols="20" rows="2" placeholder="{{ $product->description }}" style="font-size: 10px" class="border-none " disabled></textarea></td>
    <td class="text-center">{{ $product->gender->label() }}</td>
    <td class="text-center">{{ $product->size->label() }}</td>
    <td class="text-center">{{ $product->price }}</td>
    <td class="text-center">{{ $product->stock }}</td>
    <td class="text-center">
        {{-- remove product form --}}
        <form action="{{ route('product.remove', $product->id) }}" id="removeProduct{{ $product->id }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
        {{-- edit product dialog with form   --}}
        <dialog id="editProductDialog{{ $product->id }}" class="w-8/12 p-5 rounded">
            <x-editForm route="edit.Product" :product="$product" />
        </dialog>
        {{-- Sell to a named customer. This was "move to processing", which
             copied the row into another table and deleted it here — so the
             stock count left the catalog however many were bought. --}}
        <dialog id="moveProductDialog{{ $product->id }}" class="rounded">
            <form action="{{ route('move.Product', ['id' => $product->id]) }}" method="POST" class="flex items-center flex-col justify-center rounded px-4 py-2">
                @csrf
                <label for="userId" class="text-xs">Customer ID</label>
                <input type="number" name="userId" class="w-auto text-xs text-center h-8 mb-1" value="{{ old('userId') }}" required>
                <label for="quantity" class="text-xs">Quantity</label>
                <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-auto text-xs text-center h-8 mb-2" required>
                <button type="submit" class="text-sm text-white rounded px-2 py-1 w-full" style="background-color: #ff8906">Create order</button>
            </form>
        </dialog>
        {{-- button for showing the menu for edit and remove --}}
        <button type="button" onclick="showMenus({{ $product->id }})" >
            <div class="relative z-20">
                <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $product->id }}">
                    <a onclick="editProduct({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs">Edit</a>
                    <a onclick="moveProduct({{ $product->id }})" class="hover:bg-gray-400 px-6 text-xs">Sell</a>
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
