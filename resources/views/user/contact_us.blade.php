@extends('components.header')
@section('docu', 'Contact us')
<x-header />
<x-navbar />
    <div class="p-10 flex items-center flex-col gap-10 md:flex-row justify-evenly my-10 h-auto md:h-96 w-full">
        <div class="flex flex-col gap-4 ">
            <h1 class="font-bold text-4xl text-blue-950">GET IN TOUCH</h1>
            <div class="py-4">
                <hr class="w-48 bg-red-700 h-1"></hr>
            </div>
            <div class="gap-2 text-sm flex flex-row items-center">
                <ion-icon name="call"></ion-icon>
                +639154403873
            </div>
            <div class="gap-2 flex text-sm flex-row items-center">
                <ion-icon name="mail"></ion-icon>
                astee@gmail.com
            </div>
            <div class="gap-2 flex flex-row items-center">
                <ion-icon name="navigate-circle"></ion-icon>
                <p class="text-sm">
                    BLK 19 LOT 2 st. Martha Housing Project Sitio Talaga,  <br> Barangay Maybancal Morong Rizal
                </p>
            </div>
        </div>
        <div class="w-96">
            <form action="" class="w-full flex flex-col gap-4 items-center md:items-start justify-center">
                <input type="text" name="" id="" class="text-sm h-8 w-96 md:w-full ps-2" placeholder="Name">
                <input type="text" name="" id="" class="text-sm h-8 w-96 md:w-full ps-2" placeholder="Email">
                <textarea name="" id=""  rows="5" class="text-sm  w-96 md:w-full ps-2" placeholder=Message></textarea>
                <button type="submit" class="w-full bg-orange-500 text-white rounded-sm py-2">Submit</button>
            </form>
        </div>
    </div>
<x-footer />
<script src="{{asset('/js/diy.js')}}"></script>
<x-scripts />