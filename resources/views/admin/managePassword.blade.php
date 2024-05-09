{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Manage Password')
{{-- Similar function here  --}}
@section('page','Manage Password')
<x-header />
<div class="p-5 absolute">
        <a href="/dashboard" class="text-sm hover:underline">Return to Dashboard</a>
</div>
<div class="w-full  h-screen flex items-center justify-center ">
    <div class="flex flex-col bg-blue-100 rounded shadow-lg p-5 w-4/12">
        <h1 class="text-center text-base ">Manage Password</h1>
        <div class="text-center">
            @if($errors->any()) 
            <span class="text-sm text-yellow-500 font-bold">
                {{$errors->first()}}
            </span>
            @endif
        </div>
        <form action="{{route('changeAdmin.password')}}" class="flex flex-col gap-4" method="POST">
            @csrf
            <div class="flex flex-col form-group  relative">
                <label for="" class="text-sm">Old Password</label>
                <input type="password"  class="password border-none  text-sm" name="oldPassword">
                <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-8 cursor-pointer revealPassword text-base"></ion-icon>
            </div>
            <div class="relative flex form-group flex-col">
                <label for="" class="text-sm">New Password</label>
                <input type="password" class="password border-none text-sm"  name="newPassword">
                <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-8 cursor-pointer revealPassword text-base"></ion-icon>
            </div>
            <div class="relative flex form-group flex-col">
                <label for="" class="text-sm">Confirm Password</label>
                <input type="password" class="password border-none text-sm"  name="confirmPassword">
                <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-8 cursor-pointer revealPassword text-base"></ion-icon>
            </div>
            <div class="w-full">
                <button class="bg-blue-700 w-full rounded shadow py-2 text-white ">Confirm</button>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('js/adminScripts2.js')}}"></script>
<x-adminFooter />