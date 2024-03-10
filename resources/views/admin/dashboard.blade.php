{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Dashboard')
{{-- Similar function here  --}}
@section('page','DASHBOARD')
<x-header />
<x-nav />
        <div>
        
            <div class="flex  flex-col items-start my-5 mx-5  gap-2 bg-gray-100">
                {{-- products section  --}}
                <h1 class="text-sm opacity-70 ps-5 w-full bg-gray-300 rounded  shadow-lg py-2">PRODUCTS</h1>
                <div class="flex w-full justify-start flex-row gap-2">
                    {{-- on hand  --}}
                    <div class=" flex flex-col bg-red-800 justify-between py-2 shadow-xl h-32 rounded w-96 ">
                        <div class=" flex justify-between items-center px-5 pt-2">
                            <div>
                                <span class="text-5xl text-white">{{$onhandCount}}</span>
                                <h6 class="text-sm text-gray-300">On Hand</h6>
                            </div>
                            <div>
                                <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-red-800 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="/products/onHand" class="me-2 text-sm opacity-70 flex items-center gap-2">More info                                                     
                            <ion-icon name="play" class="text-white text-xs opacity-70"></ion-icon></a>       
                        </div>
                    </div>
                    {{-- processing --}}
                    <div class="flex flex-col bg-green-800 justify-between py-2 shadow-xl h-32 rounded w-96 ">
                        <div class=" flex justify-between items-center px-5 pt-2">
                            <div>
                                <span class="text-5xl text-white">{{$onProcessCount}}</span>
                                <h6 class="text-sm text-gray-300">Processing</h6>
                            </div>
                            <div>
                                <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-green-800 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="/products/proccessing" class="me-2 text-sm opacity-70 flex items-center gap-2">More info                                                     
                            <ion-icon name="play" class="text-white text-xs opacity-70"></ion-icon></a>       
                        </div>
                    </div>
                    {{-- cancel or return --}}
                    <div class="flex flex-col bg-blue-600 justify-between py-2 shadow-xl h-32 rounded w-96 ">
                        <div class=" flex justify-between items-center px-5 pt-2">
                            <div>
                                <span class="text-5xl text-white">{{$oncancelReturnCount}}</span>
                                <h6 class="text-sm text-gray-300">Cancel or Return</h6>
                            </div>
                            <div>
                                <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-blue-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="/products/cancelReturn" class="me-2 text-sm opacity-70 flex items-center gap-2">More info                                                     
                            <ion-icon name="play" class="text-white text-xs opacity-70"></ion-icon></a> 
                        </div>
                    </div>      
                    {{-- placeholer --}}
 
                </div>
                {{-- accounts section  --}}
                <h1 class="text-sm opacity-70 ps-5 w-full bg-gray-300 rounded shadow-lg  py-2 mt-2">ACCOUNTS</h1>
                <div class="flex items-start justify-evenly w-full flex-row">
                    <div class="flex flex-col  gap-4">
                        <div class="flex flex-col bg-blue-600 justify-between py-2 shadow-lg h-32 rounded w-96 ">
                            <div class=" flex justify-between items-center px-5 pt-2">
                                <div>
                                    <span class="text-5xl text-white">{{$userCount}}</span>
                                    <h6 class="text-sm text-gray-300">Users</h6>
                                </div>
                                <div>
                                    <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                                </div>
                            </div>
                            <div class="flex items-center  justify-center  bg-blue-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                                <a href="/products/cancelReturn" class="me-2 text-sm opacity-70 flex items-center gap-2">More info                                                     
                                <ion-icon name="play" class="text-white text-xs opacity-70"></ion-icon></a> 
                            </div>
                        </div>   
                        <div class="flex flex-col bg-blue-600 justify-between py-2 shadow-lg h-32 rounded w-96 ">
                            <div class=" flex justify-between items-center px-5 pt-2">
                                <div>
                                    <span class="text-5xl text-white">{{$blockedUserCount}}</span>
                                    <h6 class="text-sm text-gray-300">Blocked Accounts</h6>
                                </div>
                                <div>
                                    <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                                </div>
                            </div>
                            <div class="flex items-center  justify-center  bg-blue-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                                <a href="/products/cancelReturn" class="me-2 text-sm opacity-70 flex items-center gap-2">More info                                                     
                                <ion-icon name="play" class="text-white text-xs opacity-70"></ion-icon></a> 
                            </div>
                        </div>         
                    </div>
                   <div>
                        <div class="p-5 shadow-lg">
                            <canvas id="myChart" style="width: 40rem; height: 230px;"></canvas>
                        </div>
                   </div>
                </div>
                {{-- sales section --}}
                <h1 class="text-sm opacity-70 ps-5 w-full bg-gray-300 rounded shadow-lg py-2 mt-2">SALES</h1>
                <div class="flex flex-row justify-evenly shadow-xl p-10 rounded w-full">
                   
                        <div class="">
                            <canvas id="salesChart" style="width: 500px; "></canvas>
                        </div>
                   
                        <div class="flex items-center justify-center flex-col">
                          
                            <canvas id="returnCancel" style="width: 250px"></canvas>
                            <p class="text-xs ps-5">Return & cancel</p>
                        </div>
                        <div class="flex items-center flex-col">
                            
                            <canvas id="products" style="width: 250px"></canvas>
                           <div>
                            <span class="text-xs ps-5 me-5 ">Return Products</span>
                           </div>
                        </div>
                        <div>

                        </div>
                    
            </div>
        </div>
    </div>
</div>
<script>
    var listOfMonths = JSON.parse('{!! json_encode($months) !!}');
    var usersCount = JSON.parse('{!! json_encode($monthCount) !!}');
    var wrongProduct = {{$wrongProduct}};
    var differentColors = {{$differentColors}};
    var wrongDesign = {{$wrongDesign}};
    var reason1 = {{$reason1}};
    var reason2 = {{$reason2}};
    var reason3 = {{$reason3}};
    var reason4 = {{$reason4}};
</script>
<x-adminFooter />