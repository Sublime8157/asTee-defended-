@foreach ($data as $list )
<tr class="text-center {{ $list->paid === 'not_paid' ? 'bg-red-200' : ' ' }} ">
        <td class="text-sm py-2">{{$list->id}}</td>
        <td class="text-sm">{{$list->userId}}</td>
        <td class="text-sm">{{$list->address}}</td>
        <td class="text-sm">{{$list->productId}}</td>
        <td class="text-sm">{{$list->contact}}</td>
        <td class="text-sm">{{$list->mop}}</td>
        <td class="text-sm">{{$list->created_at}}</td>
</tr>
<tr>
    <td colspan="7">
        <hr class="bg-gray-50">
    </td>
</tr>
@endforeach