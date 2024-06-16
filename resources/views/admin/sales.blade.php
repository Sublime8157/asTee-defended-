@extends('components.header')
@section('docu', 'Order History')
@section('page','SALES')
<x-header />
<x-nav />
<x-notification />
    <div class="p-5">
        <div class="bg-white rounded flex flex-col gap-4 p-4">
            <div class="flex justify-between w-full ">
                <div>
                    <label for="" class="text-xs">From:</label>
                    <input type="date" name="" id="" class="rounded border-none shadow text-xs ">
                    <label for="" class="text-xs">To:</label>
                    <input type="date" name="" id="" class="rounded border-none shadow text-xs ">
                </div>
                <div>
                    <label for="" class="text-xs">Search:</label>
                    <input type="search" name="" id="" placeholder="id, product id, user id" class="rounded border-none shadow text-xs ">
                </div>
            </div>
            <div class="flex justify-between w-fulll flex-row items-center ">
                <div>   
                    <label for="" class="text-xs">Sort:</label>
                    <select name="" id="" class="shadow border-none text-xs">
                        <option value="id">ID</option>
                    </select>
                    <label for="" class="text-xs">By:</label>
                    <select name="" id="" class="shadow border-none text-xs">
                        <option value="asc">ascending</option>
                    </select>
                </div>
                <div>
                    <label for="">&#x20B1;</label>
                    <input type="number" name="" id="" class="w-32 shadow border-none text-xs rounded">
                    <label for="">&#x20B1;</label>
                    <input type="number" name="" id="" class="w-32 shadow border-none text-xs rounded">
                </div>
            </div>
            <table class="w-full text-center text-sm ">
                <thead>
                    <tr>  
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>User Id</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="salesData">
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->ordersId}}</td>
                            <td>{{$item->userId}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{$item->created_at}}</td>
                            <td><ion-icon name="trash-outline" class="text-xl  cursor-pointer"></ion-icon></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="py-1">
                                <hr class="w-full bg-gray-50">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<x-adminFooter /> 