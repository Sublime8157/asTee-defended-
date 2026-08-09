@if($products->isEmpty()) 
<div class="flex justify-center items-center h-screen">
     <h1>No Available Product</h1>
</div>
@else
 @foreach($products as $product)
     <div class="w-60 mt-5  bg-white  flex flex-col border shadow rounded border-gray-100 pb-2 me-2" style="height: 420px">
             <div class="relative productImage">   
                 {{-- product image  --}}
                 <img src="{{ $product->image_url }}" alt="{{ $product->shortDescription }}" >
             <div class=" showIcons h-auto  ">
                 <div class=" absolute left-0 bottom-0">
                     {{-- cart icon  --}}
                     <a href="">
                         <ion-icon name="cart" class="ps-2 text-green-600 text-xl">
                         </ion-icon>
                     </a>
                     {{-- share link icon  --}}
                     <a href="">
                         <ion-icon name="share-social" class="text-green-600 text-xl" onclick="copyLink(event, {{ $product->id }})"></ion-icon>
                     </a>
                 </div>
             
             </div>
             </div>
             <div class="px-2 ">
                 <div class="px-1 mt-3">
                     {{-- description w/ gender --}}
                     <p class="text-sm">{{ $product->shortDescription }} | {{ $product->gender->label() }} | {{ $product->variation->label() }}</p>                       
                 </div> 
                     {{-- Size  --}}
                 <div class="text-xs px-1">
                     <b> Size:</b> {{ $product->size->label() }} 
                 </div>
                 <div class="px-1">
                     {{-- Price --}}
                     <h4 class="text-2xl font-semibold  tracking-wide">
                         &#x20B1;{{ $product->price }}
                     </h4>
                 </div>
                 <div class="px-1">
                     {{-- link --}}
                     <a href="/productDetails/{{ $product->id }}" class="text-xs text-blue-700 cursor-pointer hover:underline">More details..</a>
                 </div>
                 
             </div>
     </div>
 @endforeach
 
@endif