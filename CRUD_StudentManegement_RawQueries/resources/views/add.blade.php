<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css')}}">
    <title>Add student</title>
</head>

<body>
@php
    $buttonValue = null;
@endphp
@include('Shared.header')
<div class="container">
    <form method="post" action="{{ route('store-form') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1" class="mt-3">Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                   placeholder="Input name" @error('name') is-invalid @enderror value="{{old('name')}}">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1" class="mt-3">Age:</label>
            <input type="text" class="form-control @error('age') is-invalid @enderror" id="age" name="age"
                   placeholder="Input age" value="{{old('age')}}">
            @error('age')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Image:</label>
            <img src="#" id="previewImg" alt="noImg" class="form-control" style="width: 100px;height: 100px">
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image"
                   onchange="loadFile(event)" value="{{old('image')}}">
        </div>
        @error('image')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
        <div class="form-group">
            <label for="exampleFormControlSelect1">Class:</label>
            <select class="form-control @error('classroom_id') is-invalid @enderror" name="classroom_id">
                @foreach ($classList as $class)
                    <option value="{{$class->id}}">{{$class->classname}}</option>
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
    var loadFile = function (event) {
        var prvImg = document.getElementById("previewImg");
        prvImg.src = URL.createObjectURL(event.target.files[0]);
        console.log(prvImg)
    }
</script>
