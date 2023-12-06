@extends('index')
@section('title','Student List Main Page')
@section('students')
    @foreach ($studentList as $student)
        <tr>
            <th scope="row">{{$student->id}}</th>
            <td>{{$student->name}}</td>
            <td>{{$student->age}}</td>
            <td width="125px">
                <img src="{{$student->image}}" style="width: 100px;height: 100px">
            </td>
            <td class="position-relative">
                <p style="position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);">
                    {{$student->class}}
                </p>
            </td>
            <td style="position: relative">
                <div
                    style="margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);">
                    <a href="{{route('edit',[$student->id])}}">
                        <button class="btn btn-warning">Sửa</button>
                    </a>
                    <form action="{{route('delete',[$student->id])}}" method="post" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-danger" type="submit" value="Delete"/>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@endsection
