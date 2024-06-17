@foreach($data as $paymentData)
<tr class="w-full ">
    <td><input type="checkbox" name="" id="" value="{{$paymentData->id}}" class="checkBox"></td>
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