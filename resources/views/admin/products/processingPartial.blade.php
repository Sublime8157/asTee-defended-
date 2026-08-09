{{-- One partial for every order line. processingPartial and CancelReturnPartial
     were ~80% the same file differing only in the cancel-reason column, because
     the rows lived in two tables. They are one table and one status now. --}}
@foreach($items as $item)
<tr class=" text-xs ">
     <td></td>
     <td><input type="checkbox" value="{{ $item->id }}" class="checkBox"></td>
     <td class="text-center ps-2">{{ $item->id }}</td>
     <td class="text-center ps-2 w-20">{{ $item->order->user_id }}</td>
     <td class="text-center ps-2">
         <img src="{{ $item->image_url }}" alt="{{ $item->shortDescription }}" width="50px" class="cursor-pointer"
         onclick="revealImage('{{ $item->id }}')">
         <dialog id="imageDialog{{ $item->id }}">
             <img src="{{ $item->image_url }}" alt="{{ $item->shortDescription }}" width="auto" class="cursor-pointer">
         </dialog>
     </td>
     <td class="text-center ps-2">{{ $item->variation->label() }}</td>
     <td class="text-center ps-2 w-60 "><textarea cols="20" rows="2" placeholder="{{ $item->description }}" style="font-size: 10px" class="border-none " disabled></textarea></td>
     <td class="text-center ps-2">{{ $item->gender->label() }}</td>
     <td class="text-center ps-2">{{ $item->size->label() }}</td>
     <td class="text-center ps-2">{{ $item->line_total }}</td>
     <td class="text-center ps-2">
         <span id="status{{ $item->id }}">{{ $item->status->label() }}</span>
         <ion-icon name="create-outline" class="font-bold text-sm cursor-pointer" onclick="editStatus({{ $item->id }})"></ion-icon>
     </td>
     @if($item->status === \App\Enums\OrderStatus::Cancelled)
         <td class="text-center ps-2">{{ $item->cancel_note ?: $item->cancel_reason?->label() }}</td>
     @endif
     <td class="text-center ps-2">{{ $item->created_at->format('d M Y') }}</td>
     <td class="text-center">
         <form action="{{ route('productProcess.remove', $item->id) }}" method="POST" id="removeProduct{{ $item->id }}">
             @csrf
             @method('DELETE')
         </form>
         {{-- One status form replaces the edit dialog, the move dialog and the
              status dialog. Moving a line "to cancel" was a different table;
              it is a value in this column. --}}
         <dialog id="prodStatus{{ $item->id }}" class="p-5">
               <form id="updateStatusForm{{ $item->id }}" action="{{ route('update.status', $item->id) }}" method="POST" class="text-center">
                     @csrf
                     @method('PATCH')
                     <select name="status" id="updateStatusSelect{{ $item->id }}" class="text-xs text-center w-full mb-2" onchange="toggleCancelReason({{ $item->id }})">
                         @foreach(\App\Enums\OrderStatus::options() as $value => $label)
                             <option value="{{ $value }}" @selected($item->status->value === $value)>{{ $label }}</option>
                         @endforeach
                     </select>
                     <div id="cancelReason{{ $item->id }}" class="{{ $item->status === \App\Enums\OrderStatus::Cancelled ? 'block' : 'hidden' }}">
                         <label class="text-xs">Reason</label>
                         <select name="reason" class="text-xs text-center w-full mb-2">
                             @foreach(\App\Enums\CancelReason::options() as $value => $label)
                                 <option value="{{ $value }}" @selected($item->cancel_reason?->value === $value)>{{ $label }}</option>
                             @endforeach
                         </select>
                         <input type="text" name="specify" value="{{ $item->cancel_note }}" placeholder="Details (optional)" class="text-xs w-full mb-2">
                     </div>
                     <button id="updateStatusBtn{{ $item->id }}" type="submit" class="text-sm text-white rounded px-2 py-1 w-full" style="background-color: #ff8906">Update</button>
               </form>
         </dialog>
         <button type="button" onclick="showMenus({{ $item->id }})" >
             <div class="relative z-20">
                 <ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon>
                 <div class="absolute bg-white hidden right-7 top-0 shadow-lg rounded" id="actionMenu{{ $item->id }}">
                   <a onclick="editStatus({{ $item->id }})" class="hover:bg-gray-400 px-6 text-xs">Status</a>
                   <a onclick="removeProduct({{ $item->id }})" class="hover:bg-gray-400 px-4 text-xs">Remove</a>
                 </div>
             </div>
         </button>
     </td>
</tr>
<tr>
 <td colspan="12"> <hr class="w-full"></td>
</tr>
@endforeach
