@extends('layouts.master')
@section('title')
    Over Due Tasks
@endsection
@section('content')
<div class="container mt-5 mb-5">
    <div class="row g-2 mt-3 justify-content-start">
        <h3 style="color: red" class="mt-5">Over Due Tasks</h3>
        @foreach ($task as $tasks)
            @foreach ($tasks->users as $taskuser)
                @if($taskuser->id===Auth::guard('user')->user()->id)
                    <div class="col-12 col-md-2">
                        <a class="btn btn-sm btn-success" href="{{route('task.show',['task'=>$tasks->id])}}">{{$tasks->title}}</a>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
</div>
@endsection