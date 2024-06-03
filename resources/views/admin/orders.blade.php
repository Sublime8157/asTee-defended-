@extends('components.header')
@section('docu', 'Orders')
@section('page','ORDERS')
<x-header />
<x-nav />
<x-notification />
<div class="p-3">
    {{ $data->links('pagination::simple-tailwind') }}
</div>
<div class="w-full px-5">
    <div class="w-full px-5 bg-white rounded   my-5 flex flex-col">
        <div class="px-5  py-2 w-full flex flex-row items-center">
            <form action="" class="w-full flex justify-between items-center flex-row" >
                <div class="flex flex-row items-center">
                    <div class="relative me-5">
                      <label for="sortBY" class="text-xs ">Sort by:</label>
                      {{-- sort the data by options  --}}
                      <select name="sortBy" id="sortBy" class="sort_order shadow text-xs border-gray-100 cursor-pointer">
                            <option value="id">ID</option>
                            <option value="productId">Product ID</option>
                            <option value="address">Address</option>
                            <option value="contact">Contact</option>
                            <option value="mop">MOP</option>
                            <option value="created_at">Date</option>
                      </select>
                      {{-- sort the data if ascending or descending  --}}
                      <select name="orderBy" id="orderBy" class="sort_order shadow text-xs border-gray-100 cursor-pointer">
                            <option value="asc">Ascend</option>
                            <option value="desc">Descend</option>
                      </select>
                    </div>
                    <div>
                        <label for="" class="text-xs"> Filter</label>
                        <label for="" class="text-xs">from:</label><input type="date" name="start" id="startDate" class="filterDate text-xs border-none rounded shadow ">
                        <label for="" class="text-xs">to:</label><input type="date" name="end" id="endDate" class="filterDate text-xs border-none rounded shadow ">
                    </div>
                </div>
               <div class="relative">
                {{-- search by id, name or email   --}}
                    <input type="search" name="search" class="ps-6 shadow border border-gray-100 text-xs " placeholder="Search" id="searchOrders">
                    <ion-icon name="search-outline" class="absolute left-0 px-2 py-2"></ion-icon>
                </div>
            </form>
        </div> 
        <hr class="mt-2 w-full bg-gray-50">
        <div class="mt-5">
            <table class="w-full">
                <tr class="w-full text-sm text-center ">
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Product ID's</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>MOP</th>
                    <th>Date</th>
                </tr>
                <tbody id="orderTableBody">
                    @foreach ($data as $list )
                        <tr class="text-center">
                                <td class="text-sm">{{$list->id}}</td>
                                <td class="text-sm">{{$list->userId}}</td>
                                <td class="text-sm">{{$list->address}}</td>
                                <td class="text-sm">{{$list->productId}}</td>
                                <td class="text-sm">{{$list->contact}}</td>
                                <td class="text-sm">{{$list->mop}}</td>
                                <td class="text-sm">{{$list->created_at}}</td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <hr class="bg-gray-50">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<x-adminFooter />