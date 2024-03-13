
@extends('components.header')
@section('docu', 'Login')
<x-header />
<body class="bg-blue-100 ">
  <x-navbar />
  {{-- This is Login Section --}}
  @if(session('isLoggedin') != true)
    <div class=" flex justify-evenly flex-col  md:flex-row items-center h-screen w-full">
          <div class="">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="400px" height="400px">
          </div>
          <div>
            <div class="bg-white p-5  rounded shadow-lg w-96 h-auto">
              {{-- Show error for login form validation --}}
              @if ($errors->any())
              <div class="text-center text-xs text-red-600 font-bold">
                {{ $errors->first() }}
              </div>
            @endif
            {{-- Login Form --}}
            <h1 class="text-lg font-bold mb-2">Login</h1>
              <form action="login/process" class="ms-2" method="POST">
                    @csrf
                      <label for="username" class="text-sm">Username:</label>
                      <br><input type="text" name="username" placeholder="astee812" value="{{ old('username') }}" class="w-full rounded focus:outline-0 focus:outline-blue-300 border-b-gray-300 border-x-0 border-t-0 text-sm">
                      <br> <label for="password" class="text-sm">Password:</label> <br>
                      <div class="relative">
                      <input type="password" name="password" placeholder="******" value="{{ old('password') }}" class=" password w-full rounded focus:outline-0 focus:outline-blue-300 border-b-gray-300 border-x-0 border-t-0 text-sm">
                      <ion-icon name="eye-off-outline" class="absolute cursor-pointer right-5 bottom-3 font-bold revealPassword"></ion-icon>
                      </div>                  
                      <br>
                      <button type="submit" class="bg-yellow-400 w-full p-1 rounded text-black mt-5  hover:bg-yellow-300 text-sm">Submit</button>
                      <h6 class="font-thin text-gray-400 text-center mt-3 text-xs">Dont have an account yet? <span class="underline cursor-pointer text-blue-600 hover:tracking-wide hover:text-blue-900" id="signup" onclick="revealForm()">Signup</span></h6>
                </form>
            </div>
          </div>
    </div>
    {{-- The Login section ends here --}}

    {{-- This is the registration section --}}
    <dialog class="  absolute   inset-0 mt-20 modal" id="signup_container">
      {{-- Show error form for registration form --}}    
        <div class="container w-96  bg-blue-50 h-auto m-auto rounded shadow-lg p-5 pb-10">

          {{-- Show this errorMessage when error occured --}}
          <div id="errorMessage" class="text-xs text-red-500 text-center">  </div>
              <div class="flex justify-between">
                  <h1 class="text-lg font-bold mb-2">Signup</h1>
                  <div class="cursor-pointer p-1 text-xs  hover:font-bold" id="escape">ESC</div>
            </div>
           
            {{-- Form for registration/singup --}}
            <form action="/store" method="POST" class="flex flex-wrap" id="regForm">
              @csrf
                <input type="text" value="1" class="hidden" name="userStatus">
                <input type="text" name="fname" placeholder="Firstname" class="w-80 m-1 p-2 border-none text-xs rounded focus:outline-blue-50" > 
                <input type="text" name="mname" placeholder="Middlename" class="w-80 m-1 p-2  border-none text-xs rounded focus:outline-blue-50" >   
                <input type="text" name="lname" placeholder="Lastname" class="w-80 m-1 p-2 border-none text-xs rounded focus:outline-blue-50" >
                <input type="text" name="age" placeholder="Age" class="w-14 p-2 m-1  border-none text-xs rounded focus:outline-blue-50" >
                <input type="text" name="email" placeholder="Email" class="w-64 p-2 m-1  border-none text-xs rounded focus:outline-blue-50" >
                <input type="text" name="address" placeholder="Address" class="w-80 p-2 m-1 border-none text-xs rounded focus:outline-blue-50" >  
                <input type="text" name="username" placeholder="Username" class="w-80  m-1 p-2 border-none text-xs rounded focus:outline-blue-50" >
                <div class="relative">
                  <input type="password" name="password" placeholder="Password"  class="w-80  password m-1 p-2 border-none text-xs rounded focus:outline-blue-50" >
                  <ion-icon name="eye-off-outline" class="absolute cursor-pointer right-5 bottom-3 font-bold revealPassword"></ion-icon>
                </div>
                <input type="password" name="password_confirmation"  placeholder="Confirm Password" class=" password w-80 p-2 m-1 border-none text-xs rounded focus:outline-blue-50" >
                <button class="text-center bg-yellow-400 w-80 m-1 p-2 text-sm rounded hover:bg-yellow-300 " id="submitRegister">Submit</button>
            </form>
            
            {{-- Reveal this when storing is success --}} 
            <div class="absolute  hidden top-32 w-auto z-50 bg-white shadow-lg" id="successMessage" style="left: 1rem" >
                <div class="bottom-0  rounded w-90" >
                  <div class="absolute  overflow-visible right-36" style="top: -30px;">
                    <ion-icon name="checkmark-circle-outline" class="text-6xl text-white bg-green-400 rounded-full font-extralight"></ion-icon>
                  </div>
                  <div class="text-center font-extralight italic text-sm px-5 pt-10 pb-4">
                      <p>
                      <span class="text-lg"> Congratulations!</span> <br> <br>
                        You are successfully registered, <br> happy customizing and shopping in A's Tee 
                      </p>
                  </div>
                  <div class="flex justify-evenly pb-5">
                      <a href="/"><button class="px-2 py-2 bg-green-400 text-sm font-extralight rounded text-white hover:bg-green-200" onclick="revealForm()">
                        Proceed to Login
                      </button>
                      </a>
                  </div>
                </div>
            </div>
              
        </div>
      </dialog>
  @endif
  <script src="{{ asset('script1.js') }}">
   
  </script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
  </body>
  </html>