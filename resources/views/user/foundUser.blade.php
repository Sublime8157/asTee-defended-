<x-header />
<body class="h-screen bg-blue-50 ">
    <div class="h-full shadow items-center flex justify-start md:justify-center mt-5 md:mt-0  flex-col ">
        <h1 class="font-bold text-blue-500 text-4xl mb-4">AsTee</h1>
        <div class="flex flex-col  rounded gap-2 items-center h-auto px-4 pb-4 justify-start mx-1 w-auto">
            <h1 class="self-start font-bold text-lg pt-4  text-gray-600 ">Forgot Password</h1>
            <hr class="bg-gray-100 w-full ">
            {{-- This page used to list every partial match of what was typed —
                 profile photo, username and email in an editable input, with a
                 send button next to each. It says the same thing now whether or
                 not the account exists. --}}
            <div class="flex flex-row items-center  gap-4 ">
                <img src="{{ asset('images/sentIcon.jpg') }}" alt="" class="w-16 h-16 rounded-full">
                <p class="text-sm ">
                    If an account matches what you entered, a password reset link is on its way.
                    Please check your email <a href="https://mail.google.com/mail/u/0/#inbox" class="text-blue-500 underline">inbox</a>
                    or your spam folder, thank you.
                </p>
            </div>
            <a href="{{ route('findUser') }}" class="text-sm text-blue-700 hover:underline self-start">Try a different account</a>
           </div>
        </div>
    </div>
</body>
