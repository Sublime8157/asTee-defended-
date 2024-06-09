@props(['userData','sortBy', 'orderBy','sortByClass','searchUsersName','searchUsersId'])
<x-header />
<x-nav />
<x-notification />
@if(session()->has('blocked'))
    <div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
        <ion-icon name="alert-circle-outline" class="font-bold text-red-800 text-lg pe-1"></ion-icon>
        <span class="text-red-800 ">
            {{ session()->get('blocked') }}
        </span>
    </div>
@endif
<div class="p-3">
    {{$userData->links('pagination::simple-tailwind')}}   
</div>
        <div class="my-5 mx-10 bg-white shadow-lg p-5 h-auto  ">
            {{-- Search bars --}}
            <form action="" class="flex justify-between items-center flex-row" >
                <div class="flex flex-row items-center">
                    
                    <div class="relative me-5">
                      <label for="sortBY" class="text-xs ">Sort by:</label>
                      {{-- sort the data by options  --}}
                      <select name="sortBy" id="{{$sortBy}}" class="{{$sortByClass}} shadow text-xs border-gray-100 cursor-pointer">
                            <option value="fname">Name</option>
                            <option value="email">Email</option>
                            <option value="id">ID</option>
                      </select>
                      {{-- sort the data if ascending or descending  --}}
                      <select name="orderBy" id="{{$orderBy}}" class="{{$sortByClass}} shadow text-xs border-gray-100 cursor-pointer">
                            <option value="asc">Ascend</option>
                            <option value="desc">Descend</option>
                      </select>
                    </div>
                   
                </div>
               <div class="relative">
                {{-- search by id, name or email   --}}
                    <input type="search" name="{{$searchUsersName}}" class="ps-6 shadow border border-gray-100 text-xs " placeholder="Search" id="{{$searchUsersId}}">
                    <ion-icon name="search-outline" class="absolute left-0 px-2 py-2"></ion-icon>
                </div>
            </form>
            <hr class="w-full mt-2">
           <div class="flex justify-center">
                <table class="mx-2  text-xs text-center mt-5">
                    <tr>
                        <th></th>
                        <th class="text-left w-80">User</th>
                        <th class="w-10">ID</th>
                        <th class="">Valid ID</th>
                        <th class="w-40">Username</th>
                        <th class="w-40">Date Email Verified</th>
                        <th class="w-40">Action</th>
                    </tr>
                    <tr class="mt-2 mb-5">
                        <td colspan="5"></td>
                    </tr>
                    {{-- list of users  --}}
                   <tbody id="userLists">
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
                                            @if($user->userStatus == 1) 
                                                <a onclick="blockUser({{ $user->id }})" class="hover:bg-gray-400 px-6 text-xs">Block</a>
                                            @else
                                                <a onclick="unblockUser({{ $user->id }})" class="hover:bg-gray-400 px-6 text-xs">Unblock</a>
                                            @endif
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
                            <form  id="unblockUser{{ $user->id }}" action="{{ route('users.unblock', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                            <form  id="verifyUser{{ $user->id }}" action="{{ route('users.verifyID', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                    @endforeach
                   </tbody>
                </table>
               
           </div>
        </div>
    </div>
</div>
<x-adminFooter />