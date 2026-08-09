@foreach($payments as $payment)
<tr class="w-full ">
    <td><input type="checkbox" name="" id="" value="{{ $payment->id }}" class="checkBox"></td>
    <td class="">{{ $payment->id }}</td>
    <td>{{ $payment->order_id }}</td>
    <td>{{ $payment->provider }}</td>
    <td>{{ $payment->amount }}</td>
    <td class="">
        @if($payment->proof_path)
            <img src="{{ route('admin.file.paymentProof', $payment->id) }}" alt="Payment proof" class="w-12 cursor-pointer" onclick="document.getElementById('proofImage{{ $payment->id }}').showModal();">
            <dialog class="modal" id="proofImage{{ $payment->id }}">
                <img src="{{ route('admin.file.paymentProof', $payment->id) }}" alt="Payment proof">
            </dialog>
        @endif
    </td>
  
    <td class="">{{ $payment->created_at->format('d M Y') }}</td>
    <td><ion-icon name="trash-outline" class="text-xl  cursor-pointer" onclick="if(confirm('Are you sure you want to delete this record?')) { document.getElementById('removeRecord{{ $payment->id }}').submit() }"></ion-icon></td>
    {{-- form for removing specific  --}}
    <form action="{{route('deleteRecordPayments')}}" method="POST" id="removeRecord{{ $payment->id }}">
        @csrf
        <input type="hidden" name="toDelete" value="{{ $payment->id }}">
        @method('DELETE')
    </form>
</tr>
<tr>
    <td colspan="7">
        <hr class="w-full bg-gray-50">
    </td>
</tr>
@endforeach