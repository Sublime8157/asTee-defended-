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
                <span class="text-white text-xs font-extralight">000-000-00</span>
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
                        <li> <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50px" height="50px" class="md:block hidden me-1 md:ms-10 ms-0"><li>      
                        <li class="italic  md:hidden block"><span class="text-blue-300 font-semibold">A</span>'s <span class="text-blue-300 font-semibold">T</span>ee</li>
                    </ul>
                </div>  
                {{-- Nav bar menu that hides when min screen is below 786px  --}}
                <div id="navbar-main" class="z-40 md:flex md:bg-blue-50 md:shadow-none shadow-lg left-0 w-48 rounded md:h-auto h-screen bg-white md:p-0 ps-5 pt-5 md:mt-0 mt-24 flex-row justify-evenly mx-auto  md:relative absolute md:w-full top-95">
                    <div>
                        <ul class="md:flex md:flex-row flex-col md:mt-0 font-normal"> 
                           <li><img src="{{asset('images/logo.png')}}" alt="Logo" class="block md:hidden"></li>
                           <li class="mr-6 md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                <a href="/home" class="{{ request()->is('home') ? 'underline font-semibold' : ' ' }}">Home</a></li>
                            <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                <a href="/about-us" class="{{ request()->is('about-us') ? 'underline font-semibold' : '' }}">About Us</a></li>
                             <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                <a href="/DIY" class="{{ request()->is('DIY') ? 'underline font-semibold' : ' ' }}">D.I.Y</a></li>
                            <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20">
                                <a href="/Product" class="{{ request()->is('Product') ? 'underline font-semibold' : '' }}">Product</a></li>
                            <li class="mr-6  md:mb-0 mb-5 self-center hover:bg-blue-50  md:hover:underline left-20"><a href="">Contact Us</a></li>
                        </ul>
                    </div>
                    {{-- Separating horizontal line --}}
                    <div class="md:hidden block left-20 mb-5 relative w-48">
                        <span><hr></span>
                    </div>
                      {{-- Account icon  --}}
                      <div class="md:hidden flex-row items-center block">
                        <ion-icon name="person"></ion-icon>
                        @if(session('isLoggedin'))
                        <a href="/userProfile"><span class="hover:underline text-sm mx-1">{{ session('username') }}</span></a>

                        @else 
                        <a href="\" class="{{ request()->is('/') ?  'underline text-underline' : ' ' }}">
                            <span class="hover:underline text-sm mx-1">Login</span>
                        </a>
                        @endif
                   </div>
                 </div>
                 <div>
                    <ul class="md:flex  w-full">
                        <li class="px-1 flex flex-col md:flex-row-reverse md:mb-0 mb-5 items-center gap-4">
                            <div class="relative md:block hidden ">
                                @if(session('isLoggedin'))
                                    <a href="/cart/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="absolute left-5 bottom-5 text-xs  rounded-full bg-white ">0</span>
                                    </a>
                                    @else
                                    <a href="/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="absolute left-5 bottom-5 text-xs  rounded-full bg-white ">0</span>
                                    </a>
                                @endif
                            </div>
                           <div class="md:flex flex-row items-center hidden">
                                <ion-icon name="person"></ion-icon>
                                @if(session('isLoggedin'))
                                <a href="/userProfile"><span class="hover:underline text-sm mx-1">{{ session('username') }}</span></a>

                                @else 
                                <a href="\" class="{{ request()->is('/') ?  'underline text-underline' : ' ' }}">
                                    <span class="hover:underline text-sm mx-1">Login</span>
                                </a>
                                @endif
                           </div>
                        </li>            
                    </ul>
                </div>
                   {{-- Menu icon  --}}
                        <div class="md:absolute flex flex-row-reverse relative md:hidden gap-4 text-2xl ">           
                            <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
                            <div class="relative md:hidden block ">
                                @if(session('isLoggedin'))
                                    <a href="/cart/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="absolute left-5 bottom-5 text-xs  rounded-full bg-white ">0</span>
                                    </a>
                                    @else
                                    <a href="/{{ session('id') }}">
                                        <ion-icon name="cart" class="text-2xl"></ion-icon> 
                                        <span class="absolute left-5 bottom-5 text-xs  rounded-full bg-white ">0</span>
                                    </a>
                                @endif
                            </div>      
                        </div>
        
        </nav>
    </div> 