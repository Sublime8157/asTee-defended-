<x-header />
@if($errors->any())
   @foreach ($errors->all() as $error )
       {{$error}}
   @endforeach
@endif
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
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-80" name="address" value="{{ $user->address }}">
                                <input type="text" class="text-xs text-gray-400 border-none text-left p-0 w-auto" name="contact" value="{{ $user->contact }}">
                                <span class="text-gray-400 text-xs">{{ $user->email }}</span>
                                <span class="text-gray-400 text-xs">{{ $user->fullName() }}</span>
                        </div>
                    </div>

                    {{-- The only thing this form sends about the basket is which
                         products are in it. Description, variation, gender, size,
                         price, quantity and the order total were all hidden or
                         text inputs, and price and total went to the database
                         unchecked. Everything below is display; the server reads
                         it back from products and cart_items. --}}
                    <input type="hidden" name="items" value="{{ $cartItems->pluck('product_id')->implode(',') }}">

            @foreach ($cartItems as $item)
                <div class="flex flex-row gap-2">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->shortDescription }}" class="w-36">
                    <div class="flex flex-col gap-2">
                       <div>
                        <p class="text-sm md:text-base ">{{ $item->product->shortDescription }}</p>
                       </div>
                       <div class="text-xs md:text-sm">
                            <span class="text-gray-400">{{ $item->product->variation->label() }}</span> |
                            <span class="text-gray-400">{{ $item->product->gender->label() }}</span> |
                            <span class="text-gray-400">{{ $item->product->size->label() }}</span>
                       </div>
                       <div class="flex justify-between flex-row-reverse">
                            <div class="flex flex-col font-bold">
                                <span class="text-sm">x {{ $item->quantity }}</span>
                            </div>
                            <div>
                                <p class="text-base text-orange-700 ">₱{{ $item->product->price }}</p>
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
                        <div class="flex flex-col text-right">
                            <span>₱{{ number_format(\App\Services\OrderService::SHIPPING_FEE, 2) }}</span>
                            <span>₱{{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                   <br>
                    Total: ₱{{ number_format($subtotal + \App\Services\OrderService::SHIPPING_FEE, 2) }}
                </div>
                <div class="w-full">
                    <label for="">Mode of Payment </label>
                    <p class="text-xs text-red-500 py-1"><ion-icon name="alert-circle" class=" text-red-500"></ion-icon>Please take note that only users with <a href="/userProfile/myAccount" class="underline text-blue-900 ">verified</a> account are eligible for other <b> Payment Method. </b> If you are already verified disregard this message.</p>
                    <select name="payment_method" class="w-full border-none rounded">
                        @if($user->hasVerifiedId())
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
<x-scripts />
