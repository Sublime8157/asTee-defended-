
@extends('components.header')
@section('docu', 'About Us')
<x-header />
<x-navbar />
<div class="">
    <h1 class="text-4xl font-light mt-10 text-center">Background</h1>
    <div class="w-full flex justify-center md:justify-evenly flex-col md:flex-row mt-10 items-center">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="A's Tee Logo" width="250px">
        </div>
        <div class="w-11/12 md:w-6/12 m-0 md:m-5">
            <p class="indent-10">
               Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur perspiciatis suscipit enim sequi omnis consequuntur hic voluptatem explicabo nostrum officia repellat fugiat odio, voluptatum ad, neque nihil, numquam libero! Aperiam.
            </p>
            <div class="md:text-left text-center">
                <button class="mt-5 px-2 py-1 rounded w-24  bg-blue-500 hover:bg-blue-300" id="more-btn">
                    <div class="flex flex-row justify-evenly items-center ">
                        <div class="text-white">
                            More
                        </div> 
                        <div class="arrow text-white self-center">>></div>
                    </div>
                </button>
            </div>
          
        </div>
    </div>
    <h1 class="text-4xl font-light mt-10 text-center">Process</h1>
    <div class="w-full flex justify-center md:justify-evenly flex-col md:flex-row-reverse mt-10 items-center">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="A's Tee Logo" width="250px">
        </div>
        <div class="w-11/12 md:w-6/12 m-0 md:m-5">
            <p class="indent-10">
               Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur perspiciatis suscipit enim sequi omnis consequuntur hic voluptatem explicabo nostrum officia repellat fugiat odio, voluptatum ad, neque nihil, numquam libero! Aperiam.
            </p>
            <div class="md:text-left text-center">
                <button class="mt-5 px-2 py-1 rounded w-24  bg-blue-500 hover:bg-blue-300" id="more-btn">
                    <div class="flex flex-row justify-evenly items-center ">
                        <div class="text-white">
                            More
                        </div> 
                        <div class="arrow text-white self-center">>></div>
                    </div>
                </button>
            </div>
          
        </div>
    </div>
    <h1 class="text-4xl font-light mt-10 text-center">Location</h1>
    <div class="w-full flex justify-center md:justify-evenly flex-col md:flex-row mt-10 items-center">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="A's Tee Logo" width="250px">
        </div>
        <div class="w-11/12 md:w-6/12 m-0 md:m-5">
            <p class="indent-10">
               Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur perspiciatis suscipit enim sequi omnis consequuntur hic voluptatem explicabo nostrum officia repellat fugiat odio, voluptatum ad, neque nihil, numquam libero! Aperiam.
            </p>
            <div class="md:text-left text-center">
                <button class="mt-5 px-2 py-1 rounded w-24  bg-blue-500 hover:bg-blue-300" id="more-btn">
                    <div class="flex flex-row justify-evenly items-center ">
                        <div class="text-white">
                            More
                        </div> 
                        <div class="arrow text-white self-center">>></div>
                    </div>
                </button>
            </div>
        </div>
    </div>
    
</div>
<x-footer />
<x-scripts />