@foreach($userCart as $userCart)
<tr class="item border-1 border-orange-300  flex items-center  py-4 px-8">     
    {{-- Product Description --}}
    <td class="w-80 flex flex-row items-center">
        <div class="me-2">
            <input type="checkbox" name="" id="">
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
        <form action="" class="removeCart" id="removeItemForm{{$userCart->id}}" method="POST">
            @csrf
            <input type="hidden" value="{{$userCart->id}}" name="id">
            @method('DELETE')
            <button type="submit">Remove</button>
        </form>
    </td>
</tr>
<tr>
    <td colspan="5">
        <hr class=" border-gray-200">
    </td>
</tr>
@endforeach