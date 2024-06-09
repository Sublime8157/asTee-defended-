
@extends('components.header')
@section('docu', 'Home')
<x-header />
    {{-- Navigation bar --}}
    <x-navbar />
    {{-- Carousel  --}}
<div id="default-carousel" class="relative   h-full w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative  overflow-hidden rounded-lg h-96">
         <!-- Item 1 -->
        <div class="hidden h-full duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c1.jpg')}}" class="h-full absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 2 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c2.jpg')}}" class="h-full absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 3 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c3.jpg')}}" class="h-full absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 4 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c1.jpg')}}" class="h-full absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 5 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c2.jpg')}}" class="h-full absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        <button type="" class="h-1 w-1 md:w-3 md:h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
        <button type="" class="h-1 w-1 md:w-3 md:h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
        <button type="" class="h-1 w-1 md:w-3 md:h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        <button type="" class="h-1 w-1 md:w-3 md:h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        <button type="" class="h-1 w-1 md:w-3 md:h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
    </div>
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full  dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-2 h-2 md:h-4 md:w-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full  dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-2 h-2 md:h-4 md:w-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
{{-- Customize & Shop Now Cards --}}
    <div class="items-center flex flex-col md:flex-row md:justify-evenly mt-2 md:mt-10">
        {{-- Customize Now --}}
        <div class="p-5 rounded-xl shadow-lg md:w-96 w-11/12 bg-blue-50 relative hover:bg-gray-200 cursor-pointer md:mb-0 mb-5" id="card">
            <a href="/DIY">
                <div class="font-bold pb-2">
                    Customize Now! <ion-icon name="color-palette" class="text-red-900 text-lg"></ion-icon>
                </div>
                <div class="ps-2 font-light text-sm">
                    Customize with your chosen Shirt 
    
                </div>
                <div class="absolute bottom-0 right-0 overflow-hidden bg-blue-800 border-t-l  p-1 px-2">
                    <div class="arrow">
                    <ion-icon name="arrow-forward" class="text-sm text-white"></ion-icon>
                    </div>
                </div>
            </a>
        </div>
        {{-- Shop Now --}}
       
            <div class="p-5 rounded-xl shadow-lg md:w-96 w-11/12  md:m-0  bg-blue-50 relative hover:bg-gray-200 cursor-pointer" id="card">
                <a href="/Product">
                <div class="font-bold pb-2">
                Shop Now <ion-icon name="cart" class="text-red-900 text-lg"></ion-icon> 
                </div>
                <div class="ps-2 font-light text-sm">
                    Shop Our On hands Products!
                </div>
                <div class="absolute bottom-0 right-0 overflow-hidden bg-blue-800 border-t-l  p-1 px-2 ">
                    <div class="arrow">
                    <ion-icon name="arrow-forward" class="text-sm text-white"></ion-icon>
                    </div>
                </div>
            </a>
            </div>
    </div>

    {{-- Custom Products --}}
    <div class="flex justify-center items-center flex-col my-10 h-auto">
        <div class="text-center w-11/12">
            <span class=" text-2xl"><ion-icon name="shirt" class="text-5xl text-red-500"></ion-icon></span>
            <h1 class="font-extrabold text-lg md:text-2xl">Custom T-Shirt & Promotional Products For Your Group</h1>
        </div>
        <div class="flex flex-wrap flex-col md:flex-row justify-center items-center md:justify-evenly w-11/12 m-10">
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p1.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Family Shirt
                            </h6>
                            <p class="text-sm">
                                Design a t-shirt for all kind of sizes 
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p2.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Solo Shirt 
                            </h6>
                            <p class="text-sm">
                                You can even design with your own t shirt for individual 
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p3.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Long sleeve
                            </h6>
                            <p class="text-sm">
                                We offer not just for t shirt we also offer long sleeve shirt  
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p4.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Long sleeve 
                            </h6>
                            <p class="text-sm">
                                    You can also customize your own long sleeve shirt 
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p5.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Cups 
                            </h6>
                            <p class="text-sm">
                                A'sTee offers customize cups for your personal desire. 
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p6.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Jacket 
                            </h6>
                            <p class="text-sm">
                                AsTee isnt just for tee's we also customize jackets perfect for cold weather 
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p7.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Personalize items 
                            </h6>
                            <p class="text-sm">
                                The flexibility of the company makes the advantage as we also create a personalize cups and bags for your company
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p8.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                Polo Printing
                            </h6>
                            <p class="text-sm">
                                Customize polos for work or play. Stand out with your unique designs!
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p9.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                Custom Cups
                            </h6>
                            <p class="text-sm">
                                Perfect for promotions and gifts. Add your logo or artwork!
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p10.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                Customized Bags
                            </h6>
                            <p class="text-sm">
                                Stylish and durable. Personalize for any occasion!
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p11.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    School related
                            </h6>
                            <p class="text-sm">
                                Carry your P.E. gear in customized, durable bags!
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p12.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    A'sTee
                            </h6>
                            <p class="text-sm">
                                More than tees. Quality customization for all your needs!
                            </p>
                        </div>
                </div>
        </div>              
    </div>
     <div class="flex flex-row justify-center my-4 mx-4 border-blue border shadow-md   p-5 md:p-10 ">
        <p class="md:text-base text-xs ">
            As of the moment the mobile application of AsTee is only available on apk <a href=""></a>, but expect that the availability on playstore within this week. to access the application on your mobile devices download this <a href="https://appdata.freewebsitetoapp.com/app-data/free-apps/37051/87UW5O/app-debug.apk" class="text-blue-700 underline">link</a>, thank you
        </p>
    </div>
    {{-- Featured Customers Feedback --}}
     <div class="text-center">
            <ion-icon name="chatbubbles" class="text-5xl text-red-500"></ion-icon>
            <h1 class="font-extrabold text-lg md:text-2xl tracking-wide">
                    Featured Feedbacks
            </h1>
        </div>
    <div class="w-full flex justify-center gap-4 flex-wrap flex-row p-10 mt-5">
        @foreach ($feedback as $userFeedback)
            <div class="font-extralight shadow-2xl py-2 p-5 w-80 rounded tracking-wider  flex justify-center items-center flex-col" >
                {{-- social media icons  --}}
                <div class="sef-start flex flex-col items-center">
                   <div>
                        <img src="{{asset('storage/images/' . $userFeedback->image_path)}}" alt="" class="w-40">
                   </div>
                   <div>
                       <p class="text-sm"> Price:₱{{$userFeedback->price}}</p>
                       <p class="text-sm"> Quantity: {{$userFeedback->quantity}}</p>
                   </div>
                </div>
                {{-- specify textarea  --}}
                    <div class="text-gray-500 w-full h-full text-sm  italic p-4 " style="font-family: Arial, Helvetica, sans-serif">
                        "{{$userFeedback->specify}}"
                    </div>
                    {{-- star ratings  --}}
                    <div class="flex flex-row items-center gap-2 self-start">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Overall</span>
                            <span class="text-xs text-gray-500">Product Quality</span>
                            <span class="text-xs text-gray-500">Service </span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex flex-row items-center">
                                {{-- star ratings  --}}
                                @for($i = 0; $i < $userFeedback->starCountAll; $i++)
                                    <ion-icon name="star" class="text-base text-yellow-300"></ion-icon>
                                @endfor
                            </div>
                            <div class="flex flex-row items-center">
                                
                                {{-- star ratings  --}}
                                @for($i = 0; $i <$userFeedback->starCountQuality; $i++)
                                    <ion-icon name="star" class="text-base text-yellow-300"></ion-icon>
                                @endfor
                            </div>
                            <div class="flex flex-row items-center">
                               
                                {{-- star ratings  --}}
                                @for($i = 0; $i < $userFeedback->starCountService; $i++)
                                    <ion-icon name="star" class="text-base text-yellow-300"></ion-icon>
                                @endfor
                            </div>
                        </div>
                    </div>
                    {{-- user image  --}}
                    <div class="flex flex-row mt-10 gap-2 items-center self-start">
                        <div class="">
                            <img src="{{asset('storage/images/' . $userFeedback->profile )}}" alt="Customer" class="rounded-full" width="34px">
                        </div>
                        {{-- user first name and date created  --}}
                        <div>
                            <h1 class="text-black text-sm" style="font-family: Arial, Helvetica, sans-serif">{{$userFeedback->username}}</h1>
                            <h1 class="text-xs text-gray-500">{{$userFeedback->created_at}}</h1>
                        </div>
                    </div>
                   
            </div>
        @endforeach
    </div>
    {{-- Footer --}}
<x-footer />
<x-scripts />
