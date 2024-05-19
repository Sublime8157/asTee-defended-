
@extends('components.header')
@section('docu', 'About Us')
<x-header />
<x-navbar />
<div class="my-4 ">
    <h1 class="text-4xl font-light mt-10 text-center">Background</h1>
    <div class="w-full flex justify-center md:justify-evenly flex-col md:flex-row mt-10 items-center">
        <div>
            <img src="{{ asset('images/companyBackground.jpg') }}" alt="A's Tee Logo" class="w-96 h-80">
        </div>
        <div class="w-11/12 md:w-6/12 m-0 md:m-5">
            <p class="indent-10">
               Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur perspiciatis suscipit enim sequi omnis consequuntur hic voluptatem explicabo nostrum officia repellat fugiat odio, voluptatum ad, neque nihil, numquam libero! Aperiam.
            </p>
        </div>
    </div>
    <h1 class="text-4xl font-light mt-10 text-center">Process</h1>
    <div class="w-full flex justify-center md:justify-evenly flex-col md:flex-row-reverse mt-10 items-center">
        <div>
            <img src="{{ asset('images/processing.jpg') }}" alt="A's Tee Logo" class="w-96 h-80">
        </div>
        <div class="w-11/12 md:w-6/12 m-0 md:m-5">
            <p class="indent-10">
               Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur perspiciatis suscipit enim sequi omnis consequuntur hic voluptatem explicabo nostrum officia repellat fugiat odio, voluptatum ad, neque nihil, numquam libero! Aperiam.
            </p>       
        </div>
    </div>
    <h1 class="text-4xl font-light mt-10 text-center">Location</h1>
    <div class="w-full flex justify-center md:justify-evenly flex-col md:flex-row mt-10 items-center">
        <div>
            <img src="{{ asset('images/location.png') }}" alt="A's Tee Logo" class="w-96 h-80">
        </div>
        <div class="w-11/12 md:w-6/12 m-0 md:m-5">
            <p class="indent-10">
               Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur perspiciatis suscipit enim sequi omnis consequuntur hic voluptatem explicabo nostrum officia repellat fugiat odio, voluptatum ad, neque nihil, numquam libero! Aperiam.
            </p>

        </div>
    </div>
    
</div>
<x-footer />
<x-scripts />