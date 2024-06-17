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
                        {{-- form for adding reciept  --}}
                    <form  class="flex flex-col gap-2  w-full p-4"  id="paymentSubmitForm">
                        @csrf
                        <div class="gap-2 flex flex-row">
                            <div class="flex text-sm flex-col">
                                <label for="">Order ID*</label>
                                <select name="orders_id" id="orders">
                                    <option value="000"></option>
                                    @foreach ($ordersId as $id)
                                        <option value="{{$id->id}}">{{$id->id}}</option>
                                    @endforeach
                                </select>
                                <label for="">Amount*</label>
                                <input type="text" name="amount" id="amount">
                                <input type="hidden" id="userId" name="userId">
                            </div>
                            <div class="flex text-sm flex-col">
                                <label for="">Bank*</label>
                                <select name="bank" id="">
                                    <option value="Gcash">Gcash</option>
                                    <option value="BPI">BPI</option>
                                </select>
                                <label for="" class="text-sm ">Attach reciept</label> 
                                <input type="file" name="proof" id="">
                            </div>
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
                            <th class="">
                                <input type="checkbox" name="" id="checkAll" class="cursor-pointer">
                                {{-- form for removing  --}}
                                <form action="{{route('removePayments')}}" method="POST" id="removingPaymentForm">
                                    @csrf
                                    <input type="hidden" name="toRemove" id="toRemove" value="">
                                    <button type="button" class="text-xs bg-red-700 text-white py-1 px-1" onclick="document.getElementById('showRemoveConfirmation').showModal();">Remove</button>
                                    @method('DELETE')
                                    <dialog class="modal w-80" id="showRemoveConfirmation" > 
                                        <div class="flex flex-col">
                                            <div class="p-4">
                                                <p class="text-xs text-center font-normal text-red-500">You are about to delete multiple products, that might affect multiple tables, are you sure you want to delete these?</p>
                                            </div>
                                            <div class="flex justify-between items-center flex-row ">
                                                <div class="w-40   hover:opacity-70 border-r">
                                                    <button class="py-1 font-normal text-sm">Confirm</button>
                                                </div>
                                                <div class="cursor-pointer hover:opacity-70 w-full bg-orange-400 text-white font-normal text-sm " onclick="document.getElementById('showRemoveConfirmation').close();" >
                                                    <button type="button" class="py-1 " >Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </dialog>
                                </form>
                            </th>
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
                                <td><input type="checkbox" name="" id="" value="{{$paymentData->id}}" class="checkBox"></td>
                                <td class="">{{$paymentData->id}}</td>
                                <td>{{$paymentData->orders_id}}</td>
                                <td>{{$paymentData->bank}}</td>
                                <td>{{$paymentData->amount}}</td>
                                <td class="">
                                    <img src="{{asset('storage/images/' . $paymentData->proof )}}" alt="" class="w-12 cursor-pointer" onclick="document.getElementById('proofImage').showModal(); ">
                                    <dialog class="modal" id="proofImage{{$paymentData->id}}">
                                        <img src="{{asset('storage/images/' . $paymentData->proof )}}" alt=""> 
                                    </dialog>
                                </td>
                              
                                <td class="">{{$paymentData->created_at}}</td>
                                <td><ion-icon name="trash-outline" class="text-xl  cursor-pointer" onclick="if(confirm('Are you sure you want to delete this record?')) { document.getElementById('removeRecord').submit() }"></ion-icon></td>
                                {{-- form for removing specific  --}}
                                <form action="{{route('deleteRecordPayments')}}" method="POST" id="removeRecord">
                                    @csrf
                                    <input type="hidden" name="toDelete" value="{{$paymentData->id}}">
                                    @method('DELETE')
                                </form>
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