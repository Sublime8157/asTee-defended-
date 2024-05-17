<x-header />
<body class="h-screen bg-blue-50 ">
    <div class="md:h-96 h-full  items-center flex justify-between md:mt-0  flex-col ">
        <header class="hidden md:block h-40">
            <nav class="w-screen shadow-md py-2 px-4   bg-white rounded flex items-center flex-row justify-between ">
                <div class="ms-10">
                    <h1 class="text-2xl font-bold text-blue-500 italic ">AsTee</h1>
                </div>
                <form action="{{route('loginProcess')}}" class="gap-6 flex flex-row justify-between items-center" method="POST">
                    @csrf
                        <div>
                            <label for="" class="font-bold" >Username</label>
                            <input type="text" class="text-sm rounded" name="username">
                        </div>
                        <div>
                            <label for="Password" class="font-bold" >Password</label>
                            <input type="password" class="text-sm rounded" name="password">
                        </div>
                        <div>
                            <button class="py-1 px-2 rounded bg-yellow-500 text-white w-24">Submit</button>
                        </div>
                </form>
            </nav>
        </header>   
    

    

