@props(['route', 'id', 'img', 'variation', 'gender', 'size', 'price', 'quantity', 'description', 'dialogId','productStatus'])


    <form action="{{ route($route, ['id' => $id]) }}" id="editProduct{{$id}}" method="POST">
        @csrf
        @method('PATCH')
        <h1 class="font-bold tracking-wide mb-2">EDIT PRODUCT</h1>
            <div class="flex items-center justify-center flex-row-reverse ">
                <div class="flex flex-row items-start flex-wrap">
                    {{-- Choose Variation Type --}}
                        <div class="me-2">
                            <label for="" class="text-xs">Variation*</label> <br>
                            <select name="variation_id" id="variation_id" class="h-10 w-40 rounded text-sm cursor-pointer">
                                <option value="1" @if($variation == 1) selected @endif>Couple Shirt</option>
                                <option value="2"@if($variation == 2) selected @endif> Solo Shirt</option>
                                <option value="3"@if($variation == 3) selected @endif> Family Shirt</option>
                                <option value="4"@if($variation == 4) selected @endif> Kids Wear</option>
                            </select>
                        </div>
                        {{-- Choose t-shirt gender type --}}
                        <div class="me-2">
                            <label for="" class="text-xs">Gender*</label> <br>
                            <select name="gender" id="gender" class="h-10 w-40 rounded text-sm cursor-pointer">
                                <option value="1" @if($gender == 1) selected @endif>Male</option>
                                <option value="2" @if($gender == 2) selected @endif>Female</option>
                                <option value="3" @if($gender == 3) selected @endif>Unisex</option>
                            </select>
                        </div>
                        {{-- Choose size --}}
                        <div class="me-2">
                            <label for="size" class="text-xs">Size*</label> <br>
                            <select name="size" id="size" class="h-10 w-40 rounded text-sm cursor-pointer">
                                <option value="1" @if($size == 1) selected @endif>XS</option>
                                <option value="2" @if($size == 2) selected @endif>Small</option>
                                <option value="3" @if($size == 3) selected @endif>Medium</option>
                                <option value="4" @if($size == 4) selected @endif>Large</option>
                                <option value="5" @if($size == 5) selected @endif>XL</option>
                                <option value="6" @if($size == 6) selected @endif>2XL</option>
                                <option value="7" @if($size == 7) selected @endif>3XL</option>
                            </select>
                        </div> 
                        {{-- Input thep price --}}
                        <div class="me-2">
                            <label for="price" class="text-xs">Price*</label> <br>
                            <input type="text" name="price" class="h-10 w-40 rounded text-sm" id="price" value="{{$price}}">
                        </div>
                        {{-- input the quantity --}}
                        <div class="me-2">
                            <label for="quantity" class="text-xs">Quantity*</label> <br>
                            <input type="text" name="quantity" class="h-10 w-40 rounded text-sm" id="quantity" value="{{$quantity}}">
                        </div>
                        {{-- And the description of the product this includes the reason why it's on hand  --}}
                        <div class="me-2">
                            <label for="">Description*</label><br>
                            <textarea name="description" id="desc" cols="50" rows="2" class="text-xs rounded">{{$description}}</textarea>
                        </div>
                </div>
                {{-- Image input --}}
                    <div class="flex items-center flex-col">
                        <div class="relative border-2 border-dashed rounded-md me-5 self-center mb-5">
                                <ion-icon name="cloud-upload-outline" class="z-0 absolute absolute-center text-9xl text-gray-400 opacity-20"></ion-icon>
                                <input type="file" name="image_path" id="image" class="py-20 cursor-pointer opacity-0">
                                <img src="{{ asset('storage/images/' . $img ) }}" alt="Image Preview" style="display: block; height: 200px;" class="absolute absolute-center bg-white" id="image-preview" width="400px">
                        </div>
                        <div>
                            <button type="submit" class="py-1 text-sm bg-blue-700 rounded-sm text-white font-light px-2 hover:opacity-50" id="updateTable">Update Table</button>
                        
                            <button type="button" id="closeEditBtn" class="border-2 px-2 py-1 text-sm rounded hover:opacity-50">Cancel</button>
                        </div>
                    </div>
            </div>
        </form>
