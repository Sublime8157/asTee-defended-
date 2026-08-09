@props(['route', 'status' => 'hidden'])

{{-- The third bulk action, "Move", is gone along with the tables it moved rows
     between. Cancelling is a status now, so it is the same action as any other
     status change instead of a copy-and-delete into another table. --}}
<th class=""><input type="checkbox" id="checkAll" class="cursor-pointer"></th>
<th>
    {{-- delete form  --}}
    <form action="{{ $route }}" method="POST" id="confirmedRemove">
        @csrf
        <input type="hidden" name="toRemove" id="toRemove" value="">
        @method('DELETE')
        <select id="chooseMultiple" class="text-xs text-left font-normal border-none w-20 py-1 cursor-pointer px-1 " onchange="chosenMultiple()" style="font-size: 10px">
            <option value="0" disabled selected>Action</option>
            <option value="1">Remove</option>
            <option value="2" class="{{ $status }}">Status</option>
        </select>
    </form>
    {{-- confirmation dialog(delete)  --}}
    <dialog id="confirmDialog" class=" modal dialog w-80 p-2 bg-white rounded">
        <div class="flex flex-col">
            <div class="p-4">
                <p class="text-xs text-center font-normal text-red-500">You are about to delete the selected rows. Are you sure?</p>
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
                <p class="text-xs text-center font-normal text-red-500">You are about to update the status of the selected order lines. Are you sure?</p>
            </div>
            {{-- update Form --}}
            <form action="{{ route('updateMultiple.status') }}" method="POST" id="confirmUpdateStatus">
                @csrf
                <input type="hidden" name="toUpdate" id="toUpdate" value="">
                <select name="status" class="text-xs w-full font-normal mb-3" onchange="toggleBulkCancelReason()" id="bulkStatus">
                    @foreach(\App\Enums\OrderStatus::options() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div id="bulkCancelReason" class="hidden">
                    <select name="reason" class="text-xs w-full font-normal mb-3">
                        @foreach(\App\Enums\CancelReason::options() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="specify" placeholder="Details (optional)" class="text-xs w-full font-normal mb-3">
                </div>
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
<script>
    // Reveal the cancellation reason only when the chosen status needs one —
    // the controller validates `reason` as required_if:status,cancelled.
    function toggleBulkCancelReason() {
        var cancelled = document.getElementById('bulkStatus').value === '{{ \App\Enums\OrderStatus::Cancelled->value }}';
        document.getElementById('bulkCancelReason').className = cancelled ? 'block' : 'hidden';
    }

    function toggleCancelReason(id) {
        var cancelled = document.getElementById('updateStatusSelect' + id).value === '{{ \App\Enums\OrderStatus::Cancelled->value }}';
        document.getElementById('cancelReason' + id).className = cancelled ? 'block' : 'hidden';
    }
</script>
