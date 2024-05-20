<x-header />


@if(session('verification') == 'not_verified')
    @if(session()->has('submitSuccess'))
    <div class="w-full bg-blue-700  border  py-1  rounded absolute top-0">
        <p class="text-xs md:text-sm text-white text-center">
            {{session()->get('submitSuccess')}}
        </p>
    </div> 
    @else
    <div class="w-full bg-red-200    border border-red-700  py-1 rounded absolute top-0">
        <p class="text-xs md:text-sm text-center">
            To use other mode of payment and other more features please <a onclick="document.getElementById('verifyIDmodal').showModal();" class="cursor-pointer underline text-blue-800 ">Verify Account,</a> please disregard this message if you already submitted your valid ID.
        </p>
    </div>   
    @endif
@endif
<div class=" w-full min-h-screen  md:p-10 bg-white md:bg-gray-100 " >
    <div class="flex justify-betweeen  md:justify-evenly  h-full w-full  items-center md:items-start">
        <div class=" flex-col self-start  md:relative top-0 left-0  items-start gap-2 md:w-48 w-16 flex border-r border-gray-100 mt-5 ">
           <div class="flex-row hidden md:flex items-center gap-2">
                <img src="{{asset('storage/images/' . session('profile') )}}" alt="" class="rounded-full max-h-20" style="width: 80px">
                <p class=" font-bold ">{{session('username')}}</p>
           </div>
           <div class="ps-2 pt-2">
                <ul class="text-sm flex gap-4 flex-col font-bold">
                    <a href="/userProfile/myAccount">
                        <li class="flex items-center gap-1">
                            <ion-icon name="person-outline" class="text-lg font-extrabold text-blue-800"></ion-icon>
                            <span class="hover:text-orange-800 hidden md:flex">My Account</span>
                            <ion-icon name="ellipse" class="text-xs text-gray-500 {{ request()->is('userProfile/myAccount') ? 'block' : 'hidden' }}"></ion-icon>
                        </li> 
                    </a>
                   <a href="{{ route('product.status', ['status' => 1]) }}">
                        <li class="flex items-center gap-1">
                            <ion-icon name="cart-outline" class="text-lg font-extrabold text-orange-800"></ion-icon>
                            <span class="hover:text-orange-800 hidden md:flex">My Purchase</span>
                            <ion-icon name="ellipse" class="text-xs text-gray-500 {{ Route::currentRouteName() == 'product.status' && request()->status <= 4  ? 'block' : 'hidden' }}"></ion-icon>
                        </li>
                   </a>
                   <a href="/userProfile/myPassword">
                        <li class="flex items-center gap-1 flex-row">
                            <ion-icon name="key-outline" class="text-lg font-extrabold text-gray-800"></ion-icon>
                            <span class="hover:text-orange-800 text-sm hidden md:flex">Manage Password</span>
                            <ion-icon name="ellipse" class="text-xs text-gray-500 {{ request()->is('userProfile/myPassword') ? 'block' : 'hidden' }}"></ion-icon>
                        </li>
                   </a>
                   <a href="/home" class="flex items-center gap-1">
                    <ion-icon name="home-outline" class="text-lg text-amber-600 "></ion-icon>
                      <span class="hover:text-orange-800 text-sm hidden md:flex">Home</span></a>
                   <a href="/logout" class="flex items-center gap-1">
                    <ion-icon name="exit-outline" class="text-lg text-gray-500 "></ion-icon>
                      <span class="hover:text-orange-800 text-sm hidden md:flex">Logout</span></a>
                </ul>
           </div>
        </div>
<dialog id="verifyIDmodal" class=" w-100  border-white  h-80"> 
    <div class="justify-betweenz h-full flex flex-row">
        <div class="w-60  px-5  flex justify-center items-center  ">
            <p class="text-xs md:text-sm ">
                AsTee required <b>valid ID</b> for security purposes for both end, so in order to use more features such as <b>Cash On Delivery MOP</b> AsTee requiring customers to verify their account by uploading valid ID
            </p>
        </div>
        <div class="md:px-10 px-5 md:w-72 w-48 flex justify-center items-center flex-col h-full bg-gray-50">
            <div class="relative">
                <img src=""  class="h-32 w-48 bg-white">
                <img src="#" alt="" id="imagePreviewID" class="h-32 w-48 border bg-white rounded absolute  top-0 hidden">
            </div>
            <p class="text-xs text-gray-500">File size: maximum 2 MB <br>
                File extension: .JPEG, .PNG</p>
            <form action="{{ route('upload.validID') }}" class="flex flex-col gap-2 items-center" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="validID" onchange="imagePreviewID(this)" class="ms-6 w-auto  text-xs text-gray-700 text-center h-auto" style="font-size: 0px; ">
                <button type="submit" class="text-xs px-2 py-1 bg-blue-700 w-20 rounded-sm  text-white">Save</button>
            </form>
        </div>
    </div>
</dialog>
     