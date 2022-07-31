@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('csrf')
    
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row mt-5">
            <div class="col-md-12">
                <a href="{{route('task.create')}}" class="btn btn-primary mt-5">New Task</a>
                <a href="{{route('task.index')}}" class="btn btn-success mt-5">Assigned By Me</a>
                <a href="{{route('task.Overdue')}}" class="btn btn-danger mt-5">Over Due Tasks</a>
            </div>
        </div>
        <div class="row g-2 mt-3 justify-content-start">
            <h3 style="color: green">Tasks assigned to Me</h3>
            @foreach ($tasks as $task)
                @foreach ($task->users as $tasksuser)
                    @if ($tasksuser->pivot->user_id===Auth::guard('user')->user()->id)
                        <div class="col-12 col-md-2">
                            <a class="btn btn-sm btn-primary" href="{{route('task.show',['task'=>$task->id])}}">{{$task->title}}</a>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
@endsection