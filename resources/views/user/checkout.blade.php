<x-header />
@if($errors->any())
   @foreach ($errors->all() as $error )
       {{$error}}
   @endforeach
@endif
</div>
    <div class="flex flex-col min-h-screen w-full py-4 justify-start items-center">
          <div class="bg-white h-auto shadow-md rounded w-11/12 md:w-6/12 p-4">
            <a href="{{ url()->previous() }}"><ion-icon name="arrow-back-outline" class="text-lg font-bold hover:-translate-x-0.5"></ion-icon></a>
            <form action="{{ route('confirmCheckout') }}" class="flex flex-col gap-4" method="POST">
                @csrf
                        <h1 class="text-black text-base">Billing Information:</h1> 
                        <hr class="w-full bg-gray-100">
                    <div class="flex-row flex gap-4 text-sm">
                            <div class="flex text-xs flex-col text-gray-500">
                                <h1>Address</h1>
                                <h1>Contact:</h1>
                                <h1>Email</h1>
                                <h1>Full name:</h1>
                            </div>
                        <div class="flex flex-col">
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-80" name="address" value="{{$userInfo->address}}">
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-auto" name="contact" value="{{$userInfo->contact}}">
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-auto" name="email" value="{{$userInfo->email}}">
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
            <div class="flex w-full me-4  justify-end items-end flex-col gap-1">
                <div class=" text-orange-600">
                    <div class="flex flex-row gap-2">
                        <div class="flex flex-col">
                            <span class="tex-xs ">Shipping Fee:</span>
                            <span>Sub Total:</span>
                        </div>
                        <div class="flex flex-col">
                           <div>
                                ₱<input type="text" value="60" placeholder="60" name="shippingFee" class="w-6 text-sm border-none  p-0" id="shippingFee">
                           </div>
                            <div>
                                ₱<input type="text" class=" w-12 border-none text-sm p-0" name="subTotal"  value="{{ $data['total'] }}" id="subTotal">
                                <span class="text-orange-600"></span>
                            </div>
                        </div>
                    </div>
                   <br>
                    Total: ₱<input type="text" class="text-sm w-6 border-none  p-0" name="total" id="total" value=""><span class="text-orange-600">.00</span>
                </div>
                <div class="w-full">
                    <label for="">Mode of Payment </label>
                    <p class="text-xs text-red-500 py-1"><ion-icon name="alert-circle" class=" text-red-500"></ion-icon>Please take note that only users with <a href="/userProfile/myAccount" class="underline text-blue-900 ">verified</a> account are eligible for other <b> Payment Method. </b> </a> If you are already verified disregard this message.</p>
                    <select name="mop" id="" class="w-full border-none rounded">
                        @if($userInfo->verification == 'verified')
                            <option value="cash_on_delivery">Cash On Delivery (COD)</option>
                        @endif
                        <option value="online_payment">Online Payment </option>
                    </select>
                </div>
            </div>
            <div>
                <button class="px-4 py-2 w-full bg-blue-700 rounded text-white text-sm">Submit</button>
            </div>
            </form>
          </div>
    </div>
<script>
    var total = parseFloat($('#shippingFee').val()) + parseFloat($('#subTotal').val()); 
    $('#total').val(total);
</script>
<x-scripts />
