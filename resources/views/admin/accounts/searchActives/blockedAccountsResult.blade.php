@foreach($userData as $user)
<tr>                
    <td><img src=" {{ asset('storage/images/' . $user->profile) }}" alt=""  class="w-16 h-16 rounded-full"></td>      
    <td class=" w-80 text-left">                          
        <div class="me-1">
            
        </div>
        <div>
            <div class="flex flex-row gap-1 ">
                <span class="text-sm font-bold">{{ $user->fname . " ". $user->lname }}</span> 
                @if($user->verification == 'verified')
                <img src="{{asset('images/verify.png')}}" alt="" class="h-4 w-4"> 
                @endif
            </div>
            <span style="font-size: 10px">{{$user->email}}</span><br>
            <span style="font-size: 10px">{{$user->address}}</span>
        </div>                                                                       
    </td>
    <td>{{ $user->id }}</td>
    <td class="">
        <img src="{{asset('storage/images/' . $user->validID)}}"  alt="No ID" alt="" onclick="document.getElementById('showValidID' + {{$user->id}}).showModal();" class="cursor-pointer rounded h-12 w-12">
        <dialog id="showValidID{{$user->id}}"> 
            <img src="{{asset('storage/images/' . $user->validID)}}" alt="" class="h-96 w-80">
        </dialog>
    </td>
    <td>{{ $user->username }}</td>
    <td>{{$user->email_verified_at}}</td>
    <td>
        {{-- elippses button that shows edit and remove option --}}
        <button type="button" onclick="showMenus({{ $user->id }})" >
            <div class="relative z-20">
                <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $user->id }}">
                    <a onclick="blockUser({{ $user->id }})" class="hover:bg-gray-400 px-6 text-xs">Block</a>
                  {{-- set the user id to removeUser parameter to pass it to adminScripts--}}
                    <a onclick="removeUser({{ $user->id }})" class="hover:bg-gray-400 px-4 text-xs">Remove</a>
                    @if($user->verification == 'not_verified')
                    <a onclick="document.getElementById('verifyUser' + {{$user->id}}).submit();" class="hover:bg-gray-400 px-4 text-xs">Verify</a>
                    @endif
                </div>
            </div>
        </button>
        {{-- form for updating and removing the data --}}
                  
    </td>
</tr>
<tr>
    <td colspan="5"><hr></td>
</tr>
{{-- forms here  --}}
    {{-- remove the specific id pass the id to users.destory usng the action and the controller will recieve the id given  --}}
    <form id="removeForm{{ $user->id }}" action="{{ route('users.destroy',  $user->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <form  id="blockUser{{ $user->id }}" action="{{ route('users.block', $user->id) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>
    <form  id="verifyUser{{ $user->id }}" action="{{ route('users.verifyID', $user->id) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>
@endforeach