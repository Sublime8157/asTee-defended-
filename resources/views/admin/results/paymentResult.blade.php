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
    <td>Action</td>
</tr>
<tr>
    <td colspan="7">
        <hr class="w-full bg-gray-50">
    </td>
</tr>
@endforeach