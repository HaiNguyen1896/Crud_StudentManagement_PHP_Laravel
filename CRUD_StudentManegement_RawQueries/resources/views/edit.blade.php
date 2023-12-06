<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap.min.css')}}">--}}
{{--    <script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>--}}
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css')}}">
    <title>Edit student information</title>
</head>
<body>

@php
    $buttonValue = 'BACK'
@endphp
@include('Shared.header')
@if(session('msg'))
    <div class="alert alert-danger">{{session('msg')}}</div>
@endif
<div class="container">
    <form method="post" action="{{ route('edit-form')}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="exampleFormControlInput1" class="mt-3">Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                   placeholder="Input name" value="{{$student[0]->name}}" @error('name') is-invalid @enderror>
            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1" class="mt-3">Age:</label>
            <input type="text" class="form-control" value="{{$student[0]->age}}" @error('age') is-invalid @enderror
            id="age" name="age" placeholder="Input age">
            @error('age')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Image:</label>
            <img src={{$student[0]->image}} id="previewImg" alt="prvImg" style="height: 100px" width="100px" class="m-2">
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                   name="image" onchange="loadFile(event)">
        </div>
        @error('image')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <div class="form-group">
            <label for="exampleFormControlSelect1">Class:</label>
            <select class="form-control" @error('classroom_id') is-invalid @enderror name="classroom_id" id={{$student[0]->classroom_id}}>
                @foreach ($classList as $class)
                    <option
                        value="{{$class->id}}" {{$student[0]->classroom_id==$class->id ? 'selected' : ''}}>
                        {{$class->classname}}
                    </option>
                @endforeach
            </select>
            @error('classroom_id')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-success float-right mt-3">Create</button>
    </form>
</div>
</body>
</html>
<script>
  var loadFile =  function(event)  {
        var previewImg = document.getElementById('previewImg');
        previewImg.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
