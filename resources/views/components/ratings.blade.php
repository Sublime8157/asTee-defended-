@props(['ratingType','showOtherRatings','hide','input','title','font','id'])
<div class="flex flex-row w-full items-center justify-between">
        {{-- overall ratings --}}
    <h1 class="{{$font}} md:text-sm text-xs">{{$title}} </h1>
    <ul class="{{$ratingType}} flex flex-row gap-1 items-center">
        <li class="hover:bg-gray-200" value="1">
            <ion-icon name="star" class="text-lg text-yellow-300 "></ion-icon>
        </li>
        <li class="hover:bg-gray-200">
            <ion-icon name="star" class="text-lg text-yellow-300"></ion-icon>
        </li>
        <li class="hover:bg-gray-200">
            <ion-icon name="star" class="text-lg text-yellow-300"></ion-icon>
        </li>
        <li class="hover:bg-gray-200">
            <ion-icon name="star" class="text-lg text-yellow-300"></ion-icon>
        </li>
        <li class="hover:bg-gray-200">
            <ion-icon name="star" class="text-lg text-yellow-300"></ion-icon>
        </li>
        
        <ion-icon name="chevron-down-outline" class="text-base {{$hide}}" onclick="{{$showOtherRatings}}, this)" ></ion-icon>
        <input type="hidden" name="{{$input}}" value="5" id="{{$id}}">
    </ul>
</div>