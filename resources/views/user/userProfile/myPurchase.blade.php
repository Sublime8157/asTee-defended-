<x-userHeader /> 
<div class="absolute  top-0 bg-blue-700   text-center w-full" id="thankYouNotif">
    @if(session()->has('Success'))
        <p class="py-2 text-white text-sm" id="successMessage">{{ @session()->get('Success') }}</p>
    @endif
   @if($errors->any()) 
    {{ $errors->first() }}
   @endif
</div>
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
                                <img src="{{ asset('storage/images/' . $item->image_path) }}" alt="" class="md:w-40 w-20 bg-gray-200 rounded p-2 ">
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
                            {{-- check if current the url is on toreview or 4  replace the total to review button if true   --}}
                            @if(request()->status == 4)
                            {{-- review button in to review tab  --}}
                                 <button class="py-1 px-2 text-sm border-orange-500 border rounded" onclick="reviewButton({{$item->id}})">Review</button>
                            @else
                            {{-- total --}}
                                 <span class="text-black ">Total: ₱</span><span>{{$item->total}}</span>
                            @endif
                            {{-- cancel button for to pay   --}}
                            <div class=" py-1 {{ Route::currentRouteName() == 'product.status' && request()->status !=1 ? 'hidden' : 'block' }} ">
                                {{-- cancel button that show the dialog  --}}
                                <a onclick="showCancelForm({{$item->id}})" class="cursor-pointer py-1 px-2 border border-orange-600 rounded text-sm hover:bg-orange-600 hover:text-white ">
                                    Cancel Order
                                </a>
                                {{-- dialog for canceling  --}} 
                                <dialog id="cancelDialog{{$item->id}}" class="bg-inherit w-screen h-screen rounded-sm">
                                    <div class="flex flex-col bg-white h-full">
                                        {{-- back button  --}}
                                        <div class=" w-full p-2 gap-2 flex items-center " onclick="closeCancelDialog({{$item->id}})">
                                            <ion-icon name="arrow-back-outline" class="text-lg cursor-pointer"></ion-icon> 
                                            <span class="text-sm ">Back</span>
                                        </div>
                                        {{-- product details to cancel --}}
                                        <div class="w-full flex justify-between h-full flex-col">
                                            <div class="flex-col flex gap-4  p-2 md:p-4 ">
                                                <div class="flex flex-row bg-gray-100  p-4  rounded gap-2">
                                                    <div>
                                                        <img src="{{ asset('storage/images/' . $item->image_path) }}" alt="Product Image" width="100px">
                                                    </div>
                                                    <div class="flex flex-col w-full gap-2">
                                                        <div>
                                                            <p class="text-black">{{$item->displayDescription}}</p>
                                                        </div>
                                                        <div class="text-gray-600 flex flex-row ">
                                                            <span>{{$item->variationType()}}</span> | 
                                                            <span>{{$item->genderShirt()}}</span> | 
                                                            <span>{{$item->sizeShirt()}}</span> 
                                                        </div>
                                                        <div>
                                                            <span class="font">Qty: <span>{{$item->quantity}}</span></span>
                                                        </div>
                                                        <div class="flex flex-row w-full md:text-lg text-sm justify-between">
                                                                <span class="font-bold">₱<span>{{$item->price}}</span></span>
                                                                <span class="font-bold">₱<span>{{$item->total}}</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- form or cancellation  --}}
                                                <div class="w-full">
                                                    <form action="{{ route('submitOrder.cancel', $item->id ) }}" method="POST" class="bg-gray-100 p-4 h-full flex flex-col justify-between" id="cancelForm{{$item->id}}">
                                                        @csrf
                                                        <input type="hidden" name="image_path" value="{{$item->image_path}}" >
                                                        <input type="hidden" name="userId" value="{{$item->userId}}">
                                                        <input type="hidden" name="description" value="{{$item->description}}">
                                                        <input type="hidden" name="gender" value="{{$item->gender}}">
                                                        <input type="hidden" name="variation_id" value="{{$item->variation_id}}">
                                                        <input type="hidden" name="size" value="{{$item->size}}"> 
                                                        <input type="hidden" name="price" value="{{$item->price}}">
                                                        <input type="hidden" name="quantity" value="{{$item->quantity}}">
                                                        <input type="hidden" name="total" value="{{$item->total}}">
                                                        <div class="flex flex-col gap-4 ">
                                                            <div>
                                                                <label for="" class="font-bold ">Cancellation Reason*</label>
                                                                <select name="reason" id="" class="mt-1 w-full h-10 text-sm ">
                                                                    <option value="1">Wrong Product</option>
                                                                    <option value="2">Different Color</option>
                                                                    <option value="3">Wrong Design</option>
                                                                    <option value="4">Reason 1 </option>
                                                                    <option value="5">Reason 2 </option>
                                                                    <option value="6">Reason 3 </option>
                                                                    <option value="7">Reason 4 </option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label for="" class="font-bold">Specify(Optional)</label>
                                                                <textarea name="specify" id="" class="mt-1 w-full h-40 rounded text-sm "></textarea>
                                                            </div>
                                                        </div>
                                                       
                                                    </form>
                                                </div>
                                                <div class="p-2 flex flex-col gap-2 md:hidden ">
                                                    If you have anymore concerns please contact us! 
                                                    <div class="flex flex-row items-center gap-2 text-xl   rounded">
                                                        <ion-icon name="logo-facebook"></ion-icon>
                                                        <ion-icon name="logo-twitter"></ion-icon>
                                                        <ion-icon name="logo-instagram"></ion-icon>
                                                        <ion-icon name="mail-outline"></ion-icon>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-100 w-full p-4">
                                                <button class="w-full px-4 py-2 bg-orange-700 rounded md:text-base text-sm text-white" onclick="openCancelConfirmation({{$item->id}})">Confirm</button>
                                                <dialog class="modal  w-80 rounded" id="cancelConfirmation{{$item->id}}"> 
                                                    <div class="flex flex-col w-full justify-center items-center  shadow-lg rounded  ">
                                                         <div class="p-4 text-sm">
                                                             Are you sure you want to cancel this order?
                                                         </div>
                                                         <div class="flex flex-row justify-evenly w-full border-t ">
                                                             <button class="w-72 border-r  py-1 bg-orange-400 hover:opacity-70 text-white" onclick="submitCancel({{$item->id}})">Confirm</button>
                                                             <button class="px-8 border border-orange-200 hover:opacity-70 closeModal" onclick="closeConfirmationModal({{$item->id}})">No</button>
                                                         </div>
                                                     </div>
                                                 </dialog>
                                            </div>
                                        </div>
                                    </div>
                                </dialog>
                                {{-- form for processing the cancel  --}}
                            </div>
                            {{-- order recieved button with dialog --}}
                            <div class="self-end my-2 {{ Route::currentRouteName() == 'product.status' && request()->status != 3 ? 'hidden' : 'block'}}">
                                <a  onclick="showConfirmationDialog({{$item->id}})" class=" py-1 md:py-2 px-2 md:px-4 text-xs md:text-sm bg-orange-500 cursor-pointer text-white rounded hover:opacity-70">
                                    Order Recieved
                                </a>
                            </div>
                            {{-- modal for confirmation if the order was recieved --}}
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
                                                    <form action="{{route('submitReview')}}" id="reviewForm{{$item->id}}" method="POST">
                                                        @csrf
                                                         {{-- over all  --}}
                                                        <x-ratings id="all{{$item->id}}" font="font-bold" title="Overall Ratings" ratingType="overAll" showOtherRatings="showOtherRatings({{$item->id}}" hide="block" input="starCountAll"> </x-ratings>
                                                        <div id="productServiceRatings{{$item->id}}" class="hidden">
                                                                {{-- product quality --}}
                                                                <x-ratings id="quality{{$item->id}}" font="font-normal"  title="Product Quality " ratingType="quality" input="starCountQuality" showOtherRatings="" hide="opacity-0"> </x-ratings>
                                                                {{-- service  --}}
                                                                <x-ratings id="service{{$item->id}}" font="font-normal"  title="Seller Service" ratingType="service" input="starCountService" showOtherRatings="" hide="opacity-0"> </x-ratings>
                                                                <textarea name="specify" id="specifyValue{{$item->id}}" cols="30" rows="10" class="hidden"></textarea>
                                                        </div>
                                                        <input type="hidden" name="image_path" value="{{$item->image_path}}">
                                                        <input type="hidden" name="description" value="{{$item->description}}">
                                                        <input type="hidden" name="price" value="{{$item->price}}">
                                                        <input type="hidden" name="quantity" value="{{$item->quantity}}">
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
                       <hr class="my-2 w-full">
                       {{-- embedded script for computing the total amount  --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
<x-userFooter />