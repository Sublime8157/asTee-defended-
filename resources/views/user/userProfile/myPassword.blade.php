<x-userHeader />
<div class="bg-white md:self-start mb-80 self-center  p-5 w-auto md:w-8/12">
    <span class="text-yellow-500 font-bold text-sm text-center w-full flex  flex-row justify-center ">
        @if($errors->any()) 
            {{$errors->first()}}
        @elseif(session()->has('Fail'))
            {{session()->get('Fail')}}
        @elseif(session()->has('success'))
            {{ session()->get('success') }}
        @endif
    </span>
    <h3 class="font-bold text-gray-800">My Password</h3>
    <h6 class="font-light text-gray-500 text-sm">Secure my password</h6>
    <hr class="mt-4 mb-8">
    <div class="w-full justify-evenly gap-2 flex items-start flex-row ">
        <div class="flex flex-col md:text-base text-xs gap-2">
            <label for="password" class="text-xs md:text-base h-8">Old Password</label>
            <label for="password" class="text-xs md:text-base h-8">New Password</label>
            <label for="" class="text-xs md:text-base h-8">Confirm  Password</label>
        </div>
        <div>
            <form action="{{route('userChange.Password')}}" class="w-full flex flex-col gap-2 " method="POST">
                @csrf
                <div class="w-full form-group relative">
                    <input type="password" name="oldPassword" class="password md:text-sm text-xs h-8 w-60 md:w-96 border-gray-300">
                    <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-2 cursor-pointer revealPassword text-xs md:text-base"></ion-icon>
                </div>
                <div class="w-full form-group relative">
                    <input type="password" name="newPassword" class="password md:text-sm text-xs h-8 w-60 md:w-96 border-gray-300">
                    <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-2 cursor-pointer revealPassword text-xs md:text-base"></ion-icon>
                </div>
               <div class="w-full form-group relative">
                    <input type="password" name="confirmPassword" class="password md:text-sm text-xs h-8 w-60 md:w-96 border-gray-300">
                    <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-2 cursor-pointer revealPassword text-xs md:text-base"></ion-icon>
                </div>
                <button class="md:text-base text-xs bg-orange-700 text-white px-2 py-1 md:px-4 md:py-2 rounded-sm w-full">Submit</button>
            </form>
        </div>
    </div>
   
</div>
<x-userFooter />