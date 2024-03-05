@extends('components.header')
@section('docu', 'Accounts')
@section('page','Active Accounts')
<x-header />
<x-nav />
@if(session()->has('success'))
    <div class=" text-xs mt-5  font-bold tracking-wider flex items-center justify-center">
        <ion-icon name="alert-circle-outline" class=" text-red-800 text-lg pe-1"></ion-icon>
        <span class="text-red-800 ">
            
            {{ @session()->get('success') }}
        </span>
    </div>
@endif
        <div class="my-5 mx-10 bg-white shadow-lg p-5 h-screen ">
            {{-- Search bars --}}
            <form action="" class="flex justify-between items-center flex-row" >
                <div class="flex flex-row items-center">
                    
                    <div class="relative me-5">
                      <label for="sortBY" class="text-xs ">Sort by:</label>
                      {{-- sort the data by options  --}}
                      <select name="sortBy" id="sortBy" class="sortBy shadow text-xs border-gray-100 cursor-pointer">
                            <option value="fname">Name</option>
                            <option value="email">Email</option>
                            <option value="id">ID</option>
                      </select>
                      {{-- sort the data if ascending or descending  --}}
                      <select name="orderBy" id="orderBy" class="sortBy shadow text-xs border-gray-100 cursor-pointer">
                            <option value="asc">Ascend</option>
                            <option value="desc">Descend</option>
                      </select>
                    </div>
                   
                </div>
               <div class="relative">
                {{-- search by id, name or email   --}}
                    <input type="search" name="searchAll" class="ps-6 shadow border border-gray-100 text-xs " placeholder="Search" id="searchUser">
                    <ion-icon name="search-outline" class="absolute left-0 px-2 py-2"></ion-icon>
                </div>
            </form>
            <hr class="w-full mt-2">
           <div class="flex justify-center">
                <table class="mx-2  text-xs text-center mt-5">
                    <tr>
                        <th class="text-left w-96">User</th>
                        <th>ID</th>
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
                        <tr class="">                      
                            <td class="flex justify-center items-center text-left pe-52 w-96">                          
                                <div class="me-1">
                                    <img src=" {{ asset('images/adminIcon.jpg') }}" alt="" width="60">
                                </div>
                            <div>
                                <span class=" text-sm font-bold">{{ $user->fname . " ". $user->lname }}</span> <br>
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
                                {{-- elippses button that shows edit and remove option --}}
                                <button type="button" onclick="showMenus({{ $user->id }})">
                                    <div class="relative">
                                        <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                                        <div class="absolute hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $user->id }}">
                                            <a onclick="showUpdateForm({{ $user->id }})" class="hover:bg-gray-400 px-6 text-xs">Edit</a>
                                          {{-- set the user id to removeUser parameter to pass it to adminScripts--}}
                                            <a href="#" onclick="removeUser({{ $user->id }})" class="hover:bg-gray-400 px-2 text-xs">Remove</a>
                                            
                                        </div>
                                    </div>
                                </button>
                                
                               
                                {{-- form for updating and removing the data --}}
                                <dialog id="updateUser{{$user->id}}">
                                    <form action="">
                                        <h1>{{ $user->id }}</h1>
                                    </form>                   
                                </dialog>                       
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><hr></td>
                        </tr>
                    @endforeach
                   </tbody>
                </table>
               
           </div>
        </div>
    </div>
</div>
<x-adminFooter />