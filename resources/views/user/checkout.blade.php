<x-header />
<div class="text-center mt-2 ">
@if($errors->any())
   @foreach ($errors->all() as $error )
       {{$error}}
   @endforeach
@endif
</div>
    <div class="flex flex-col min-h-screen w-full bg-gray-100 py-4 justify-center items-center">
          <div class="bg-white h-auto shadow-md rounded w-11/12 md:w-6/12 p-4">
            <form action="{{ route('confirmCheckout') }}" class="flex flex-col gap-4" method="POST">
                @csrf
                        <h1 class="text-black text-base">Billing Information:</h1>
                    <div class="flex-row flex gap-4 text-sm">
                            <div class="flex text-xs flex-col text-gray-500">
                                <h1>Address</h1>
                                <h1>Full name:</h1>
                                <h1>Contact:</h1>
                            </div>
                        <div class="flex flex-col">
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-80" name="address" value="{{$userInfo->address}}">
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-auto" name="contact" value="{{$userInfo->contact}}">
                                <span class="text-gray-400 text-xs"> {{$userInfo->fname}} {{$userInfo->mname}} {{$userInfo->lname}}</span> 
                        </div>
                    </div>
                    <input type="hidden" value="{{ $data['userId'] }}" name="userId">
            @foreach ($products as $productToCheckout)
                <input type="hidden" value="{{ $productToCheckout->id }}" name="productId[]">
                <div class="flex flex-row gap-2">
                    <input type="hidden" name="image_path[]" value="{{$productToCheckout->image_path}}">
                    <img src="{{ asset('storage/images/' . $productToCheckout->image_path) }}" alt="Product Image" class="w-36">
                    <div class="flex flex-col gap-2">
                       <div>
                        <input type="hidden" name="description[]" value="{{$productToCheckout->description}}">
                        <p class="text-sm md:text-base ">{{  $productToCheckout->displayDescription }}</p>
                       </div>
                       <div class="text-xs md:text-sm">
                            <input type="hidden" value="{{$productToCheckout->variation_id}}"  name="variation_id[]">
                            <input type="hidden" value="{{$productToCheckout->gender}}" name="gender[]">
                            <input type="hidden" value="{{$productToCheckout->size}}" name="size[]">
                            <span class="text-gray-400">{{ $productToCheckout->variationType() }}</span> | 
                            <span class="text-gray-400">{{ $productToCheckout->genderShirt() }}</span> | 
                            <span class="text-gray-400">{{ $productToCheckout->sizeShirt() }}</span>
                       </div>
                       <div class="flex justify-between flex-row-reverse">
                            {{-- check if the array is empty  --}}
                            @php
                            $quantities = $quantities ?? [];
                            
                            @endphp
                            <div class="flex flex-col font-bold relative ">
                            @foreach ($quantities as $quantity)
                                @if ($quantity['id'] == $productToCheckout->id)
                                    <span class="text-xs absolute right-5 top-1">x</span>
                                    <input type="text" value="{{ $quantity['quantity'] }}" name="quantity[]" class="w-8 text-center p-none text-sm h-6 border-none " >
                                    @php
                                    $found = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if(!isset($found))
                                    <span class="text-xs absolute right-5 top-1">x</span>
                                    <input type="text" value="1" name="quantity[]" class="w-8 text-center p-none text-sm h-6 border-none " >
                            
                            @endif
                            </div>
                            <div>
                                <input type="hidden" name="price[]" value="{{$productToCheckout->price}}">
                                <p class="text-base text-orange-700 ">₱{{ $productToCheckout->price }}</p>
                            </div>
                       </div>
                    </div>
                </div>
                <hr class="w-full ">
            @endforeach
            <div class="flex me-4 justify-end items-center flex-row gap-4">
                <div class=" text-orange-600">
                    Total: ₱<input type="text" class=" w-6 border-none  p-0" name="total" id="" value="{{ $data['total'] }}"><span class="text-orange-600">.00</span>
                </div>
            </div>
            <div>
                <button class="px-4 py-2 w-full bg-blue-700 rounded text-white text-sm">Submit</button>
            </div>
            </form>
          </div>
    </div>
<x-scripts />