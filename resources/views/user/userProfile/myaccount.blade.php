<x-userHeader />
    <div class="bg-white p-5  md:h-auto h-screen md:w-8/12 w-screen">
        <h3 class="font-bold text-blue-800">My Profile</h3>
        <h6 class="font-light text-gray-500 text-sm">Manage your Account</h6>
        <div class="text-center text-sm text-yellow-500">
                @if(session()->has('success'))
                {{@session()->get('success')}}
        @endif
        </div>
         {{-- Show the result of updating   --}}
         <div id="updateStatus" class="text-center text-red-600 font-bold"></div>
        <hr class="mt-4 mb-8">
        <div class="w-full    justify-between lg:justify-evenly flex items-center flex-col-reverse lg:flex-row ">
            <div class="flex-col justify-center items-center flex gap-9 w-full">
               <div class="flex justify-center gap-2 items-center flex-row">
                {{-- labels  --}}
                    <div class=" gap-8 flex-col md:flex hidden">
                        <label for="" class="text-sm me-2 text-gray-500">Username</label>
                        <label for="" class="text-sm me-2 text-gray-500">Firstname</label>
                        <label for="" class="text-sm me-2 text-gray-500">Middlename</label>
                        <label for="" class="text-sm me-2 text-gray-500">Lastname</label>
                        <label for="" class="text-sm me-2 text-gray-500">Email</label>
                        <label for="" class="text-white">Submit</label>
                        {{-- <label for="" class="text-sm me-2 text-gray-500">Address</label> --}}
                    </div>
                    {{-- inputs  --}}
                    <form action="/updateProfile" method="POST">
                    <div class="flex flex-col gap-5 items-center">
                            @csrf
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="username" placeholder="{{$user->username}}">
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="fname" placeholder="{{$user->fname}}">
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="mname" placeholder="{{$user->mname}}">
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="lname" placeholder="{{$user->lname}}">
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="email" placeholder="{{$user->email}}">
                            {{-- <input type="text" class="w-80 h-8 text-sm" name="age" placeholder="{{$user->age}}"> --}}
                            {{-- <input type="text" class="w-80 h-8 text-sm" value="{{$user->address}}"> --}}
                            <button class="bg-orange-600 text-white py-2 px-4 hover:opacity-60 w-60 md:w-80 h-8 text-xs md:text-sm">Save</button>
                    </div>
                </form>
               </div>
            </div>
            {{-- upload image  --}}
            <div class="w-40 md:w-80 mb-10 lg:mb-0 lg:self-start flex items-center lg:border-l h-full flex-col justify-center">
                <img src="{{asset('images/adminIcon.jpg')}}" alt="" width="100px">
                <button class="border px-2 text-sm py-1">Change Image</button>
            </div>
        </div>
    </div>
<x-userFooter />