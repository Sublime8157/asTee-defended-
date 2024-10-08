<div class="fixed h-screen w-screen  top-0   " id="loading" style="z-index:  100000">
    <div class="bg-white gap-2 h-full  flex-col w-full flex items-center justify-center ">
            <div>
                <p class="italic text-3xl"><span class="text-4xl text-blue-300 font-semibold">A</span>'s <span class="text-blue-300 font-semibold">T</span>ee</p>  
            </div>
           <div class="loader">

           </div>
    </div>
</div>
{{-- Red part on top  that is only visible in dekstop view--}}
    <div class="hidden md:flex justify-between  h-auto" style="background-color: #f87b1f;">
        <div class="ms-10"> 
            <span class="font-extralight text-white text-xs">
                Custom T-shirts & Promotional Products, Fast & Free Shipping, and All-Inclusive Pricing
            </span>
        </div>
        <div  class="md:flex flex-row justify-between items-center me-5  hidden">
            <div class="me-5">
                <span class="">
                    <ion-icon name="call" class="text-white text-xs font-extralight"></ion-icon>
                <span class="text-white text-xs font-extralight">993-798-7283</span>
                </span>

            </div>
            <div class="me-5">
                <span class="">
                    <ion-icon name="people" class="text-white text-xs font-extralight"></ion-icon>
                <span class="text-white text-xs font-extralight">Talk to a real person</span>
                </span>
            </div>
        </div>
    </div>
    {{-- Red part on top that is only visible in mobile view --}}
    <div class="flex md:hidden justify-between mx-auto w-screen h-auto" style="background-color: #f87b1f;">
    <div class="ms-10"> 
        <span class="font-extralight text-white text-xs">
            Custom T-shirts & More
        </span>
    </div>
    <div  class="md:flex flex-row justify-between items-center me-5">
        <div class="me-5">
            <span class="">
                <ion-icon name="people" class="text-white text-xs font-extralight"></ion-icon>
            <span class="text-white text-xs font-extralight">Help</span>
            </span>
        </div>
    </div>
    </div>     
    <div class=" bg-blue-50 rounded w-full shadow-lg z-40" id="navbar">
        <nav class="flex flex-row p-5 justify-between ps-8 z-40 py-2 font-semibold text-red-400 items-center">   
            {{-- Company logo      --}}
                <div class="me-40">
                    <ul class="flex flex-row  justify-between items-center">
                        <li> <img src="{{ asset('images/companyLogo.png') }}" alt="Logo" width="50px" height="50px" class="md:block hidden me-1 md:ms-10 ms-0"><li>      
                        <li class="italic  md:hidden block"><span class="text-blue-300 font-semibold">A</span>'s <span class="text-blue-300 font-semibold">T</span>ee</li>
                    </ul>
                </div>  
                {{-- Nav bar menu that hides when min screen is below 786px  --}}
                <div id="navbar-main" class="z-40 md:flex md:bg-blue-50 md:shadow-none shadow-lg left-0 w-48 rounded md:h-auto h-screen bg-white md:p-0 ps-5 pt-5 md:mt-0 mt-24 flex-row justify-evenly mx-auto  md:relative absolute md:w-full top-95">
                    <div>
                        <ul class="md:flex md:flex-row flex-col md:mt-0 font-normal"> 
                           <li><img src="{{asset('images/companyLogo.png')}}" alt="Logo" class="block md:hidden"></li>
                           <a href="/home" class="{{ request()->is('/home') ? 'underline font-semibold' : ' ' }}">
                           <li class="mr-6 md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                               Home</li></a>
                            <a href="/about-us" class="{{ request()->is('about-us') ? 'underline font-semibold' : '' }}">
                            <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                About Us</li></a>
                            <a href="/DIY" class="{{ request()->is('DIY') ? 'underline font-semibold' : ' ' }}">
                             <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                D.I.Y</li></a>
                            <a href="/Product" class="{{ request()->is('Product') ? 'underline font-semibold' : '' }}">
                            <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                Product</li></a>
                            <a href="/contact-us" class="{{ request()->is('contact-us') ? 'underline font-semibold' : '' }}">
                            <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                Contact Us</li></a>
                        </ul>
                    </div>
                    {{-- Separating horizontal line --}}
                    <div class="md:hidden block left-20 mb-5 relative w-48">
                        <span><hr></span>
                    </div>
                      {{-- Account icon  for mobile view --}}
                      <div class="md:hidden flex-col justify-between h-full items-start flex ">
                        <div class="flex items-center">
                            <ion-icon name="person"></ion-icon>
                            @if(session('isLoggedin')) 
                            <a href="/userProfile/myAccount"><span class="hover:underline text-sm mx-1">{{ session('username') }}</span></a>
                            @else 
                            <a href="/" class="{{ request()->is('/') ?  'underline text-underline' : ' ' }}">
                                <span class="hover:underline text-sm mx-1">Login</span>
                            </a>
                            @endif
                        </div>
                        <div class="absolute bottom-0 p-5 flex items-center gap-2 w-full">
                            <ion-icon name="exit" class="text-lg"></ion-icon>
                            <a href="/logout">Logout</a>
                        </div>
                   </div>
                 </div>
                 <div>
                    {{-- cart and username for desktop --}}
                    <ul class="md:flex  w-full">
                        <li class="px-1 flex flex-col md:flex-row-reverse md:mb-0 mb-5 items-center gap-4">
                            <div class="relative md:block hidden ">
                                {{-- for desktop view  --}}
                                @if(session('isLoggedin'))
                                    <a href="/cart/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="cart absolute left-5 bottom-5 text-xs  w-4 h-4 text-center rounded-full bg-white cart"></span>
                                    </a>
                                    @else
                                    <a href="/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="absolute left-5 bottom-5  w-4 h-4 text-center text-xs  rounded-full bg-white ">0</span>
                                    </a>
                                @endif
                            </div>
                           <div class="md:flex flex-row items-center hidden">
                                <ion-icon name="person"></ion-icon>
                                {{-- display the username when logged in  --}}
                                @if(session('isLoggedin'))
                                <div class="relative">
                                    <a onclick="userSettings()" class="cursor-pointer"><span class="hover:underline text-sm mx-1">{{ session('username') }}</span></a>
                                    <div class="absolute top-7 right-0 items-start bg-gray-100  shadow  text-base justify-evenly hidden py-2 px-1 rounded font-extralight z-50   flex-col w-60" id="userSettings">
                                        <a href="/userProfile/myAccount" class="py-2 px-4 hover:bg-gray-200 w-full flex items-center gap-2 my-2">
                                            <ion-icon name="settings" class="text-base"></ion-icon>
                                            <span class="text-sm">Manage Account</span>
                                            
                                        </a>
                                        <a href="/logout" class="flex items-center hover:bg-gray-200 gap-2 py-2 px-4
                                        w-full">
                                            <ion-icon name="exit" class="text-base"></ion-icon>
                                            <span class="text-sm">Logout</span>
                                            
                                        </a>
                                    </div>
                                </div>

                                @else 
                                {{-- redirect back to login when not logged in  --}}
                                <a href="/" class="{{ request()->is('/') ?  'underline text-underline' : ' ' }}">
                                    <span class="hover:underline text-sm mx-1">Login</span>
                                </a>
                                @endif
                           </div>
                        </li>            
                    </ul>
                </div>
                   {{-- Menu icon  --}}
                   {{-- for mobile view only  --}}
                        <div class="md:absolute flex flex-row-reverse relative md:hidden gap-4 text-2xl ">           
                            <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
                            <div class="relative md:hidden block ">
                                @if(session('isLoggedin'))
                                    <a href="/cart/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="cart absolute left-5  w-4 h-4 text-center bottom-5 text-xs  rounded-full bg-white ">0</span>

                                    </a>
                                    @else
                                    <a href="/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="absolute left-5  w-4 h-4 text-center bottom-5 text-xs  rounded-full bg-white ">0</span>
                                    </a>
                                @endif
                            </div>      
                        </div>
        
        </nav>
    </div> 
    