<x-userHeader />
    <div class="bg-white p-5 min-h-full   md:w-8/12 w-full">
        <h3 class="font-bold text-orange-800">My Purchase</h3>
        <h6 class="font-light text-gray-500 text-sm">Manage your Purchase</h6>
        <hr class="mt-4 mb-8">
        <div class="w-full justify-evenly  gap-4flex items-center flex-row">
            <div class="w-full flex justify-between  gap-10 flex-col">
                {{-- product status  --}}
                <ul class=" flex gap-2  flex-row md:items-start items-center justify-evenly w-full">
                    <a href="{{ route('product.status', ['status' => 1]) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="wallet-outline" class="md:hidden"></ion-icon>
                        <li class="status relative  hover:bg-white {{ Route::currentRouteName() == 'product.status' && request()->status == 1 ? 'border-b border-gray-400' : '' }} text-sm ">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-6 md:left-12 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if ($toPayCount != 0 )
                                    {{$toPayCount}}
                                @endif
                            </span><span class="text-xs md:text-sm">To Pay</span>
                        </li>
                    </a>
                      <a href="{{ route('product.status', ['status' => 2]) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="cube-outline" class="md:hidden"></ion-icon>
                        <li class="status relative hover:bg-white {{ Route::currentRouteName() == 'product.status' && request()->status == 2 ? 'border-b border-gray-400' : '' }} text-sm ">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-8 md:left-12 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if ($toShipCount != 0 )
                                    {{$toShipCount}}
                                @endif
                            </span>
                            <span class="text-xs md:text-sm">To Ship</span>
                        </li>
                    </a>
                       <a href="{{ route('product.status', ['status' => 3]) }}" class="flex justify-center  flex-col items-center ">
                        <img src="{{ asset('images/toRecieveIcon.png') }}" alt="" width="20px" class="md:hidden" style="margin-bottom: 1px;">
                        <li class="status relative hover:bg-white {{ Route::currentRouteName() == 'product.status' && request()->status == 3 ? 'border-b border-gray-400' : '' }} text-sm ">
                            <span class="font-bold absolute bottom-8 md:bottom-4 left-10 md:left-20 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if ($toRecieveCount != 0 )
                                    {{$toRecieveCount}}
                                @endif
                            </span>
                            <span class="text-xs md:text-base">To Recieve</span>
                        </li>
                    </a>
                       <a href="{{ route('product.status', ['status' => 4]) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="chatbox-ellipses-outline" class="md:hidden"></ion-icon>
                        <li class="relative status hover:bg-white {{ Route::currentRouteName() == 'product.status' && request()->status == 4 ? 'border-b border-gray-400' : '' }} text-sm">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-10 md:left-20 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if ($feedBackCount != 0 )
                                    {{$feedBackCount}}
                                @endif
                            </span>
                            <span class="text-xs md:text-base">Feedback</span>
                        </li>
                    </a>
                </ul>
                {{-- products --}}
                <div id="products" class="flex-col flex w-full justify-between">
                    @foreach ($product as $item)
                        <div class="flex flex-row gap-4 ">
                            <div>
                                <img src="{{ asset('images/' . $item->image_path) }}" alt="" class="md:w-40 w-20 bg-gray-200 rounded p-2 ">
                            </div>
                            <div class="md:text-base text-xs">
                                    <p>{{$item->displayDescription}} </p>
                                    <p>{{$item->sizeShirt()}} | {{$item->variationType()}} | {{$item->genderShirt()}}</p>
                                    <p>{{$item->price}}</p>
                                    <p>Qty: {{$item->quantity}}</p>
                            </div>
                        </div>
                        <div class="self-end md:text-base text-xs text-orange-700 ">
                            <span class="text-black">Total:</span> 300.00
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
<x-userFooter />