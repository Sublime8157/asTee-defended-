@props(['route'])
<th class=""><input type="checkbox" name="" id="checkAll" class="cursor-pointer"></th>
<th>
    {{-- delete form  --}}
    <form action="{{$route}}" method="POST" id="confirmedRemove">
        @csrf
        <input type="hidden" name="toRemove" id="toRemove" value="">
        @method('DELETE')
        <button type="button" onclick="document.getElementById('confirmDialog').showModal();" class="font-normal px-1 text-xs text-orange-600">Remove</button>
    </form>
    {{-- confirmation dialog  --}}
    <dialog id="confirmDialog" class="modal dialog w-80 p-2 bg-white rounded"> 
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
</th>