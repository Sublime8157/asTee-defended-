@extends('components.header')
@section('docu', 'Return & Cancel Products')
@section('page','RETURN & CANCEL ')
<x-header />
<x-nav />
<x-notification />
<div class="p-3">
    {{ $items->links('pagination::simple-tailwind') }}
</div>
<div class="bg-white my-5 mx-4">
    <div class="">
        <x-sortingProducts sortProduct="sortCancelReturnProduct" orderProduct="sortCancelReturnProduct" filterByDate="filterDateCancelReturn" display="block" :columns="['id' => 'ID', 'description' => 'Description', 'unit_price' => 'Unit price', 'quantity' => 'Quantity', 'line_total' => 'Total', 'status' => 'Status', 'created_at' => 'Date']" />
    </div>
    <div class="mx-10 pb-10 flex justify-center">
        <table class="">
           <tr class="">
                <x-removeMultiple route="{{ route('deleteFrom.cancel') }}" status="block" />                         
                <th class="adminTable">ID</th>
                <th class="adminTable w-20">User Id</th>
                <th class="adminTable w-20">Image</th>
                <th class="adminTable">Variation</th>
                <th class="adminTable">Description</th>   
                <th class="adminTable">Gender</th>
                <th class="adminTable">Size</th>      
                <th class="adminTable w-24">Total</th>
                <th class="adminTable w-20">Reason</th>    
                <th class="adminTable">Date</th>                                                           
                <th class="adminTable w-24">Action</th>
           </tr>
           <tr>
                <td colspan="10"><hr class="w-full mt-1 mb-3"></td>
           </tr>
           <tr>
            <form id="filterReturnCancelForm"  method="get">
                <td></td>
                <td></td>
                <td class="w-12">
                    {{-- filter by id  --}}
                        <input type="text" name="id" placeholder="ID" class="w-10 h-8 text-xs ">
                </td>
                <td><input type="text" name="userId" placeholder="User Id" class="w-20 h-8 text-xs "></td>
                <td class="w-12"></td>
                <td class="w-40 ">
                    {{-- by variation --}}
                        <select name="variation" class="w-32 h-8 text-xs  cursor-pointer">
                            <option value=""></option>
                            @foreach(\App\Enums\Variation::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </td>
                <td class="w-32"></td>
                <td class="w-20">
                    {{-- by gender --}}
                        <select name="gender" class="w-16 h-8 text-xs  cursor-pointer">
                            <option value=""></option>
                            @foreach(\App\Enums\Gender::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </td>
                <td class="w-40">
                    {{-- by size --}}
                        <select name="size" class="w-32  h-8 text-xs cursor-pointer">
                            <option value=""></option>
                            @foreach(\App\Enums\ShirtSize::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </td>
                    {{-- by price --}}
                <td></td>             
                <td></td>
                <td></td>
                <td colspan="3" class=" w-24">
                    <button type="submit" class="bg-yellow-500 flex items-center justify-center gap-1 text-xs rounded w-auto py-1 px-2 tracking-wider  hover:opacity-50 text-white cursor-pointer"><ion-icon name="funnel" class="text-white text-md"></ion-icon>FILTER</button></td>
                </td>
            </form>
           </tr>
           <tbody id="productTableBody">
           @include('admin.products.processingPartial')
        </tbody>
        </table>
    </div>
</div>
{{-- This is the add product form --}}
<div>
    {{-- The "add product" dialog is gone: an order line is created by a
         customer checking out, or by the Sell action on the catalog screen. --}}
</div>
</div>
</div>
<x-adminFooter />