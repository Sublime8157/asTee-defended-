@section('docu', 'Find User')
<x-login /> 
        <div class="flex flex-col md:bg-white rounded  items-start h-auto  justify-start w-full md:w-5/12">
            <h1 class="font-bold text-xl py-4 ps-4  text-gray-600 ">Find your account</h1>
            <hr class="bg-gray-100 w-full">
           <div class="p-4 w-full h-full flex flex-col gap-2">
                <p class="font-thin ">Lets try to find your account, you can use your email or username for searching</p>
                    @if(session()->has('noResult'))       
                        <p class="p-2 bg-red-200 text-sm  border border-red-400    rounded ">
                            {{session()->get('noResult')}}
                        </p>
                    @elseif($errors->any()) 
                        <p class="p-2 bg-red-200 text-sm  border border-red-400    rounded ">
                            {{$errors->first()}}
                        </p>
                    @endif
                <form action="{{route('submit.search')}}" class="w-full gap-4 px-2 h-full flex flex-col justify-around" method="POST">
                    @csrf
                    <input type="text" class="w-full  rounded-md" name="search">
                    <div class="self-end flex gap-4 flex-row ">
                        <button type="button" onclick="window.location.href='{{route('userLogin')}}'" class="rounded px-2 py-1 w-20 border  hover:opacity-70  bg-gray-200">Cancel</button>
                        <button type="submit" class="bg-yellow-500 text-white hover:opacity-70 rounded px-2 py-1 w-20 ">Search</button>
                    </div>
                </form>
           </div>
        </div>
    </div>