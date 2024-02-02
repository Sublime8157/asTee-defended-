    <x-header />
    {{-- This section is for side  navigation --}}
    <div class="relative flex flex-row" style="background-color: #2b2d31">
        <div class=" left-0 w-48 md:w-64 relative shadow-md" id="sideNav" >
            <div class="p-2 absolute">
                <ion-icon name="ellipse" class="text-yellow-400 text-sm"></ion-icon>
                <span class="text-sm text-white md:text-xs">{{session('username')}}</span>
            </div>
            <div class="absolute left-36 md:hidden block " id="arrowIcon">
                <div class=" flex justify-center items-center h-screen cursor-pointer sideBarIcon">
                    <ion-icon name="chevron-back-sharp" class="text-2xl" onclick="showSideNav(this)"></ion-icon>
                </div>
            </div>
            <div class="flex  items-center h-screen justify-center  flex-col" >
                <ul class="flex flex-col justify-between w-full text-center p-2">
                <a href="/home"> <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 ">Home</li></a>
                    <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 ">Orders</li>
                    <li class="cursor-pointer py-2 rounded text-white hover:bg-gray-400 bg-gray-400">Settings</li>      
                    <a href="/logout"><li class="cursor-pointer text-white py-2 rounded hover:bg-gray-400 ">Logout</li></a>
                </ul>
            </div>
        </div>
        <div class="flex  flex-col h-screen w-screen items-center " style="background-color: #313338">
            <span class="text-center mb-18 mt-10 text-3xl text-white mb-10">Profile Settings</span>
           <div class="shadow-lg p-2 mx-2 first-letter:w-auto h-auto rounded bg-gray-800">   
                   
           </div>
        </div>  
    </div>
    <script src="{{ asset('script2.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>
    </html>