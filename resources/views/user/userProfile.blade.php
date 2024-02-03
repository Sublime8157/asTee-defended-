    <x-header />
    {{-- This section is for side  navigation --}}
    <div class="relative flex flex-row" style="background-color: #2b2d31">
        <div class=" left-0 w-48 md:w-64 relative shadow-md sideNav " id="sideNav" >
            <div class="p-2 absolute">
                <ion-icon name="ellipse" class="text-yellow-400 text-sm"></ion-icon>
                <span class="text-sm text-white md:text-xs">{{session('username')}}</span>
            </div>
            <div class="absolute left-48 md:hidden block " id="arrowIcon">
                <div class=" flex justify-center items-center h-screen cursor-pointer sideBarIcon">
                    <ion-icon name="chevron-back-sharp" class="text-2xl" onclick="showSideNav(this)"></ion-icon>
                </div>
            </div>
            <div class="flex  items-center h-screen justify-center flex-col bg-gray-500">
                <ul class="flex flex-col justify-between w-full text-center p-2">
                <a href="/home"> <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 ">Home</li></a>
                    <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 ">Orders</li>
                    <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 bg-gray-400">Settings</li>   
                    <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 ">Password</li>   
                    <a href="/logout"><li class="cursor-pointer text-white py-2 rounded hover:bg-gray-400 ">Logout</li></a>
                </ul>
            </div>
        </div>

        {{-- Profile Settings --}}
        <div class="flex  flex-col h-screen w-screen justify-center items-center " style="background-color: #313338">
           <div class="shadow-lg px-2  text-xs md:text-sm md:px-14  py-4 mx-2 md:w-11/12 w-11/12 h-auto rounded bg-gray-800">   
                <span class="text-start mb-18 mt-10 text-xs md:text-lg text-white mb-10">Profile Settings</span> 
                <hr class="border-t border-gray-500">

                <p>Manage your Account</p>

                    {{-- Show the result of updating   --}}
                            <div id="updateStatus" class="text-center text-red-600 font-bold"></div>
                            

                {{-- Updating user profile Form --}}
                <form action="/updateProfile" class="px-2 md:px-5 py-5 md:py-5 flex flex-wrap items-end  justify-center" method="POST" id="updateForm">
                    {{-- Protect the users input using csrf --}}
                    @csrf
                  <div class="m-5">
                    <label for="Firstname" class="me-2 text-gray-400">Firstname</label>
                    <input type="text" placeholder="{{ $user->fname }}" class="me-5 text-xs h-auto md:text-sm p-1  sm:w-auto md:w-auto w-full md:h-8 md:p-3 border-0 border-b bg-gray-800 text-gray-200" name="fname" autocomplete="off">
                  </div>
                  <div class="m-5">
                    <label for="Firstname" class="me-2 text-gray-400">Middlename</label>
                    <input type="text" placeholder="{{ $user->mname }}" class="me-5 text-xs h-auto md:text-sm p-1  sm:w-auto md:w-auto w-full md:h-8 md:p-3 border-0 border-b bg-gray-800 text-gray-200" name="mname" autocomplete="off">
                  </div>
                  <div class="m-5">
                    <label for="Firstname" class="me-2 text-gray-400">Lastname</label>
                    <input type="text" placeholder="{{ $user->lname }}" class="me-5 text-xs h-auto md:text-sm p-1  sm:w-auto md:w-auto w-full md:h-8 md:p-3 border-0 border-b bg-gray-800 text-gray-200" name="lname" autocomplete="off">
                  </div>
                  <div class="m-5">
                    <label for="Firstname" class="me-2 text-gray-400">Age</label>
                    <input type="text" placeholder="{{ $user->age }}" class="me-5 text-xs h-auto md:text-sm p-1  sm:w-auto md:w-auto w-full md:h-8 md:p-3 border-0 border-b bg-gray-800 text-gray-200" name="age" autocomplete="off">
                  </div>
                  <div class="m-5">
                    <label for="Firstname" class="me-2 text-gray-400">Username</label>
                    <input type="text" placeholder="{{ $user->username }}" class="me-5 text-xs h-auto md:text-sm p-1  sm:w-auto md:w-auto w-full md:h-8 md:p-3 border-0 border-b bg-gray-800 text-gray-200" name="username" autocomplete="off">
                  </div>
                  <div class="m-5">
                    <label for="Firstname" class="me-2 text-gray-400">Email</label>
                    <input type="text" placeholder="Email...." class="me-5 text-xs h-auto md:text-sm p-1  sm:w-auto md:w-auto w-full md:h-8 md:p-3 border-0 border-b bg-gray-800 text-gray-200" name="email" autocomplete="off">
                  </div>
                  <div class="w-full  text-center">
                        <button class="bg-red-700 hover:bg-red-500 rounded w-64 py-1 text-white shadow">Update</button>
                  </div>
             </form>
           </div>
        </div>  
    </div>
    <script src="{{ asset('script2.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>
    </html>