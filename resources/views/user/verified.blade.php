<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verified</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-orange-100">
    <div class="flex items-center  justify-center h-screen w-full">
        <div class="rounded shadow-md bg-white p-10 h-80 my-5 flex-col flex items-center justify-center gap-5">
            <img src="{{asset('images/checkIcon.png')}}" alt="" width="120">
            <div class="flex flex-col items-center justify-center">
                <h1 class="font-bold text-gray-800 text-2xl mb-2">Verified!</h1>
                <p class="text-center text-sm text-gray-400">You have successfully verified your Email, <br> thank you for choosing a'sTee</p>
            </div>
            <button class="hover:opacity-70 bg-orange-400 w-full py-2 text-white rounded shadow " onclick="window.location.href='{{route('userLogin')}}'" >Proceed To Login</button>

        </div>
    </div>  
</body>
</html>