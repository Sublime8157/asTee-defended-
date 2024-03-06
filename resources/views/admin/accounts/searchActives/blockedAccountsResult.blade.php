@foreach($userData as $user)
<tr>                
    <td><img src=" {{ asset('images/adminIcon.jpg') }}" alt="" width="60"></td>      
    <td class=" w-80 text-left">                          
        <div class="me-1">
            
        </div>
        <div>
            <span class="text-sm font-bold">{{ $user->fname . " ". $user->lname }}</span> <br>
            <span style="font-size: 10px">{{$user->email}}</span>
        </div>                                                                       
    </td>
    <td>{{ $user->id }}</td>
    <td>{{ $user->username }}</td>
    <td>{{$user->email_verified_at}}</td>
    <td>
        
        {{-- remove the specific id pass the id to users.destory usng the action and the controller will recieve the id given  --}}
        <form id="removeForm{{ $user->id }}" action="{{ route('users.destroy',  $user->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <form  id="unblockUser{{ $user->id }}" action="{{ route('users.unblock', $user->id) }}" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
            
        </form>
        {{-- elippses button that shows edit and remove option --}}
        <button type="button" onclick="showMenus({{ $user->id }})">
            <div class="relative">
                <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                <div class="absolute hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $user->id }}">
                    
                    <a onclick="unblockUser({{ $user->id }})" class="hover:bg-gray-400 px-6 text-xs">Unblock</a>
                  {{-- set the user id to removeUser parameter to pass it to adminScripts--}}

                    <a onclick="removeUser({{ $user->id }})" class="hover:bg-gray-400 px-2 text-xs">Remove</a>
                    
                </div>
            </div>
        </button>
        
       
        {{-- form for updating and removing the data --}}
                  
    </td>
</tr>
<tr>
    <td colspan="5"><hr></td>
</tr>
@endforeach