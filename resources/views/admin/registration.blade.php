{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Registration')
{{-- Similar function here  --}}
@section('page','Registration')
<x-header />
    <div class="absolute p-5">
        <h1 class="text-sm cursor-pointer hover:underline ">
            Return to Login
        </h1>
    </div> 
   
    <div class="w-full  h-screen flex items-center justify-center ">
        
        <div class="flex flex-col bg-blue-100 rounded shadow-lg p-5 w-auto">
            <x-notification />
            <h1 class="text-center text-base mb-5">Admin Registration</h1>
            <div class="text-center">
                @if($errors->any()) 
                <span class="text-sm text-yellow-500 font-bold">
                    {{$errors->first()}}
                </span>
                @endif
            </div>
            
            <form action="{{route('registerAdmin.Account')}}" class="flex flex-col gap-4" method="POST">
                @csrf
                <div class="flex flex-row items-center gap-4">
                    <div class="flex flex-col">
                        <label for="" class="text-xs">First Name</label>
                        <input type="text"  class=" border-none  text-xs" name="fname" value="{{old('fname')}}">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-xs">Middle Name</label>
                        <input type="text"  class=" border-none  text-xs" name="mname" value="{{old('mname')}}">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-xs">Last Name</label>
                        <input type="text"  class=" border-none  text-xs" name="lname" value="{{old('lname')}}">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-xs">Age</label>
                        <input type="text"  class=" border-none w-20 text-xs" name="age" value="{{old('age')}}">
                    </div>
                </div>
                <div class="flex flex-row items-center  gap-4">
                    <div class="flex flex-col">
                        <label for="" class="text-xs">Email</label>
                        <input type="text"  class=" border-none w-72 w- text-xs" name="email" value="{{old('email')}}">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-xs">Username</label>
                        <input type="text"  class=" border-none  w- text-xs" name="username" value="{{old('username')}}">
                    </div>
                </div>
                <div class="flex flex-row items-center relative form-group gap-4">
                    <div class="flex flex-col relative">
                        <label for="" class="text-xs">Password</label>
                        <input type="password"  class="password border-none w-72 w- text-xs" name="password">
                        <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-6 cursor-pointer revealPassword text-base"></ion-icon>
                    </div>
                    <div class="flex flex-col relative">
                        <label for="" class="text-xs">Confirm Password</label>
                        <input type="password"  class=" border-none password w- text-xs" name="password_confirmation">
                        <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-6 cursor-pointer revealPassword text-base"></ion-icon>
                    </div>
                </div>
                <div class="w-full">
                    <button  class="bg-blue-700 w-full rounded shadow py-2 text-white ">Confirm</button>
                </div>
            </form>
        </div>
    </div>
<script src="{{asset('js/adminScripts2.js')}}"></script>
<x-adminFooter />