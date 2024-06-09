@extends('components.header')
@section('docu', 'Licensing')
<x-header />
<body>
    

<x-navbar /> 
    <div class="my-5 flex justify-around flex-col md:flex-row ">
        <div class="flex flex-col gap-2 ">
            <h6 class="font-bold text-lg text-center">DTI PERMIT </h6>
            <img src="{{asset('storage/images/DTI.jpg')}}" alt="" class="w-auto h-96">
        </div>
        <div>
            <h6 class="font-bold text-lg text-center">BRGY PERMIT </h6>
            <img src="{{asset('storage/images/brgy_permit.jpg')}}" alt="" class="w-auto h-96">
        </div>
    </div>
</body>
<x-footer />
<x-scripts />
