@props(['route', 'product'])

{{-- The three <select> lists were hand-typed integer options in this file, in
     moveProduct.blade.php, in the two "add product" pages and in the storefront
     filter — five copies that had already drifted (size 6/7 both read "XXL",
     the gender filter emitted a leading space). They render from the enums now. --}}

    <form action="{{ route($route, ['id' => $product->id]) }}" id="editProduct{{ $product->id }}" method="POST">
        @csrf
        @method('PATCH')
        <h1 class="font-bold tracking-wide mb-2">EDIT PRODUCT</h1>
            <div class="flex items-center justify-center flex-row-reverse ">
                <div class="flex flex-row items-start flex-wrap">
                    {{-- Choose Variation Type --}}
                        <div class="me-2">
                            <label for="" class="text-xs">Variation*</label> <br>
                            <select name="variation" class="h-10 w-40 rounded text-sm cursor-pointer">
                                @foreach(\App\Enums\Variation::options() as $value => $label)
                                    <option value="{{ $value }}" @selected($product->variation->value === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Choose t-shirt gender type --}}
                        <div class="me-2">
                            <label for="" class="text-xs">Gender*</label> <br>
                            <select name="gender" class="h-10 w-40 rounded text-sm cursor-pointer">
                                @foreach(\App\Enums\Gender::options() as $value => $label)
                                    <option value="{{ $value }}" @selected($product->gender->value === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Choose size --}}
                        <div class="me-2">
                            <label for="size" class="text-xs">Size*</label> <br>
                            <select name="size" class="h-10 w-40 rounded text-sm cursor-pointer">
                                @foreach(\App\Enums\ShirtSize::options() as $value => $label)
                                    <option value="{{ $value }}" @selected($product->size->value === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Input the price --}}
                        <div class="me-2">
                            <label for="price" class="text-xs">Price*</label> <br>
                            <input type="number" step="0.01" min="0" name="price" class="h-10 w-40 rounded text-sm" value="{{ $product->price }}">
                        </div>
                        {{-- Input the stock --}}
                        <div class="me-2">
                            <label for="stock" class="text-xs">Stock*</label> <br>
                            <input type="number" min="0" name="stock" class="h-10 w-40 rounded text-sm" value="{{ $product->stock }}">
                        </div>
                        {{-- And the description of the product --}}
                        <div class="me-2">
                            <label for="">Description*</label><br>
                            <textarea name="description" cols="50" rows="2" class="text-xs rounded">{{ $product->description }}</textarea>
                        </div>
                </div>
                {{-- Image preview --}}
                    <div class="flex items-center flex-col">
                        <div class="relative border-2 border-dashed rounded-md me-5 self-center mb-5">
                                <ion-icon name="cloud-upload-outline" class="z-0 absolute absolute-center text-9xl text-gray-400 opacity-20"></ion-icon>
                                <img src="{{ $product->image_url }}" alt="{{ $product->shortDescription }}" style="display: block; height: 200px;" class="absolute absolute-center bg-white" id="image-preview" width="400px">
                        </div>
                        <div>
                            <button type="submit" class="py-1 text-sm bg-blue-700 rounded-sm text-white font-light px-2 hover:opacity-50" id="updateTable">Update Table</button>

                            <button type="button" id="closeEditBtn" class="border-2 px-2 py-1 text-sm rounded hover:opacity-50">Cancel</button>
                        </div>
                    </div>
            </div>
        </form>
