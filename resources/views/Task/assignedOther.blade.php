@extends('layouts.master')
@section('title')
    Assigned To other
@endsection
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row g-2 mt-3 justify-content-start">
            <h3 style="color: green" class="mt-5">Tasks assigned by me</h3>
            @foreach ($task as $tasks)
                @if ($tasks->assigned_by===Auth::guard('user')->user()->id)
                    <div class="col-12 col-md-2">
                        <a class="btn btn-sm btn-primary" href="{{route('task.show',['task'=>$tasks->id])}}">{{$tasks->title}}</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection