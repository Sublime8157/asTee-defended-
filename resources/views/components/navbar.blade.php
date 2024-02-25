    <div class=" bg-blue-50 rounded w-full shadow-lg z-40 " id="navbar">
        <nav class="flex flex-row p-5 justify-between ps-8 z-40 py-2 font-semibold text-red-400 items-center">   
            {{-- Company logo      --}}
                <div class="me-40">
                    <ul class="flex flex-row  justify-between items-center">
                        <li> <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50px" height="50px" class="me-1 md:ms-10 ms-0"><li>      
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
                   <div>
                        <ul class="md:flex  w-full">
                            <li class="px-1 flex flex-row md:mb-0 mb-5 ">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18" width="16" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path opacity="1" fill="#1E3050" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                                @if(session('isLoggedin'))
                                <a href="/userProfile"><span class="hover:underline text-sm mx-1">{{ session('username') }}</span></a>
                                @else 
                                <a href="\" class="{{ request()->is('/') ?  'underline text-underline' : ' ' }}">
                                    <span class="hover:underline text-sm mx-1">Login</span>
                                </a>
                                @endif
                            </li>            
                        </ul>
                    
                    </div>
                 </div>
                   {{-- Menu icon  --}}
                        <div class="md:absolute relative md:hidden block text-2xl ">           
                            <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
                        </div>
        </nav>
    </div> 