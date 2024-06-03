@foreach ($data as $list )
<tr class="text-center">
        <td class="text-sm">{{$list->id}}</td>
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