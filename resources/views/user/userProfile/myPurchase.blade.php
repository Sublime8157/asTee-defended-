<x-userHeader />
    <div class="bg-white p-5 min-h-full   md:w-8/12 w-full">
        <h3 class="font-bold text-orange-800">My Purchase</h3>
        <h6 class="font-light text-gray-500 text-sm">Manage your Purchase</h6>
        <hr class="mt-4 mb-8">
        <div class="w-full justify-evenly  gap-4flex items-center flex-row">
            <div class="w-full flex justify-between  gap-10 flex-col">
                {{-- product status  --}}
                <ul class=" flex gap-2  flex-row md:items-start items-center justify-evenly w-full">
                    {{-- to pay  --}}
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
                    {{-- to ship --}}
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
                    {{-- to recieve --}}
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
                    {{-- to review --}}
                       <a href="{{ route('product.status', ['status' => 4]) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="chatbox-ellipses-outline" class="md:hidden"></ion-icon>
                        <li class="relative status hover:bg-white {{ Route::currentRouteName() == 'product.status' && request()->status == 4 ? 'border-b border-gray-400' : '' }} text-sm">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-10 md:left-20 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if ($feedBackCount != 0 )
                                    {{$feedBackCount}}
                                @endif
                            </span>
                            <span class="text-xs md:text-base">To Review</span>
                        </li>
                    </a>
                </ul>
                {{-- products --}}
                <div id="products" class="flex-col flex w-full justify-between">
                    @foreach ($product as $item)
                        <div class="flex flex-row gap-4 ">
                            {{-- image --}}
                            <div>
                                <img src="{{ asset('images/' . $item->image_path) }}" alt="" class="md:w-40 w-20 bg-gray-200 rounded p-2 ">
                            </div>
                            <div class="md:text-base text-xs">
                                {{-- details --}}
                                    <p>{{$item->displayDescription}} </p>
                                    <p>{{$item->sizeShirt()}} | {{$item->variationType()}} | {{$item->genderShirt()}}</p>
                                    <p id="price{{$item->id}}">{{$item->price}}</p>
                                    <p>Qty: <span id="quantity{{$item->id}}">{{$item->quantity}}</span></p>
                            </div>
                        </div>
                        <div class="self-end md:text-base text-xs text-orange-700 pe-4">
                            {{-- total --}}
                            @if(request()->status == 4)
                                 <button class="py-1 px-2 text-sm border-orange-500 border rounded" onclick="reviewButton({{$item->id}})">Review</button>
                            @else
                                 <span class="text-black ">Total: ₱</span><span id="totalAmount{{$item->id}}">300.00</span>
                            @endif
                            {{-- dialog for review  --}}
                            <dialog id="feedBackModal{{$item->id}}" class=" w-screen h-screen" > 
                                <div class="rounded w-full px-4 gap-4 h-full bg-gray-100 flex flex-col">
                                    {{-- back button --}}
                                    <div class=" w-full p-2 gap-2 flex items-center " onclick="closeReviewDialog({{$item->id}})">
                                        <ion-icon name="arrow-back-outline" class="text-lg cursor-pointer"></ion-icon> 
                                        <span class="text-sm ">Back</span>
                                    </div>
                                    {{-- product details to review --}}
                                    <div class="bg-gray-200 p-2 rounded">
                                        <div class="flex flex-col gap-2">
                                           <div class="flex-row flex items-center gap-2">
                                            {{-- product details  --}}
                                               <div>
                                                {{-- image  --}}
                                                    <img src="{{ asset('images/' . $item->image_path) }}" alt="" class="md:w-40 w-20 bg-gray-200 rounded  ">
                                               </div>
                                               <div class="flex flex-col gap-1">
                                                {{-- details  --}}
                                                   <span class="md:text-base text-sm text-black font-semibold">{{$item->displayDescription}}</span>
                                                   <div class="flex flex-row text-sm ">
                                                        <span>{{$item->variationType()}}</span>|<span> {{$item->genderShirt()}}</span> | 
                                                        <span>{{$item->sizeShirt()}}</span>
                                                   </div>
                                                   <div class="text-orange-700 text-sm md:text-base">
                                                         ₱{{$item->price}}.00
                                                   </div>
                                               </div>
                                               
                                           </div>
                                           {{-- ratings --}}
                                            <div class="flex flex-col">
                                                    <form action="" id="reviewForm{{$item->id}}">
                                                        @csrf
                                                         {{-- over all  --}}
                                                        <x-ratings id="all{{$item->id}}" font="font-bold" title="Overall Ratings" ratingType="overAll" showOtherRatings="showOtherRatings({{$item->id}}" hide="block" input="starCountAll"> </x-ratings>
                                                        <div id="productServiceRatings{{$item->id}}" class="hidden">
                                                                {{-- product quality --}}
                                                                <x-ratings id="quality{{$item->id}}" font="font-normal"  title="Product Quality " ratingType="quality" input="starCountQuantity" showOtherRatings="" hide="opacity-0"> </x-ratings>
                                                                {{-- service  --}}
                                                                <x-ratings id="service{{$item->id}}" font="font-normal"  title="Seller Service" ratingType="service" input="starCountService" showOtherRatings="" hide="opacity-0"> </x-ratings>
                                                                <textarea name="specify" id="specifyValue{{$item->id}}" cols="30" rows="10" class="hidden"></textarea>
                                                        </div>
                                                        <input type="hidden" value="{{$item->userId}}" name="userId" id="userId{{$item->id}}">
                                                        <input type="hidden" value="{{$item->id}}" name="productId" id="productId{{$item->id}}">
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- please specify --}}
                                    <div class="self-center w-full">
                                        <label class="text-xs md:text-sm">Please Specify (Optional)</label>
                                        <textarea id="specify{{$item->id}}" onkeyup="getTheText({{$item->id}})" class="mt-2 text-sm w-full h-40 rounded" placeholder="What do you think of the quality and services?"></textarea>
                                    </div>
                                    {{-- social media accounts --}}
                                    <div class="p-2 flex flex-col gap-2">
                                        If you have anymore concerns please contact us! 
                                        <div class="flex flex-row items-center gap-2 text-xl   rounded">
                                            <ion-icon name="logo-facebook"></ion-icon>
                                            <ion-icon name="logo-twitter"></ion-icon>
                                            <ion-icon name="logo-instagram"></ion-icon>
                                            <ion-icon name="mail-outline"></ion-icon>
                                        </div>
                                    </div>
                                    {{-- buttons --}}
                                    <div class="h-full flex justify-center py-4 items-end w-full">
                                        <button class="w-full py-4 px-2 text-base bg-blue-700 text-white rounded hover:opacity-70" onclick="submitReview({{$item->id}})">Submit</button>
                                    </div>
                                </div>
                            </dialog>
                        </div>
                        {{-- order recieved button --}}
                        <div class="self-end my-2 {{ Route::currentRouteName() == 'product.status' && request()->status != 3 ? 'hidden' : 'block'}}">
                            <a  onclick="showConfirmationDialog({{$item->id}})" class=" py-1 md:py-2 px-2 md:px-4 text-xs md:text-sm bg-orange-500 cursor-pointer text-white rounded hover:opacity-70">
                                Order Recieved
                            </a>
                            {{-- modal for confirmation --}}
                            <dialog class="modal  w-80 rounded" id="confirmationDialog{{$item->id}}"> 
                               <div class="flex flex-col w-full justify-center items-center  shadow-lg rounded  ">
                                    <div class="p-4 text-sm">
                                        Are you sure you recieved the order?
                                    </div>
                                    <div class="flex flex-row justify-evenly w-full border-t ">
                                        <button class="w-72 border-r  py-1 bg-orange-400 hover:opacity-70 text-white" onclick="orderRecieved({{$item->id}})">Confirm</button>
                                        <button class="px-8 border border-orange-200 hover:opacity-70 closeModal" onclick="closeConfirmationModal({{$item->id}})">No</button>
                                    </div>
                                </div>
                            </dialog>
                            {{-- form for recieving order --}}
                            <form action="{{ route('order.recieved') }}" class="hidden" id="orderRecieved{{$item->id}}" method="POST">
                                @csrf
                                <input type="hidden" name="productId" value="{{$item->id}}">
                                <input type="hidden" name="userId" value="{{$item->userId}}">
                                <input type="hidden" name="amount" value="{{$item->price}}">
                                <input type="hidden" name="quantity" value="{{$item->quantity}}">
                            </form>
                        </div>
                       <hr class="my-2 w-full">
                       {{-- embedded script for computing the total amount  --}}
                       @include('user.userProfile.totalAmount')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
<x-userFooter />