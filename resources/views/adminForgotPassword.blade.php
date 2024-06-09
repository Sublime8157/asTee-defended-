<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="shortcut icon" href="{{ asset('images/Logo.ico')}}" type="image/x-icon">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body class="bg-gray-50">
    <div class="flex flex-col mt-20 items-center justify-center  h-96 w-full">
        <h1 class="text-center   font-bold text-5xl  text-blue-400">AsTee</h1>
        <form action="{{route('admin.password.email')}}" class="mt-5 flex flex-col items-start gap-2 bg-white justify-center rounded-md shadow p-5  w-6/12" method="POST">
            <a href="{{ url()->previous() }}"><ion-icon name="arrow-back-outline" class="text-lg font-bold hover:-translate-x-0.5"></ion-icon></a>
            @csrf
           <h1 class="text-lg font-bold text-gray-800 ">Reset Password</h1>
           <div class="w-full">
                <hr class="bg-black w-full">
           </div>
           <div>
                <blockquote><p class="text-sm text-gray-500">To reset your password, please enter your account email address, and a reset form will be sent to your inbox.
                    @if(session()->has('success'))
                        <span class="text-sm text-blue-700">
                           <a href="https://mail.google.com/mail/u/0/#inbox">
                                {{session()->get('success')}}
                           </a>
                        </span>
                    @endif
                </p></blockquote>
           </div>
           <div class="flex flex-col w-full ">
                <label for="">Email</label>
                <input type="text" name="email" id="email" value="{{old('email')}}" class="text-sm w-full rounded"  required> 
                <span class="text-xs text-red-600 font-bold  ps-1">
                    @error('email')
                        {{$message}}
                    @enderror
                </span>
           </div>
           <div class="self-end flex flex-row gap-2 ">
                <button type="button" onclick="window.location.href='{{ url()->previous() }}'" class="hover:opacity-70 text-gray-400 border border-gray-400 rounded py-1 px-2 ">Cancel</button>
                <button type="submit" class="hover:opacity-70 py-1 px-2 rounded bg-blue-600 text-white" id="submitBtn">Submit</button>
           </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>