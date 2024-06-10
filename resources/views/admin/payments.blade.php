@extends('components.header')
@section('docu', 'Payments History')
@section('page','PAYMENTS')
<x-header />
<x-nav />
<x-notification />
    <div class="w-full p-10  ">
        <div class="w-full gap-2 flex flex-col shadow-sm bg-white rounded p-4">
            <div class="  w-full flex flex-row items-center">
                <form action="" class="w-full flex justify-between items-center flex-row" >
                    <div class="flex flex-row items-center">
                        <div class="relative me-5">
                          <label for="sortBY" class="text-xs ">Sort by:</label>
                          {{-- sort the data by options  --}}
                          <select name="sortBy" id="sortBy" class="sortPayments shadow text-xs border-gray-100 cursor-pointer">
                                <option value="id">ID</option>
                                <option value="orders_id">Orders ID</option>
                          </select>
                          {{-- sort the data if ascending or descending  --}}
                          <select name="orderBy" id="orderBy" class="sortPayments shadow text-xs border-gray-100 cursor-pointer">
                                <option value="asc">Ascend</option>
                                <option value="desc">Descend</option>
                          </select>
                        </div>
                        <div>
                            <label for="" class="text-xs"> Filter</label>
                            <label for="" class="text-xs">from:</label><input type="date" name="start" id="startDate" class="filterPaymentsDate text-xs border-none rounded shadow ">
                            <label for="" class="text-xs">to:</label><input type="date" name="end" id="endDate" class="filterPaymentsDate text-xs border-none rounded shadow ">
                        </div>
                    </div>
                   <div class="relative">
                    {{-- search by id, name or email   --}}
                        <input type="search" name="search" class="ps-6 shadow border border-gray-100 text-xs " placeholder="Search" id="searchOnPayments">
                        <ion-icon name="search-outline" class="absolute left-0 px-2 py-2"></ion-icon>
                    </div>
                </form>
            </div> 
            <div class="justify-between flex w-full flex-row  px-2">
                <div>
                    <label for="" class="text-xs me-2">Bank: </label>
                        <select name="bank" id="bank" class="text-xs border-none rounded shadow">
                            <option value="Gcash">GCASH</option>
                            <option value="BPI">BPI</option>
                        </select>
                    <label for="" class="text-xs">min:</label>
                    <input type="number" name="min" id="min" class="filterPrice w-20 text-xs border-none rounded shadow">
                    <label for="" class="text-xs">max:</label>
                    <input type="number" name="max" id="max" class="filterPrice w-20 text-xs border-none rounded shadow">
                </div>
                {{-- button for adding payments  --}}
                <div>
                    <button class="bg-blue-700 text-sm text-white px-2 py-1 hover:opacity-70 shadow-sm " onclick="document.getElementById('addPayments').showModal()">Add Payments</button>
                </div>
                {{-- dialog  --}}
                <dialog id="addPayments" class="modal  rounded">
                    <h1 class="text-center w-full text-white bg-blue-500 py-2 font-semibold  text-sm"> PAYMENT FORM</h1>
                        <div class="bg-red-100 m-2 border border-red-500 rounded w-auto text-xs p-2 hidden" id="failMessageBox">
                            <p id="failMessage"></p>
                        </div>
                        <div class="bg-blue-100 m-2 border border-blue-500 rounded w-auto text-xs p-2 hidden" id="successMessageBox">
                           <p id="successMessage"></p>
                        </div>
                    <form  class="flex flex-col gap-2  w-full p-4"  id="paymentSubmitForm">
                        @csrf
                        <div class="gap-2 flex flex-row">
                            <div class="flex text-sm flex-col">
                                <label for="">Customer ID*</label>
                                <input type="text" name="customers_id" >
                                <label for="">Order ID*</label>
                                <input type="text" name="orders_id" >
                            </div>
                            <div class="flex text-sm flex-col">
                                <label for="">Bank*</label>
                                <select name="bank" id="">
                                    <option value="Gcash">Gcash</option>
                                    <option value="BPI">BPI</option>
                                </select>
                                <label for="">Amount*</label>
                                <input type="text" name="amount" >
                            </div>
                            
                        </div>
                        <div>
                            <label for="" class="text-sm ">Attach reciept</label> <br>
                            <input type="file" name="proof" id="">
                        </div>
                        <div class="w-full">
                            <button type="submit" class="py-2 shadow text-white hover:opacity-70 w-full bg-red-700 ">Add</button>
                        </div>
                    </form>
                </dialog>
            </div>
            <hr class="w-full bg-gray-50">
            <div class="w-full ">
                <table class=" w-full text-sm text-center">
                        <tr class="w-full text-center">
                            <th>ID</th>
                            <th>Orders Id</th>
                            <th>Bank</th>
                            <th>Amount</th>
                            <th class="w-12">Proof</th>
                            <th class="w-auto">Date</th>
                            <th>Action</th>
                        </tr>
                    <tbody id="paymentData" class="w-full">
                        @foreach($data as $paymentData)
                            <tr class="w-full ">
                                <td class="">{{$paymentData->id}}</td>
                                <td>{{$paymentData->orders_id}}</td>
                                <td>{{$paymentData->bank}}</td>
                                <td>{{$paymentData->amount}}</td>
                                <td class="">
                                    <img src="{{asset('storage/images/' . $paymentData->proof )}}" alt="" class="w-12 cursor-pointer" onclick="document.getElementById('proofImage').showModal(); ">
                                    <dialog class="modal" id="proofImage">
                                        <img src="{{asset('storage/images/' . $paymentData->proof )}}" alt=""> 
                                    </dialog>
                                </td>
                              
                                <td class="">{{$paymentData->created_at}}</td>
                                <td><ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon></td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <hr class="w-full bg-gray-50">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
<script src="{{asset('js/paymenthistory.js')}}"></script>
<x-adminFooter />