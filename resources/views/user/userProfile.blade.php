    <x-header />
    <div class="  left-0  bg-gray-300 w-48 relative  h-screen rounded pt-2 shadow" id="sideNav">
        <div class="p-2 absolute">
            <ion-icon name="ellipse" class="text-yellow-400 text-sm"></ion-icon>
            <span class="text-sm">{{session('username')}}</span>
        </div>
    <div class="absolute  top-80 cursor-pointer sideBarIcon" style="right: -21px;">
            <ion-icon name="chevron-back-sharp" class="text-2xl" onclick="showSideNav(this)"></ion-icon>
        </div>
        <div class="flex  items-center h-full    justify-center  flex-col" >
            <ul class="flex flex-col justify-between w-full text-center">
               <a href="/home"> <li class="cursor-pointer py-2 rounded hover:bg-gray-400 ">Home</li></a>
                <li class="cursor-pointer py-2 rounded hover:bg-gray-400 ">Orders</li>
                <li class="cursor-pointer py-2 rounded hover:bg-gray-400 bg-gray-400">Settings</li>      
                <a href="/logout"><li class="cursor-pointer py-2 rounded hover:bg-gray-400 ">Logout</li></a>
                <a href="">Just a test </a>
                    <a href="">This is just a test </a>
            </ul>
        </div>
    </div>



    <script src="{{ asset('script2.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>
    </html>