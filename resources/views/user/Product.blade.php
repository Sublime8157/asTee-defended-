<x-header />
<x-navbar />


    <div class="h-auto  w-full flex flex-row justify-center md:justify-start  mt-0.5  px-0 md:px-24 z-0"> 
        {{-- Filtering section  --}}
        <div class="text-xs py-10 px-4   w-64 mb-0  hidden md:block h-auto">
           <form action="/filterProducts" method="GET" id="filterForm">
            @csrf
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
                    @foreach(['Couple', 'Solo', 'Family', 'Kid\'s Wear'] as $key => $variation)
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="variations" value="{{ $key + 1 }}" class="w-3 h-3 cursor-pointer me-1"
                                {{ old('variations') == ($key + 1) ? 'checked' : '' }}>
                            <label for="{{ strtolower(str_replace('\'', '', $variation)) }}" style="font-size: 11px">{{ $variation }}</label>
                        </div>
                    @endforeach
                </ul>
                {{-- Filter by sizes --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs mb-2">
                        Sizes
                    </li>
                    <hr class="mb-2">
                    @foreach(['Extra Small','Small','Medium','Large','XL','2XL','3XL'] as $key => $sizes) 
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="sizes" value="{{ $key + 1 }}" class="w-3 h-3 cursor-pointer me-1" 
                                {{ old('sizes') == ($key + 1) ? 'checked' : '' }}>
                            <label for=" {{ strtolower(str_replace('\'','', $sizes)) }}" style="font-size: 11px"> {{ $sizes }} </label>
                        </div>
                    @endforeach
                </ul>
                {{-- Filter by Gender --}}
                <ul class="flex flex-col mb-2">
                    <li class="font-bold text-xs mb-2">
                        Gender
                    </li>
                    <hr class="mb-2">
                   @foreach(['Male','Female','Unisex'] as $key => $gender) 
                        <div class="flex flex-row ps-3 p-1 items-center">
                            <input type="radio" name="gender" value=" {{ $key + 1 }}" class="w-3 h-3 cursor-pointer me-1"
                            {{ old('gender') == ($key + 1) ? 'checked' : ''}}>
                            <label for=" {{ strtolower(str_replace('\'','', $gender))}}" style="font-size: 11px"> {{ $gender }} </label>
                        </div>
                   @endforeach
                </ul>
                <div class="w-auto flex justify-center items-center">
                    <button type="submit" class="px-2 w-full py-1 bg-red-600 text-white text-sm text-center rounded">Apply</button>
                </div>
           </form>
        </div>
        {{-- List of available products  --}}
        <div class="flex flex-wrap h-auto  md:justify-start justify-center self-start ms-3 mb-5 md:ms-20" id="filterProduct">
            {{-- Get all the data in products table and assign it to filterData variable --}}
          @if($filteredData->isEmpty()) 
               <div class="flex justify-center items-center h-screen">
                    <h1>No Available Product</h1>
               </div>
          @else
                @foreach($filteredData as $table)
                        <div class="flex flex-col items-center justify-center w-48 h-auto px-3 py-5 border-black shadow-lg rounded" id="filterData">      
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
            @endif
        </div>
    </div>

<x-footer />
<script src="products.js"></script>
<x-scripts />