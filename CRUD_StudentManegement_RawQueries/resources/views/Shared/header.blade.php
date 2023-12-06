<div class="container">
    <div class="hearder d-flex align-items-center rounded p-3 shadow" style="background-color: #718096">
        <a class="p-1 align-items-center" style="margin-right: auto;color: inherit; text-decoration: none" href="{{route('students')}}"><h4>TRANG CHỦ</h4></a>
        @if($buttonValue)
            <a href="{{route('students')}}">
                <button class="btn btn-success" style="float: right">{{$buttonValue}}</button>
            </a>
        @elseif($buttonValue==null)
            <a href="{{route('add')}}">
                <button class="btn btn-success" style="margin-right: 5px">{{$buttonValue ?? 'ADD'}}</button>
            </a>
        @endif
    </div>
</div>

