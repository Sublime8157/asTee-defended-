@foreach($userData as $user)
<tr class="">                      
    <td class="flex justify-center items-center text-left pe-52 w-96">                          
        <div class="me-1">
            <img src=" {{ asset('images/adminIcon.jpg') }}" alt="" width="60">
        </div>
    <div>
        <span class=" text-sm font-bold">{{ $user->fname . " ". $user->lname }}</span> <br>
        <span style="font-size: 10px">{{$user->email}}</span>
    </div>                                                                       
    </td>
    <td>{{ $user->id }}</td>
    <td>{{ $user->username }}</td>
    <td>{{$user->email_verified_at}}</td>
    <td><ion-icon name="ellipsis-horizontal" class="text-2xl cursor-pointer"></ion-icon></td>
</tr>
<tr>
    <td colspan="5"><hr></td>
</tr>
@endforeach