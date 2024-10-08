<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrator</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
</head>
    <body>
        {{-- Container  --}}
        <div class="absolute w-full mt-5 text-center">
            <div class="w-full items-center "> 
                @if(session()->has('success'))
                    <span class="text-yellow-500 text-sm "> 
                        {{session()->get('success')}} 
                    </span>
                @endif
            </div>
        </div>
             <div class="flex items-center flex-col  justify-center w-screen h-screen">
                  
                    {{-- Form Starts Here --}}
                    <form action="/loggingIn" class="w-auto relative flex items-center justify-center bg-blue-100 p-10   rounded-lg flex-col shadow-2xl" method="POST">
                        @csrf
                        {{-- User Icon  --}}
                        <div class="absolute" style="top: -70px">
                                <img src="{{ asset('images/adminIcon.jpg') }}" alt="" width="100" class="rounded-full">
                        </div>
                        <div class="mb-5">
                                <h3 class="font-normal text-xl tracking-wide">
                                    Administrator
                                </h3>
                        </div>
                        {{-- errors  --}}
                        @if ($errors->any())
                            <div class="max-w-full text-xs  p-2 rounded border border-red-400 bg-red-200">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        {{-- Username input --}}
                        <div class="mb-5 w-full">
                                <label for="" class="font-bold text-sm ">Username</label> <br>
                                <ion-icon name="person" class="absolute p-2 mt-1 text-lg font-extrabold text-gray-700"></ion-icon>
                                <input type="text" name="username" value="{{ old('username') }}" class=" rounded-md  ps-8 py-2  w-64 md:w-96  outline-none border-none shadow-sm" >
                        </div> 
                        {{-- Password input --}}
                        <div class="relative form-group">
                                <label for="" class="font-bold text-sm ">Password</label> <br>
                                <ion-icon name="lock-closed" class="absolute mt-1 p-2 text-lg font-extrabold text-gray-700"></ion-icon>
                                <input type="password" name="password" class="password runded-md ps-8 py-2 w-64 md:w-96 outline-none border-none shadow-sm" autocomplete="off">
                                <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-9 cursor-pointer revealPassword text-lg"></ion-icon>
                        </div>
                        {{-- Forgot Password --}}
                        <div class="self-start mt-2 flex justify-between items-center w-full">
                                <span>
                                    <a href="/adminforgotPassword" class="underline text-xs text-gray-400 font-bold">Forgot Password?</a>
                                </span>
                                <span>
                                    <a href="{{route('registration')}}" class="underline text-xs text-gray-400 font-bold">Register an Account?</a>
                                </span>
                        </div>
                        {{-- Button --}}
                        <div class="mt-5">
                                <button type="submit" class="w-64 md:w-96 bg-blue-800 text-white rounded-md p-2  hover:bg-blue-500 shadow-lg">Submit</button>
                        </div>
                    </form>
                </div>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script>$('.revealPassword').on('click', function(){
            var password = $(this).closest('.form-group').find('.password');
            var icon = $(this);
        
            if(password.prop('type') === 'password') {
                password.prop('type', 'text');
                icon.attr('name','eye-outline');
            }
            else {
                password.prop('type', 'password');
                icon.attr('name', 'eye-off-outline');
            }
        })</script>
    </body>  

</html>