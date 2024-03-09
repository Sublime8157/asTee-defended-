{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Dashboard')
{{-- Similar function here  --}}
@section('page','DASHBOARD')
<x-header />
<x-nav />
        <div>
            <dialog id="dashboarModal">
                Test design only will update sooner 
            </dialog>
            <div class="flex  flex-col items-start my-5 mx-5 justify-start gap-2">
                {{-- products section  --}}
                Product
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col bg-red-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$onhandCount}}</span>
                                <h6 class="text-sm text-gray-300">On Hand</h6>
                            </div>
                            <div>
                                <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-red-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                    <div class="flex flex-col bg-green-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$onProcessCount}}</span>
                                <h6 class="text-sm text-gray-300">Processing</h6>
                            </div>
                            <div>
                                <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-green-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                    <div class="flex flex-col bg-red-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$oncancelReturnCount}}</span>
                                <h6 class="text-sm text-gray-300">Cancel or Return</h6>
                            </div>
                            <div>
                                <ion-icon name="cart" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-red-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                    
                </div>
                {{-- accounts section  --}}
                <h1>Accounts</h1>
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col bg-blue-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$userCount}}</span>
                                <h6 class="text-sm text-gray-300">Users</h6>
                            </div>
                            <div>
                                <ion-icon name="people" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-blue-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                    {{-- Blocked Users --}}
                    <div class="flex flex-col bg-yellow-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$blockedUserCount}}</span>
                                <h6 class="text-sm text-gray-300">Blocked Users</h6>
                            </div>
                            <div>
                                <ion-icon name="ban" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-yellow-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                </div>
                {{-- sales section --}}
                <h1>Sales</h1>
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col bg-blue-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$userCount}}</span>
                                <h6 class="text-sm text-gray-300">Users</h6>
                            </div>
                            <div>
                                <ion-icon name="people" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-blue-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                    {{-- Blocked Users --}}
                    <div class="flex flex-col bg-yellow-500 shadow-lg rounded w-64 ">
                        <div class=" flex justify-between items-center px-5 py-2">
                            <div>
                                <span class="text-5xl text-white">{{$blockedUserCount}}</span>
                                <h6 class="text-sm text-gray-300">Blocked Users</h6>
                            </div>
                            <div>
                                <ion-icon name="ban" class="text-5xl text-white"></ion-icon>
                            </div>
                        </div>
                        <div class="flex items-center  justify-center  bg-yellow-600 font-extralight w-full text-white cursor-pointer hover:opacity-50">
                            <a href="" class="me-2">More Info</a>
                            <ion-icon name="play" class="text-white text-xs "></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-adminFooter />