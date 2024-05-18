<x-userHeader />
    <div class="bg-white p-5  md:h-auto h-screen md:w-8/12 w-screen">
        <h3 class="font-bold text-blue-800">My Profile</h3>
        <h6 class="font-light text-gray-500 text-sm">Manage your Account</h6>
        <div class="text-center text-sm text-yellow-500">
                @if(session()->has('success'))
                {{session()->get('success')}}
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
                        <label for="" class="text-sm me-2 text-gray-500">Birthday</label>
                        <label for="" class="text-sm me-2 text-gray-500">Email</label>
                        <label for="" class="text-sm me-2 text-gray-500">Address</label>
                        <label for="" class="text-sm me-2 text-gray-500">Contact</label>
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
                            <input type="text" value="{{$user->birthday}}" class="w-60 md:w-80 h-8 text-xs md:text-sm border-none" disabled>
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm border-none" name="email" value="{{$user->email}}" disabled>
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="address" placeholder="{{$user->address}}">
                            <input type="text" class="w-60 md:w-80 h-8 text-xs md:text-sm" name="contact" placeholder="{{$user->contact}}">
                            <button class="bg-orange-600 text-white py-2 px-4 hover:opacity-60 w-60 md:w-80 h-8 text-xs md:text-sm">Save</button>
                    </div>
                </form>
               </div>
            </div>
            {{-- upload image  --}}
            <div class="w-40 md:w-80 gap-2  mb-10 lg:mb-0 lg:self-start flex items-center lg:border-l h-full flex-col justify-center">
                @if($errors->any())
                <div class="text-center text-xs font-bold text-orange-700">
                    {{$errors->first()}}
                </div>
                 @endif
                <div class="relative">
                    <img src="{{ asset('storage/images/' . $user->profile )}} "  class="rounded-full  h-20 w-20">
                    <img src="#" alt="" id="imagePreview" class="w-20 h-20 absolute rounded-full top-0 hidden">
                </div>
                
                <p class="text-xs text-gray-500">File size: maximum 2 MB <br>
                    File extension: .JPEG, .PNG</p>
                    {{-- enctype is important when handling image upload unless it was in ajax  --}}
                    <form action="{{ route('update.profile') }}" class="flex flex-col gap-2 items-center" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="profile" onchange="imagePreview(this)" class="ms-6 w-auto  text-xs text-gray-700 text-center h-auto" style="font-size: 0px; ">
                        <button type="submit" class="text-xs px-2 py-1 bg-blue-700 w-20 rounded-sm  text-white">Save</button>
                    </form>
            </div>
        </div>
    </div>
<x-userFooter />