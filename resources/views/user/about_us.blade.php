
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
                The company is named A's Tee, it is a t-shirt printing company. The company conducts the majority of its business on Facebook, where it also showcases t-shirt packages with various themes and sizes. The owner started the business on November 2021 during a pandemic, with no one in her local area that sells t-shirts, the owner saw this opportunity to use her previous experiences in online selling to establish her business.
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
                From processing the orders via paper and sticky notes, the company now uses a modern way of handling orders all of the products and sales are now digital. A'sTee can now become available for all the platforms and devices and soon will be available on playstore.  
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
               When it comes to physical store anyone can visit the store at <a href="https://www.google.com/maps/place/TEAlicious+Milktea+%26+Fries/@14.5611326,121.2331034,17z/data=!3m1!4b1!4m6!3m5!1s0x3397c1e50fbf9ed7:0x4260a0a855ea0e62!8m2!3d14.5611274!4d121.2356783!16s%2Fg%2F11rr_q53nd?entry=ttu" class="underline ">BLK 19 LOT 2 ST. MARTHA HOUSING PROJECT SITIO TALAGA, BARANGAY MAYBANCAL MORONG RIZAL</a> <b>from 8am - 5pm</b> 
            </p>

        </div>
    </div>
    
</div>
<x-footer />
<x-scripts />