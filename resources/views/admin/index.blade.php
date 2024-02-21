<x-header />
<body>
    <div class="">
        {{-- Side Bar --}}
        {{-- The tabs you see are just placeholder, we will update these placeholders after finalizing all the tabs that will be needing in the company --}}
            <div class="fixed left-0 h-screen p-1 bg-gray-800 shadow-2xl " style="width: 200px;">
                {{-- DASHBOARD TAB --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="adminLi self-center">
                        <img src="{{ asset('images/adminIcon.jpg') }}" alt="Admin Icon" width="75px" class="m-5 self-center  rounded-full">
                    </li>
                    <li class="text-xs text-gray-200 ps-2 ">
                        DASHBOARD
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="analytics-outline" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Dashboard
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="layers" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Layout
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                </ul>
                {{-- E-COMMERCE TAB --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2">
                        E-COMMERCE
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="cart" class="text-gray-400  text-sm self-center  iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    E-Commerce
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                </ul>
                {{-- APPS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2">
                        APPS
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="mail" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Email
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="apps" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Apps
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                    <li class="flex items-start justify-between w-full flex-row cursor-pointer py-2 ps-5 rounded sideNav">
                        <div class="text-xs text-gray-400 flex items-center flex-row ">
                            <ion-icon name="stats-chart" class="text-gray-400  text-sm self-center iconPadding"></ion-icon>
                                <div class="text-gray-400 text-xs">
                                    Chart
                                </div>
                        </div>
                            <ion-icon name="caret-forward" class="text-xs self-center text-gray-400"></ion-icon>
                    </li>
                </ul>
                {{-- UI COMPONENTS --}}
                <ul class="flex justify-center items-start flex-col">
                    <li class="text-xs text-gray-200 ps-2 mt-2">
                        UI COMPONENTS
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
                    <li class="text-xs text-gray-200 ps-2 mt-2">
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
    <div class="">

    </div>
    </div>

<x-scripts />
</body>
</html>