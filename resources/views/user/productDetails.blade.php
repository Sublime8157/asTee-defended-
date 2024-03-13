@foreach($productDet as $data)
    {{$data->id}} <br>
    {{$data->description}} <br>
    {{$data->image_path}} <br>
    {{$data->variationType()}}<br>
        {{$data->description}}<br>
        {{$data->genderShirt()}}<br>
        {{$data->sizeShirt()}}<br>
        {{$data->price}}<br>
        {{$data->quantity}}<br>
@endforeach