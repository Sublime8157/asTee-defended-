<x-header />
<body class="h-screen bg-blue-50 ">
    <div class="h-full shadow items-center flex justify-start md:justify-center mt-5 md:mt-0  flex-col ">
        <h1 class="font-bold text-blue-500 text-4xl mb-4">AsTee</h1>
        <div class="flex flex-col  rounded gap-2 items-center h-auto px-4 pb-4 justify-start mx-1 w-auto">
            <h1 class="self-start font-bold text-lg pt-4  text-gray-600 ">Forgot Password</h1>
            @if(session()->has('userData'))
                <hr class="bg-gray-100 w-full">
                <h1 class="text-lg text-blue-900 font-bold">Was this you?</h1>
                @foreach (session()->get('userData') as $user)
                        <img src="{{asset('storage/images/' . $user->profile)}}" alt=""  class="w-32 h-32 rounded-full">
                        <div class="flex flex-row gap-2">
                            <h6 class="text-sm text-gray-800">{{$user->username}}</h6>
                            <a href="{{route('findUser')}}" class="text-sm text-blue-700 hover:underline">Not me</a>
                        </div>
                        <p class="text-sm p-4">
                            We'll be verifying your account using your email 
                            please make sure  this account was you. @if(session()->has('success')) {{session()->get('success')}} @endif
                        </p>
                        <form action="{{route('user.password.email')}}" class="flex-col flex w-full px-2 gap-2" method="POST">
                            @csrf
                            <input type="text" value="{{$user->email}}" class="w-full rounded" name="email">
                            <button type="submit" class="w-full bg-yellow-400 text-white font-bold py-2 ">Send Email</button>
                        </form>
                @endforeach
                @elseif(session()->has('success'))
                    <hr class="bg-gray-100 w-full ">
                    <div class="flex flex-row items-center  gap-4 ">
                        <img src="{{asset('images/sentIcon.jpg')}}" alt="" class="w-16 h-16 rounded-full"> 
                        <p class="text-sm ">Successfully sent to your email, please kindly check your email <a href="https://mail.google.com/mail/u/0/#inbox" class="text-blue-500 underline">inbox</a> or check your spam messages, thank you. </p>
                    </div>
                @endif
            
           </div>   
        </div>
    </div>
<body>
</html>