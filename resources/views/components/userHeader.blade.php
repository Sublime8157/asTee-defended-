<x-header />
<div class=" w-full h-screen p-10" style="background-color:  #f5f5f5;">
    <div class="flex justify-evenly  h-full w-full  items-start">
        <div class="flex flex-col  items-start gap-2 w-48">
           <div class="flex-row flex items-center gap-2">
                <img src="{{asset('images/adminIcon.jpg')}}" alt="" class="rounded-full" width="50px">
                <p class="text-sm">{{session('username')}}</p>
           </div>
           <div>
                <ul class="text-sm flex gap-4 flex-col font-bold">
                    <a href="/userProfile/myAccount">
                        <li class="flex items-center gap-1">
                            <ion-icon name="person-outline" class="text-lg font-extrabold text-blue-800"></ion-icon>
                            <span class="hover:text-orange-800">My Account</span>
                            <ion-icon name="ellipse" class="text-xs text-gray-500 {{ request()->is('userProfile/myAccount') ? 'block' : 'hidden' }}"></ion-icon>
                        </li> 
                    </a>
                   <a href="/userProfile/myPurchase">
                        <li class="flex items-center gap-1">
                            <ion-icon name="cart-outline" class="text-lg font-extrabold text-orange-800"></ion-icon>
                            <span class="hover:text-orange-800">My Purchase</span>
                            <ion-icon name="ellipse" class="text-xs text-gray-500 {{ request()->is('userProfile/myPurchase') ? 'block' : 'hidden' }}"></ion-icon>
                        </li>
                   </a>
                   <a href="/userProfile/myPassword">
                        <li class="flex items-center gap-1 flex-row">
                            <ion-icon name="key-outline" class="text-lg font-extrabold text-gray-800"></ion-icon>
                            <span class="hover:text-orange-800 text-sm">Manage Password</span>
                            <ion-icon name="ellipse" class="text-xs text-gray-500 {{ request()->is('userProfile/myPassword') ? 'block' : 'hidden' }}"></ion-icon>
                        </li>
                   </a>
                   <a href="/home" class="flex items-center gap-1">
                    <ion-icon name="home-outline" class="text-lg text-amber-600 "></ion-icon>
                      <span class="hover:text-orange-800 text-sm">Home</span></a>
                   <a href="/logout" class="flex items-center gap-1">
                    <ion-icon name="exit-outline" class="text-lg text-gray-500 "></ion-icon>
                      <span class="hover:text-orange-800 text-sm">Logout</span></a>
                   
                </ul>
           </div>
        </div>

     