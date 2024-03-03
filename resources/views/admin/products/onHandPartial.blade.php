@foreach($filterOnHand as $product)
<tr class="text-xs">
     <td>{{$product->id}}</td>
     <td class="ps-2">
         {{-- pass the productId on revealImage  function --}}
         <img src="{{ asset('images/' . $product->image_path ) }}" alt="Product Image" width="50px" class="cursor-pointer" 
         onclick="revealImage('{{ $product->id}}')">
         {{-- change the the imageDialog to imageDialog + id --}}
         <dialog class="" id="imageDialog{{ $product->id }}"> 
             <img src="{{ asset('images/' . $product->image_path ) }}" alt="Product Image" width="auto" class="cursor-pointer">
         </dialog>
     </td> 
     <td class="ps-2">{{$product->variationType()}}</td>
     <td class="ps-2">{{$product->description}}</td>
     <td class="ps-2">{{$product->genderShirt()}}</td>
     <td class="ps-2">{{$product->sizeShirt()}}</td>
     <td class="ps-2">{{$product->price}}</td>
     <td class="ps-2">{{$product->quantity}}</td>       
</tr>
<tr>
 <td colspan="10"><hr class="w-full my-2"></td>
</tr>
@endforeach