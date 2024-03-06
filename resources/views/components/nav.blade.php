
<body style="background-color: #f9f6f6;">
    <div class="flex justify-between items-start">
        {{-- Side Bar --}}
        {{-- The tabs you see are just placeholder, we will update these placeholders after finalizing all the tabs that will be needing in the company --}}
            <div class=" left-0 h-screen p-1 bg-gray-800 " style="width: 200px;" id="nav">
                {{-- DASHBOARD TAB --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="adminLi self-center">
                        <img src="{{ asset('images/adminIcon.jpg') }}" alt="Admin Icon" width="75px" class="m-5 self-center  rounded-full">
                    </li>
                    <li class="text-xs text-gray-200 ps-2 hover:bg-gray-800">
                        DASHBOARD
                    </li>
                    {{-- The request() is a function provided by laravel specfically for HTTP request and in this case the request() check if the HTTP is dashbaord then 'sideNavBG will append and if not nothing happen' --}}
                    <a href="/dashboard" class="w-full">
                        <li class="flex items-start justify-between flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('dashboard') ? 'sideNavBG' : ' ' }}">                     
                                <div class="text-xs text-gray-400 flex items-center flex-row ">
                                    <ion-icon name="analytics-outline" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                        <div class="text-gray-400 text-xs">
                                            Dashboard
                                        </div>
                                </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                    
                </ul>
                {{-- E-COMMERCE TAB --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        ACCOUNTS
                    </li>
                    <a href="/accounts/active" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('accounts/active') ? 'sideNavBG' : ' ' }}">
                        
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="people-sharp" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                    Active User
                                    </div>
                            </div>
                        
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                    <a href="/accounts/pending" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('accounts/pending') ? 'sideNavBG' : ' ' }}">
                            
                                <div class="text-xs text-gray-400 flex items-center flex-row ">
                                    <ion-icon name="hourglass-sharp" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                        <div class="text-gray-400 text-xs">
                                            Pending User
                                        </div>
                                </div>
                        
                                <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                    <a href="/accounts/blocked" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('accounts/blocked') ? 'sideNavBG' : ' ' }}">                    
                                <div class="text-xs text-gray-400 flex items-center flex-row ">
                                    <ion-icon name="ban-sharp" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                        <div class="text-gray-400 text-xs">
                                            Blocked User
                                        </div>
                                </div>                          
                                <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                </ul>
                {{-- APPS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        PRODUCTS
                    </li>
                    <a href="/products/onHand" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('products/onHand') ? 'sideNavBG' : ' ' }}">                        
                                <div class="text-xs text-gray-400 flex items-center flex-row ">
                                    <ion-icon name="bag-check-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                        <div class="text-gray-400 text-xs">
                                            On-Hand 
                                        </div>
                                </div>
                            
                                <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                    <a href="/products/proccessing" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('products/proccessing') ? 'sideNavBG' : ' ' }}">                        
                                <div class="text-xs text-gray-400 flex items-center flex-row ">
                                    <ion-icon name="sync-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                        <div class="text-gray-400 text-xs">
                                            Processing 
                                        </div>
                                </div>
                            
                                <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                    <a href="/products/cancelReturn" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('products/cancelReturn') ? 'sideNavBG' : ' ' }}">                       
                                <div class="text-xs text-gray-400 flex items-center flex-row ">
                                    <ion-icon name="checkmark-done-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                        <div class="text-gray-400 text-xs">
                                            Return / Cancel 
                                        </div>
                                </div>
                            
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>
                    </a>
                </ul>
                {{-- UI COMPONENTS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        FEEDBACKS
                    </li>
                    <a href="/feedbacks" class="w-full">
                        <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="chatbubbles-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        Feedback
                                    </div>
                            </div>
                                <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                        </li>     
                    </a>             
                </ul>      
                {{-- FORMS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        FORMS
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="settings" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                Forms
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                </ul> 
        </div>
        <div class="w-screen flex flex-col h-screen" style="overflow-y: auto">     
            <div class="bg-gray-50 min-h-12 shadow-md mt-2  rounded  flex justify-between items-center">
                <div class="flex flex-row  items-center text-lg ps-5">
                    <ion-icon name="menu" onclick="Menu(this)" class="text-black text-xl pe-5 cursor-pointer"></ion-icon>
                    {{-- Since this file is a components there are times that we have to change some content on other pages so @yield is a blade components that change content for the other pages the 'page' is a string that we will be using to call in order to change the content in other pages  --}}
                    <h3 class="text-sm font-bold tracking-wide">@yield('page')</h3>
                </div>
                <div class="pe-5 flex flex-row items-center">
                    <ion-icon name="mail-outline" class="text-yellow-700 text-xl pe-5 cursor-pointer"></ion-icon>
                    <ion-icon name="notifications-outline" class="text-yellow-700 text-xl pe-5 cursor-pointer"></ion-icon>
                    <span class="text-xs font-bold">ADMINISTRATOR</span>
                    <img src="{{ asset('images/adminIcon.jpg') }}" alt="admin Icon" width="40px" class="cursor-pointer rounded-full">      
                </div> 
            </div>
      {{-- The closing of the parent div was continued on the other pages that uses this component --}}
      