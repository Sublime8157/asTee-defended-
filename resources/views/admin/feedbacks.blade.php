{{-- The @section inherit the @yield in components.header with a string of docu that change it to Dashboard --}}
@section('docu', 'Feedbacks')
{{-- Similar function here  --}}
@section('page','FEEDBACKS')
<x-header />
<x-nav />
        <div>
            <div class="w-full flex justify-center flex-col gap-2 px-10 py-5">
                @foreach ($feedbacks   as  $review)
                    <div class="flex flex-col w-full">
                        @if($review->featured == 1 )
                            <div class="self-end flex justify-between  p-3 bg-blue-700 w-full">
                        @else
                            <div class="self-end flex justify-end  p-3 bg-blue-700 w-full">
                        @endif
                            @if($review->featured == 1) 
                                <a onclick="featured({{$review->id}})" class="text-xs  text-orange-200 underline cursor-pointer ">Feature this</a>
                                <form action="{{route('featureReview', ['id' => $review->id])}}" method="POST" id="featureForm{{$review->id}}">
                                    @csrf
                                   @method('PATCH');
                                </form>
                            @endif
                            <h1 class="text-white  text-sm ">
                                {{$review->created_at}}
                            </h1>
                       </div>
                       <div class="w-full flex justify-start items-center h-full py-2 px-4 bg-gray-200">
                            <p class="text-sm">
                                {{$review->specify}}
                            </p>
                       </div>
                       <div class="w-full flex justify-start items-center  gap-2 p-2 bg-gray-200 text-xs">
                            <span>From:</span>
                            {{$review->userId}}
                       </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<x-adminFooter />