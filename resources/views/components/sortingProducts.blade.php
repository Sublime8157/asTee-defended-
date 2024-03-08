@props(['sortProduct', 'orderProduct'])

<div class="">
    <div class="flex justify-between items-center flex-row p-3">
        <div class="flex flex-row">
            <div class="me-3">
                <select name="sortBy" id="sortProductBy" class="{{$sortProduct}} h-8 text-xs cursor-pointer">
                    <option value="id" selected>ID</option>
                    <option value="gender">Gender</option>
                    <option value="size">Size</option>
                    <option value="price">Price</option>
                    <option value="quantity">Quantity</option>
                </select>
            </div>
            <div>
                <select name="orderBy" id="orderProductBy" class="{{$orderProduct}} h-8 text-xs cursor-pointer">
                    <option value="asc" class="text-xs" selected>Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
        </div>
        <div>
           <div class="flex items-center bg-blue-600 px-4 py-2 cursor-pointer hover:bg-blue-500" onclick="revealForm()" >
                <ion-icon name="add-circle-outline" class="pe-1 text-white text-lg"></ion-icon>
                <button class="text-xs text-white" >New Product</button>
           </div>
        </div>
    </div>
</div>