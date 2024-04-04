@props(['route', 'id', 'selectId', 'onchangeFunction', 'inputTypes','option1','option2', 'cancel'])
@if($errors->any()) 
    <div class="text-center py-2 px-2 text-xs font-orange-700 font-bold">
        {{$errors->first()}}
    </div>
@endif
<form action="{{ route($route, ['id' => $id]) }}" class="flex items-center flex-col justify-center rounded px-4 py-2 " method="POST">
    @csrf
    <select name="moveProduct" id="{{$selectId}}" onchange="{{$onchangeFunction}}" class=" text-xs text-center cursor-pointer w-full">
        <option value="1">{{$option1}}</option>
        <option value="2" >{{$option2}}</option>
    </select>
   @if($cancel)
        <div id="{{$inputTypes}}" class="hidden text-center mt-2">                                           
            <label for="userId">User ID:</label>  <br>
            <input type="text" name="userId" class="w-auto text-xs text-center h-6" value="{{old('userId')}}"><br>
            <label for="reason">Reason</label> <br>
            <select name="reason" id="" class="text-xs text-center w-full">
                <option value="1">Wrong Product</option>
                <option value="2">Different Color</option>
                <option value="3">Wrong Design</option>
                <option value="4">Reason 1 </option>
                <option value="5">Reason 2 </option>
                <option value="6">Reason 3 </option>
                <option value="7">Reason 4 </option>
            </select>
        </div><br>
    @endif
    <button type="submit" class="text-sm text-white  rounded px-2 py-1 w-full" style="background-color: #ff8906">Move</button>
</form>