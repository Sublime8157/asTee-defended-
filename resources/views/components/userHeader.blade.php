<x-header />
<div class=" w-full min-h-screen  md:p-10 bg-white md:bg-gray-100 " >
    <div class="flex justify-betweeen  md:justify-evenly  h-full w-full  items-center md:items-start">
        <div class=" flex-col self-start  md:relative top-0 left-0  items-start gap-2 md:w-48 w-16 flex border-r border-gray-100 mt-5 ">
           <div class="flex-row hidden md:flex items-center gap-2">
                <img src="{{asset('storage/images/' . session('profile') )}}" alt="" class="rounded-full" width="50px">
                <p class="text-sm">{{session('username')}}</p>
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

     