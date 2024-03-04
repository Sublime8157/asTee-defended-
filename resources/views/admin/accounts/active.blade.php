@extends('components.header')
@section('docu', 'Accounts')
@section('page','Active Accounts')
<x-header />
<x-nav />
        <div class="my-5 mx-10 bg-white shadow-lg p-5 h-screen ">
            {{-- Search bars --}}
            <form action="" class="flex justify-between items-center flex-row">
                <div class="flex flex-row items-center">
                    <div class="relative me-5">
                        <input type="search" name="searchById" class="ps-6 shadow border border-gray-100 text-xs " placeholder="Search Name">
                        <ion-icon name="search-outline" class="absolute left-0 px-2 py-2"></ion-icon>
                    </div>
                   <div class="relative">
                        <input type="search" name="searchByName" class="ps-6 shadow border border-gray-100 text-xs w-64" placeholder="Search Email">
                        <ion-icon name="search-outline" class="absolute left-0 px-2 py-2"></ion-icon>
                    </div>
                </div>
               <div class="relative">
                    <input type="search" name="searchById" class="ps-6 shadow border border-gray-100 text-xs " placeholder="Search ID">
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
                            <td><ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon></td>
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