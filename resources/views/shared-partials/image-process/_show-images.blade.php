@if(isset($folder) && session($folder)!=null)
    @foreach(session($folder) as $k=>$i)
        <div class="col-md-4" style="margin-bottom: 10px">
            @php($data = getimagesize($i['image']))
            <img width="{{$data[0]/3}}" height="{{$data[1]/3}}" src="{{$i['image']}}"/>
            <div style="width: {{$data[0]/3}}px; background-color: white ">
                <a onclick="removeImage('{{$i['remove_route']}}'+'/'+'{{$k}}'+'/'+'{{$folder}}','{{$modal_id}}')"
                   href="javascript:" class="call-when-done">
                    <center style="color: #ff6161">
                        <i class="fa fa-trash"></i>
                    </center>
                </a>
            </div>
        </div>
    @endforeach
@endif
