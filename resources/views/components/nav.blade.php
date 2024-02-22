
<body>
    <div class="flex justify-between items-start">
        {{-- Side Bar --}}
        {{-- The tabs you see are just placeholder, we will update these placeholders after finalizing all the tabs that will be needing in the company --}}
            <div class=" left-0 h-screen p-1 bg-gray-800 shadow-2xl " style="width: 200px;">
                {{-- DASHBOARD TAB --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="adminLi self-center">
                        <img src="{{ asset('images/adminIcon.jpg') }}" alt="Admin Icon" width="75px" class="m-5 self-center  rounded-full">
                    </li>
                    <li class="text-xs text-gray-200 ps-2 hover:bg-gray-800">
                        DASHBOARD
                    </li>
                    {{-- The request() is a function provided by laravel specfically for HTTP request and in this case the request() check if the HTTP is dashbaord then 'sideNavBG will append and if not nothing happen' --}}
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('dashboard') ? 'sideNavBG' : ' ' }}">
                        <a href="/dashboard" class="">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="analytics-outline" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        Dashboard
                                    </div>
                            </div>
                                
                        </a>
                        <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    
                </ul>
                {{-- E-COMMERCE TAB --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        ACCOUNTS
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('accounts/active') ? 'sideNavBG' : ' ' }}">
                       <a href="/accounts/active">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="people-sharp" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                   Active User
                                </div>
                        </div>
                       </a>
                        <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('accounts/pending') ? 'sideNavBG' : ' ' }}">
                        <a href="/accounts/pending">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="hourglass-sharp" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        Pending User
                                    </div>
                            </div>
                        </a>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('accounts/denied') ? 'sideNavBG' : ' ' }}">
                       <a href="/accounts/denied">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="ban-sharp" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        Denied User
                                    </div>
                            </div>
                        </a>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                </ul>
                {{-- APPS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        PRODUCTS
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('products/onHand') ? 'sideNavBG' : ' ' }}">
                        <a href="/products/onHand">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="bag-check-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        On-Hand 
                                    </div>
                            </div>
                        </a>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('products/proccessing') ? 'sideNavBG' : ' ' }}">
                        <a href="/products/proccessing">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="sync-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        Processing 
                                    </div>
                            </div>
                        </a>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav {{ request()->is('products/finished') ? 'sideNavBG' : ' ' }}">
                       <a href="/products/finished">
                            <div class="text-xs text-gray-400 flex items-center flex-row ">
                                <ion-icon name="checkmark-done-sharp" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                    <div class="text-gray-400 text-xs">
                                        Finished Products
                                    </div>
                            </div>
                        </a>
                        <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                </ul>
                {{-- UI COMPONENTS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2 hover:bg-gray-800">
                        SALES
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="build" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    UI
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="logo-web-component" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Components
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="book" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Widgets
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
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
        <div class="w-screen flex justify-evenly flex-col">     
            <div class="bg-gray-50 h-12 shadow-xl mt-2  rounded  flex justify-between items-center">
                <div class="flex flex-row  items-center text-lg ps-5">
                    <ion-icon name="menu-outline" class="text-black text-xl pe-5 cursor-pointer"></ion-icon>
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
      