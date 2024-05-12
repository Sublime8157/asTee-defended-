<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #faf9f6">
    <div class="flex flex-col items-center justify-center h-screen w-screen">
        <div class="bg-white rounded shadow-md w-96 py-8 flex flex-col items-center justify-start">
           @if($errors->any())
             {{$errors->first()}}
           @endif
            <h1 class="mb-5 font-bold text-gray-700">Verify Your Email</h1>
            <form action="{{route('verifyAgain')}}" class="flex flex-col gap-4" method="POST">
                @csrf
                    <div class="w-80">
                        <input type="text" class="w-80 text-sm" value="{{$email}}" name="email">
                        <a href="{{route('userLogin')}}" class="text-gray-400 text-xs">Return to Login</a>
                    </div>
                    <button type="submit" class="hover:opacity-70  bg-yellow-400 rounded text-white  py-2 w-full ">Verify</button>
            </form>
        </div>
    </div>
</body>
</html>