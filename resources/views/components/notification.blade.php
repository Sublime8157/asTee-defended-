@if(session()->has('moveSuccess'))
<div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
    <ion-icon name="checkmark-circle-outline" class=" text-yellow-400 text-lg pe-1"></ion-icon>
    <span class="text-yellow-400 ">
        {{ session()->get('moveSuccess') }}
    </span>
</div>
@endif
@if(session()->has('updatingSuccess'))
<div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
    <ion-icon name="checkmark-circle-outline" class=" text-yellow-400 text-lg pe-1"></ion-icon>
    <span class="text-yellow-400 ">
        {{ session()->get('updatingSuccess') }}
    </span>
</div>
@endif
@if(session()->has('removedSucess'))
    <div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
        <ion-icon name="alert-circle-outline" class=" text-red-800 text-lg pe-1"></ion-icon>
        <span class="text-red-800 ">
            {{ session()->get('removedSucess') }}
        </span>
    </div>
@endif
@if(session()->has('success'))
    <div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
        <ion-icon name="alert-circle-outline" class=" text-red-800 text-lg pe-1"></ion-icon>
        <span class="text-orange-500 ">
            {{ session()->get('success') }}
        </span>
    </div>
@endif
@if(session()->has('fail'))
    <div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
        <ion-icon name="alert-circle-outline" class=" text-red-800 text-lg pe-1"></ion-icon>
        <span class="text-red-800 ">
            {{ session()->get('fail') }}
        </span>
    </div>
@endif
