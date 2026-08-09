@foreach ($orders as $order)
<tr class="text-center  {{ $order->isPaid() ? '' : 'bg-red-200' }} ">
        <td class="text-sm py-2 ">{{ $order->id }}</td>
        <td class="text-sm">{{ $order->user_id }}</td>
        <td class="text-sm">{{ $order->address }}</td>
        {{-- Was orders.productId, a JSON array of ids printed raw. --}}
        <td class="text-sm">{{ $order->items->pluck('description')->implode(', ') }}</td>
        <td class="text-sm">{{ $order->contact }}</td>
        <td class="text-sm">{{ $order->payment_method }}</td>
        <td class="text-sm">{{ $order->total }}</td>
        <td class="text-sm">{{ $order->created_at->format('d M Y') }}</td>
</tr>
<tr>
    <td colspan="7">
        <hr class="bg-gray-50">
    </td>
</tr>
@endforeach