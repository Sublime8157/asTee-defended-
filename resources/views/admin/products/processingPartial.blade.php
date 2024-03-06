@foreach($filterOnProcess as $product) 
           <tr class=" text-xs">
                <td class="ps-2">{{$product->id}} </td>
                {{-- Get the image path  --}}
                <td class="ps-2">
                    {{-- pass the product id on revealImage  function --}}
                    <img src="{{ asset('storage/images/' . $product->image_path ) }}" alt="Product Image" width="50px" class="cursor-pointer" 
                    onclick="revealImage('{{ $product->id}}')">
                    {{-- change the the imageDialog ooto imageDialog + id --}}
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
                <td class="ps-2">{{$product->producStats()}}</td>
               
           </tr>
           <tr>
                <td colspan="10"> <hr class="w-full my-2"></td>
           </tr>
@endforeach