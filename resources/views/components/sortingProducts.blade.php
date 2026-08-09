@props(['sortProduct', 'orderProduct', 'filterByDate', 'display', 'columns' => [], 'newProduct' => false])

<div class="">
    <div class="flex justify-between items-center flex-row p-3">
        <div class="flex flex-row gap-2">
            <div class="me-3">
                <select name="sortBy" id="sortProductBy" class="{{$sortProduct}} h-8 text-xs cursor-pointer">
                    @foreach($columns as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="orderBy" id="orderProductBy" class="{{$orderProduct}} h-8 text-xs cursor-pointer">
                    <option value="asc" class="text-xs" selected>Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <div class="{{$display}}">
                <label for="" class="text-xs">from:</label><input type="date" name="start" id="startDate" class="{{$filterByDate}} text-xs border-none rounded shadow ">
                <label for="" class="text-xs">to:</label><input type="date" name="end" id="endDate" class="{{$filterByDate}} text-xs border-none rounded shadow ">
            </div>
        </div>
        @if($newProduct)
        <div>
           <div class="flex items-center bg-blue-600 px-4 py-2 cursor-pointer hover:bg-blue-500" onclick="revealForm()">
                <ion-icon name="add-circle-outline" class="pe-1 text-white text-lg"></ion-icon>
                <button class="text-xs text-white">New Product</button>
           </div>
        </div>
        @endif
    </div>
</div>