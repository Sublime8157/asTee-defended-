<x-header />
<x-navbar />


    <div class="h-auto  w-full flex flex-row justify-center md:justify-start  mt-0.5  px-0 md:px-24 z-0"> 
        {{-- Filtering section  --}}
        <div class="text-xs py-10 px-4  w-64 mb-0  hidden md:block h-auto">
           <form action="/filterProducts" method="get" id="filterForm">
                <ul>
                    <li class="font-bold text-xs mb-2">
                        Filter
                    </li>
                    <hr class="mb-2">
                </ul>
                {{-- Filter All --}}
                <ul class="ps-3 p-1 mb-2">
                    <input type="radio" id="all" name="all" value="" class="w-3 h-3">
                    <label for="all">All</label>
                </ul>
                {{-- Filter by Variations --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs mb-2 ">
                        Variation
                    </li>
                    <hr class="mb-2">
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="variations" value="2" class="w-3 h-3 cursor-pointer me-1 ">
                        <label for="T-Shirt" style="font-size: 11px">Solo </label>
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="variations" value="3" class="w-3 h-3 cursor-pointer me-1 ">
                        <label for="familyshirt" style="font-size: 11px">Family </label>
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="variations" value="1" class="w-3 h-3 cursor-pointer me-1 ">
                        <label for="familyshirt" style="font-size: 11px">Couple </label>
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="variations" value="4" class="w-3 h-3 cursor-pointer me-1 ">
                        <label for="familyshirt" style="font-size: 11px">Kid's Wear</label>
                    </div>
                </ul>
                {{-- Filter by sizes --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs mb-2">
                        Sizes
                    </li>
                    <hr class="mb-2">
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="1" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">Small</label>              
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="2" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">Small</label>              
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="3" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Medium">Medium</label>          
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="4" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">Large</label>              
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="5" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">XL</label>              
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="6" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">2XL</label>              
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="sizes" value="7" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">3XL</label>              
                    </div>
                </ul>
                {{-- Filter by Gender --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs mb-2">
                        Gender
                    </li>
                    <hr class="mb-2">
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="gender" value="1" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Small">Male</label>              
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="gender" value="2" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Medium">Female</label>          
                    </div>
                    <div class="flex flex-row ps-3 p-1 items-center">
                        <input type="radio" name="gender" value="3" class="w-3 h-3 cursor-pointer me-1">
                        <label for="Medium">Unisex</label>          
                    </div>
                </ul>
                <div class="w-auto flex justify-center items-center">
                    <button type="submit" class="px-2 w-full py-1 bg-red-600 text-white text-sm text-center rounded">Filter</button>
                </div>
           </form>
        </div>
        {{-- List of available products  --}}
        <div class="flex flex-wrap h-auto  justify-center self-start ms-3 mb-5 md:ms-20" id="filterProduct">
            {{-- Get all the data in products table and assign it to filterData variable --}}
            @foreach($filteredData as $table)
            <div class="flex flex-col items-center justify-center w-48 h-auto px-3 py-5 border-black shadow-lg rounded ">      
                    <img src="{{ asset('images/' . $table->image_path) }}" alt="" class="rounded">
                    <div class="mt-2 text-xs ">
                        <div class="text-center"><span class="font-bold">Short Description:</span> <br> {{ $table->description }}</div>
                    </div>
                    <div class="mt-2 text-xs ">
                    <span class="font-bold">Variation:</span>  {{ $table->variationType() }} 
                    </div>
                    <div class="text-xs">
                        <span class="font-bold">Gender:</span> {{ $table->genderShirt() }}
                </div>
                    <div class="text-xs">
                        <span class="font-bold">Size:</span> {{ $table->sizeShirt() }}
                    </div>
                    <hr class=" text-black mt-3 mb-1 w-full">
                    <div class="text-center px-1">
                        <h6 class="text-bold">
                        ${{ $table->price }}
                        </h6>
                        <button class="w-36  px-3 py-1 bg-orange-300 text-white font-extralight rounded hover:bg-orange-100">
                        Add to Cart
                        </button>
                    </div>
            </div>
            @endforeach
        </div>
    </div>

<x-footer />
<script src="products.js"></script>
<x-scripts />