@props(['route', 'id', 'selectId', 'onchangeFunction', 'inputTypes','option1','option2', 'cancel'])

<form action="{{ route($route, ['id' => $id]) }}" class="flex items-center flex-col justify-center rounded px-4 py-2 " method="POST">
    @csrf
    <select name="moveProduct" id="{{$selectId}}" onchange="{{$onchangeFunction}}" class=" text-xs text-center cursor-pointer w-full">
        <option value="1">{{$option1}}</option>
        <option value="2" >{{$option2}}</option>

    </select>
   @if($cancel)
        <div id="{{$inputTypes}}" class="hidden text-center mt-2">                                           
            <label for="userId">Product Id:</label>  <br>
            <input type="text" name="userId" class=" w-auto text-xs text-center h-6"><br>
            <label for="reason">Reason</label> <br>
            <textarea name="reason" id="" cols="30" rows="5" class="text-xs text-center"></textarea> 
        </div><br>
    @endif
    <button type="submit" class="text-sm text-white  rounded px-2 py-1 w-full" style="background-color: #ff8906">Move</button>
</form>