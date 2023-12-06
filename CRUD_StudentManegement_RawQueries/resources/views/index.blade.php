<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css')}}">
</head>

<body>
@php
    $buttonValue = null;
@endphp
@include('Shared.header')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if(session('msg'))
                @if(session('msg')=="Wrong user")
                    <div class="alert alert-danger mt-1">{{session('msg')}}</div>
                @else
                    <div class="alert alert-success mt-1">{{session('msg')}}</div>
                @endif
            @endif
            <div class="float-end">
                <form action="{{url('students')}}" class="d-flex align-items-center" method="get">
                    <div class="row mt-3">
                        <div class="col-4">
                            <select class="form-control" name="classroom_id">
                                <option value="0">Tất cả các lớp</option>
                                @if(!empty(getClassroom()))
                                    @foreach(getClassroom() as $classroom)
                                        <option value={{$classroom->id}}
                                                {{request()->classroom_id==$classroom->id?'selected':false}}>
                                            {{$classroom->classname}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-5">
                            <input class="form-control" placeholder="Tìm kiếm" name="keyword"
                                   value="{{$keyword}}"/>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-success" type="submit">Tìm kiếm</button>
                        </div>
                    </div>
                </form>

            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tuổi</th>
                    <th scope="col">Ảnh đại diện</th>
                    <th scope="col" style="text-align: center">Lớp</th>
                    <th scope="col" style="text-align: center">Chức năng</th>
                </tr>
                </thead>
                <tbody>
                @yield('students')
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

</html>
