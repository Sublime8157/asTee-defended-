<x-userHeader /> 
<div class="absolute  top-0 bg-blue-700   text-center w-full" id="thankYouNotif">
    @if(session()->has('Success'))
        <p class="py-2 text-white text-sm" id="successMessage">{{ session()->get('Success') }}</p>
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
                    <a href="{{ route('myPurchase', ['status' => 'to_pay']) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="wallet-outline" class="md:hidden"></ion-icon>
                        <li class="status relative  hover:bg-white {{ $status->value === 'to_pay' ? 'border-b border-gray-400' : '' }} text-sm ">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-6 md:left-12 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if (($counts['to_pay'] ?? 0) != 0)
                                    {{ $counts['to_pay'] }}
                                @endif
                            </span><span class="text-xs md:text-sm">To Pay</span>
                        </li>
                    </a>
                    {{-- to ship --}}
                      <a href="{{ route('myPurchase', ['status' => 'to_ship']) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="cube-outline" class="md:hidden"></ion-icon>
                        <li class="status relative hover:bg-white {{ $status->value === 'to_ship' ? 'border-b border-gray-400' : '' }} text-sm ">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-8 md:left-12 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if (($counts['to_ship'] ?? 0) != 0)
                                    {{ $counts['to_ship'] }}
                                @endif
                            </span>
                            <span class="text-xs md:text-sm">To Ship</span>
                        </li>
                    </a>
                    {{-- to recieve --}}
                       <a href="{{ route('myPurchase', ['status' => 'to_receive']) }}" class="flex justify-center  flex-col items-center ">
                        <img src="{{ asset('images/toRecieveIcon.png') }}" alt="" width="20px" class="md:hidden" style="margin-bottom: 1px;">
                        <li class="status relative hover:bg-white {{ $status->value === 'to_receive' ? 'border-b border-gray-400' : '' }} text-sm ">
                            <span class="font-bold absolute bottom-8 md:bottom-4 left-10 md:left-20 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if (($counts['to_receive'] ?? 0) != 0)
                                    {{ $counts['to_receive'] }}
                                @endif
                            </span>
                            <span class="text-xs md:text-base">To Recieve</span>
                        </li>
                    </a>
                    {{-- to review --}}
                       <a href="{{ route('myPurchase', ['status' => 'to_review']) }}" class="flex justify-center  flex-col items-center">
                        <ion-icon name="chatbox-ellipses-outline" class="md:hidden"></ion-icon>
                        <li class="relative status hover:bg-white {{ $status->value === 'to_review' ? 'border-b border-gray-400' : '' }} text-sm">
                            <span class="font-bold absolute bottom-8 md:bottom-3 left-10 md:left-20 text-orange-700 py-1 px-1 text-xs md:text-base rounded-full" >
                                @if (($counts['to_review'] ?? 0) != 0)
                                    {{ $counts['to_review'] }}
                                @endif
                            </span>
                            <span class="text-xs md:text-base">To Review</span>
                        </li>
                    </a>
                </ul>
                {{-- products --}}
                <div id="products" class="flex-col flex w-full justify-between">
                    @foreach ($items as $item)
                        <div class="flex flex-row gap-4 ">
                            {{-- image --}}
                            <div>
                                <img src="{{ $item->image_url }}" alt="" class="md:w-40 w-20 bg-gray-200 rounded p-2 ">
                            </div>
                            <div class="md:text-base text-xs">
                                {{-- details --}}
                                    <p>{{ $item->shortDescription }} </p>
                                    <p>{{ $item->size->label() }} | {{ $item->variation->label() }} | {{ $item->gender->label() }}</p>
                                    <p id="price{{$item->id}}"><b>Price: </b>{{ $item->unit_price }}</p>
                                    <p><b>Qty:</b> <span id="quantity{{$item->id}}">{{$item->quantity}}</span></p> 
                                    <b>Address: </b>{{ $item->order->address }} <br>
                                    <b>MOP: </b>{{ $item->order->payment_method }}
                            </div>
                        </div>
                        <div class="self-end md:text-base text-xs text-orange-700 pe-4">
                            {{-- check if current the url is on toreview or 4  replace the total to review button if true   --}}
                            @if($status === \App\Enums\OrderStatus::ToReview)
                            {{-- review button in to review tab  --}}
                                 <button class="py-1 px-2 text-sm border-orange-500 border rounded" onclick="reviewButton({{$item->id}})">Review</button>
                            @else
                            {{-- total --}}
                                 <span class="text-black ">Total: ₱</span><span>{{ $item->line_total }}</span>
                            @endif
                            {{-- cancel button for to pay   --}}
                            <div class=" py-1 {{ $status !== \App\Enums\OrderStatus::ToPay ? 'hidden' : 'block' }} ">
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
                                                        <img src="{{ $item->image_url }}" alt="Product Image" width="100px">
                                                    </div>
                                                    <div class="flex flex-col w-full gap-2">
                                                        <div>
                                                            <p class="text-black">{{ $item->shortDescription }}</p>
                                                        </div>
                                                        <div class="text-gray-600 flex flex-row ">
                                                            <span>{{ $item->variation->label() }}</span> | 
                                                            <span>{{ $item->gender->label() }}</span> | 
                                                            <span>{{ $item->size->label() }}</span> 
                                                        </div>
                                                        <div>
                                                            <span class="font">Qty: <span>{{$item->quantity}}</span></span>
                                                        </div>
                                                        <div class="flex flex-row w-full md:text-lg text-sm justify-between">
                                                                <span class="font-bold">₱<span>{{ $item->unit_price }}</span></span>
                                                                <span class="font-bold">₱<span>{{ $item->line_total }}</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- form or cancellation  --}}
                                                <div class="w-full">
                                                    <form action="{{ route('submitOrder.cancel', $item->id ) }}" method="POST" class="bg-gray-100 p-4 h-full flex flex-col justify-between" id="cancelForm{{$item->id}}">
                                                        @csrf
                                                        {{-- The whole line used to be re-posted as hidden inputs and written to a
                                                             second table verbatim, price included. The server now looks the line
                                                             up by id and checks that it is yours. --}}
                                                        <div class="flex flex-col gap-4 ">
                                                            <div>
                                                                <label for="" class="font-bold ">Cancellation Reason*</label>
                                                                <select name="reason" class="mt-1 w-full h-10 text-sm ">
                                                                    @foreach(\App\Enums\CancelReason::options() as $value => $label)
                                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label for="" class="font-bold">Specify(Optional)   
                                                                <textarea name="specify" id="" class="mt-1 w-full h-40 rounded text-sm "></textarea>
                                                            </div>
                                                        </div>
                                                       
                                                    </form>
                                                </div>
                                                <div class="p-2 flex flex-col gap-2 md:hidden ">
                                                    If you have anymore concerns please contact us! 
                                                    <div class="flex flex-row items-center gap-2 text-xl   rounded">
                                                        <ion-icon name="logo-facebook"></ion-icon>
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
                            <div class="self-end my-2 {{ $status === \App\Enums\OrderStatus::ToReceive ? 'block' : 'hidden'}}">
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
                                <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                              
                            </form> 
                            {{-- dialog for review  --}}
                            <dialog id="feedBackModal{{$item->id}}" class=" w-screen h-screen"> 
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
                                               
                                                    <img src="{{ $item->image_url }}" alt="no image " class="md:w-40 w-20 bg-gray-200 rounded  ">
                                               </div>
                                               <div class="flex flex-col gap-1">
                                                {{-- details  --}}
                                                   <span class="md:text-base text-sm text-black font-semibold">{{ $item->shortDescription }}</span>
                                                   <div class="flex flex-row text-sm ">
                                                        <span>{{ $item->variation->label() }}</span>|<span> {{ $item->gender->label() }}</span> | 
                                                        <span>{{ $item->size->label() }}</span>
                                                   </div>
                                                   <div class="text-orange-700 text-sm md:text-base">
                                                         ₱{{ $item->unit_price }}
                                                   </div>
                                               </div>
                                               
                                           </div>
                                           {{-- ratings --}}
                                            <div class="flex flex-col">
                                                    <form action="{{route('submitReview')}}" id="reviewForm{{$item->id}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                         {{-- over all  --}}
                                                        <x-ratings id="all{{$item->id}}" font="font-bold" title="Overall Ratings" ratingType="overAll" showOtherRatings="showOtherRatings({{$item->id}}" hide="block" input="rating_overall"> </x-ratings>
                                                        <div id="productServiceRatings{{$item->id}}" class="hidden">
                                                                {{-- product quality --}}
                                                                <x-ratings id="quality{{$item->id}}" font="font-normal"  title="Product Quality " ratingType="quality" input="rating_quality" showOtherRatings="" hide="opacity-0"> </x-ratings>
                                                                {{-- service  --}}
                                                                <x-ratings id="service{{$item->id}}" font="font-normal"  title="Seller Service" ratingType="service" input="rating_service" showOtherRatings="" hide="opacity-0"> </x-ratings>
                                                                <textarea name="comment" id="specifyValue{{$item->id}}" cols="30" rows="10" class="hidden"></textarea>
                                                        </div>
                                                        <input type="hidden" value="{{ $item->id }}" name="order_item_id" id="productId{{$item->id}}">
                                                        <input type="file" id="image{{$item->id}}" name="image" value="" class="hidden">
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- please specify --}}
                                    <div class="self-center w-full">
                                        <label class="text-xs md:text-sm">Please Specify (Optional)</label>
                                        <textarea id="specify{{$item->id}}" onkeyup="getTheText({{$item->id}})" class="mt-2 text-sm w-full h-40 rounded" placeholder="What do you think of the quality and services?"></textarea>
                                    </div>
                                    <div>
                                        <label for="" class="text-xs">Attach Image (Optional)  </label> <br>
                                        <input type="file" class="text-xs" onchange="uploadImage({{$item->id}})" id="uploadImage{{$item->id}}">  <br>
                                        <span class="text-xs">
                                            File size: maximum 2 MB File extension: .JPEG, .PNG 
                                        </span>
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