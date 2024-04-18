@props(['route','status'])
<th class=""><input type="checkbox" name="" id="checkAll" class="cursor-pointer"></th>
<th>
    {{-- delete form  --}}
    <form action="{{$route}}" method="POST" id="confirmedRemove">
        @csrf
        <input type="hidden" name="toRemove" id="toRemove" value="">
        @method('DELETE')
        {{-- <button type="button" onclick="" class="font-normal px-1 text-xs text-orange-600">Remove</button> --}}
        <select name="" id="chooseMultiple"  class="text-xs text-left font-normal border-none w-20 py-1 px-1 " onchange="chosenMultiple()" style="font-size: 10px">
            <option value="0">Action</option>
            <option value="1">Remove</option>
            <option value="2" class="{{$status}}">Status</option>
            <option value="3">Move</option>
        </select>
    </form>
    {{-- confirmation dialog(delete)  --}}
    <dialog id="confirmDialog" class=" modal dialog w-80 p-2 bg-white rounded"> 
        <div class="flex flex-col">
            <div class="p-4">
                <p class="text-xs text-center font-normal text-red-500">You are about to delete multiple products, that might affect multiple tables, are you sure you want to delete these?</p>
            </div>
            <div class="flex justify-between items-center flex-row ">
                <div class="w-40   hover:opacity-70 border-r">
                    <button class="py-1 font-normal text-sm" onclick="document.getElementById('confirmedRemove').submit()">Confirm</button>
                </div>
                <div class="cursor-pointer hover:opacity-70 w-full bg-orange-400 text-white font-normal text-sm ">
                    <button class="py-1 " onclick="document.getElementById('confirmDialog').close()" >Cancel</button>
                </div>
            </div>
        </div>
    </dialog>
    {{-- confirmation dialog(update) --}}
    <dialog id="confirmDialogUpdate" class="modal dialog w-80 p-2 bg-white rounded"> 
        <div class="flex flex-col">
            <div class="p-4">
                <p class="text-xs text-center font-normal text-red-500">You are about to update multiple products status, that might affect multiple tables, are you sure you want to update these?</p>
            </div>
            {{-- update Form --}}
            <form action="{{route('updateMultiple.status')}}" method="POST" id="confirmUpdateStatus">
                @csrf
                <input type="hidden" name="toUpdate" id="toUpdate" value="">
                <select name="status" id="" class="text-xs w-full font-normal mb-3">
                    <option value="1">To Pay</option>
                    <option value="2">To Ship</option>
                    <option value="3">To Recieve</option>
                    <option value="4">To Review</option>
                </select>
            </form>   
            <div class="flex justify-between items-center flex-row ">
                <div class="w-40   hover:opacity-70 border-r">
                    <button class="py-1 font-normal text-sm" onclick="document.getElementById('confirmUpdateStatus').submit()">Confirm</button>
                </div>
                <div class="cursor-pointer hover:opacity-70 w-full bg-orange-400 text-white font-normal text-sm ">
                    <button class="py-1 " onclick="document.getElementById('confirmDialogUpdate').close()" >Cancel</button>
                </div>
            </div>
        </div>
    </dialog>
</th>