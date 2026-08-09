{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Feedbacks')
{{-- Similar function here  --}}
@section('page','FEEDBACKS')
<x-header />
<x-nav />
        <div>
            <div class="w-full flex justify-center flex-col gap-2 px-5 py-5">
                @foreach ($reviews as $review)
                    <div class="flex ps-5 gap-2 flex-col w-full bg-blue-50 p-2 rounded">
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-row  gap-2  items-center ">
                                <img src="{{ $review->user->profile ? \Illuminate\Support\Facades\Storage::disk('public')->url($review->user->profile) : asset('images/default.png') }}" alt="no image" class="rounded-full w-10">
                                <h6 class="font-bold">{{ $review->user->username }}</h6>
                                @if(! $review->is_featured)
                                    <a onclick="featured({{$review->id}})" class="text-xs  cursor-pointer ">
                                        <ion-icon name="heart-outline" class="text-xl"></ion-icon>
                                    </a>
                                    <form action="{{route('featureReview', ['id' => $review->id])}}" method="POST" id="featureForm{{$review->id}}">
                                        @csrf
                                    @method('PATCH')
                                </form>
                                @else
                                    {{-- The toggle used to be one-way: it wrote the integer 2 and
                                         nothing ever wrote it back. --}}
                                    <a onclick="featured({{$review->id}})" class="text-xs cursor-pointer">
                                        <ion-icon name="heart" class="text-xl"></ion-icon>
                                    </a>
                                    <form action="{{route('featureReview', ['id' => $review->id])}}" method="POST" id="featureForm{{$review->id}}">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                            </div>
                            <div>
                                {{$review->created_at}}
                            </div>
                        </div>
                        <hr class="w-full bg-gray-50">
                        <div class="flex flex-row items-center gap-2 ">
                            <div class="flex items-center gap-2 ">
                                <span class="text-sm ">Overall</span>
                                
                                    @for($i = 0; $i < $review->rating_overall; $i++)
                                        <ion-icon name="star" class="text-base text-yellow-300"></ion-icon>
                                    @endfor
                               
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm ">Quality</span>
                                    @for($i = 0; $i < $review->rating_quality; $i++)
                                        <ion-icon name="star" class="text-base text-yellow-300"></ion-icon>
                                    @endfor
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm ">Service</span>
                                    @for($i = 0; $i < $review->rating_service; $i++)
                                        <ion-icon name="star" class="text-base text-yellow-300"></ion-icon>
                                    @endfor
                            </div>
                        </div>
                        <div class="ms-10">
                            <div class="flex flex-row items-center gap-2 ">
                                <img src="{{ $review->orderItem->image_url }}" alt="" class="w-20">
                                <p class="text-sm indent-10">
                                   {{ $review->comment }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-xs ">Attachment</h1>
                            <img src="{{asset('storage/images/' . $review->image)}}" alt="" class="w-10 cursor-pointer">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<x-adminFooter />

{{-- 
@if(! $review->is_featured)
                            <div class="self-end flex justify-between  p-3  w-full">
                        @else
                            <div class="self-end flex justify-end  p-3 bg-blue-700 w-full">
                        @endif
                           
                            <h1 class="  text-sm ">
                                {{$review->created_at}}
                            </h1>
                       </div>
                       <div class="w-full flex justify-start items-center h-full py-2 px-4 bg-gray-200">
                            <p class="text-sm">
                                {{ $review->comment }}
                            </p>
                       </div>
                       <div class="w-full flex justify-start items-center  gap-2 p-2 bg-gray-200 text-xs">
                            <span>From:</span>
                            {{ $review->user_id }}
                       </div>
                    </div>
                    --}}