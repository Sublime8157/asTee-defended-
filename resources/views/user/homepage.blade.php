
@extends('components.header')
@section('docu', 'Home')
<x-header />

    {{-- Navigation bar --}}
    <x-navbar />
    {{-- Carousel  --}}
<div id="default-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-32 overflow-hidden rounded-lg md:h-96">
         <!-- Item 1 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c1.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 2 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c2.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 3 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c3.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 4 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c1.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div>
        <!-- Item 5 -->
        <div class="hidden duration-1000 ease-in-out" data-carousel-item>
            <img src="{{asset('images/c2.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
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
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p2.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p3.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p4.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p5.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p6.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p7.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p8.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p9.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p10.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p11.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
                <div class="w-96 cursor-pointer p-card">
                    <img src="{{asset('images/p12.jpg')}}" alt="">
                        <div class="py-2 ps-2 pe-1 p-details">
                            <h6 class="font-bold text-lg">
                                    Lorem
                            </h6>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                </div>
        </div>              
    </div>
    {{-- Featured Customers Feedback --}}
     <div class="text-center">
            <ion-icon name="chatbubbles" class="text-5xl text-red-500"></ion-icon>
            <h1 class="font-extrabold text-lg md:text-2xl tracking-wide">
                    Featured Feedbacks
            </h1>
        </div>
    <div class="w-full flex justify-evenly flex-wrap flex-row p-10 mt-5">
        <div class="font-extralight shadow-2xl p-10 w-80 rounded tracking-wider h-96 flex justify-center items-center flex-col relative" >
            <div class="absolute top-0 right-0 p-5">
                <ion-icon name="logo-facebook" class="text-blue-500 text-lg cursor-pointer hover:translate-y-1"></ion-icon>
                <ion-icon name="logo-instagram" class="text-lg cursor-pointer hover:translate-y-1"></ion-icon>
                <ion-icon name="logo-twitter" class="text-blue-300 text-lg cursor-pointer hover:translate-y-1"></ion-icon>
            </div>
                <div class="opacity-75 text-md" style="font-family: Arial, Helvetica, sans-serif">
                      "  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, voluptatum. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nisi, aliquam. "
                </div>
                <div class="flex flex-row mt-10 items-center self-start ps-5" >
                    <div class="pe-5">
                           <img src="{{asset('images/p1.jpg')}}" alt="Customer" class="rounded-full" width="50px">
                    </div>
                    <div>
                        <h1>Customer 1 </h1>
                    </div>
                </div>
        </div>
        <div class="font-extralight shadow-2xl p-10 w-80 rounded tracking-wider h-96 flex justify-center items-center flex-col relative" >
            <div class="absolute top-0 right-0 p-5">
                <ion-icon name="logo-facebook" class="text-blue-500 text-lg cursor-pointer hover:translate-y-1"></ion-icon>
                <ion-icon name="logo-instagram" class="text-lg cursor-pointer hover:translate-y-1"></ion-icon>
                <ion-icon name="logo-twitter" class="text-blue-300 text-lg cursor-pointer hover:translate-y-1"></ion-icon>
            </div>
            <div class="opacity-75 text-md" style="font-family: Arial, Helvetica, sans-serif">
                  "  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, voluptatum. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nisi, aliquam. "
            </div>
            <div class="flex flex-row mt-10 items-center self-start ps-5" >
                <div class="pe-5">
                       <img src="{{asset('images/p1.jpg')}}" alt="Customer" class="rounded-full" width="50px">
                </div>
                <div>
                    <h1>Customer 1 </h1>
                </div>
            </div>
        </div>
        <div class="font-extralight shadow-2xl p-10 w-80 rounded tracking-wider h-96 flex justify-center items-center flex-col relative" >
            <div class="absolute top-0 right-0 p-5">
                <ion-icon name="logo-facebook" class="text-blue-500 text-lg cursor-pointer hover:translate-y-1"></ion-icon>
                <ion-icon name="logo-instagram" class="text-lg cursor-pointer hover:translate-y-1"></ion-icon>
                <ion-icon name="logo-twitter" class="text-blue-300 text-lg cursor-pointer hover:translate-y-1"></ion-icon>
            </div>
            <div class="opacity-75 text-md" style="font-family: Arial, Helvetica, sans-serif">
                "  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, voluptatum. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nisi, aliquam. "
            </div>
            <div class="flex flex-row mt-10 items-center self-start ps-5" >
                <div class="pe-5">
                    <img src="{{asset('images/p1.jpg')}}" alt="Customer" class="rounded-full" width="50px">
                </div>
                <div>
                    <h1>Customer 1 </h1>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer --}}
<x-footer />
<x-scripts />
