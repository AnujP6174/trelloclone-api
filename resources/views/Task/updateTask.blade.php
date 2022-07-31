@extends('layouts.master')
@section('title')
    Update Task
@endsection
@section('content')
<section class="row justify-content-center mt-5 mb-4">
    <div class="col-md-6 col-md-offset-3 mt-2">
        <header class="mt-3 text-center"><h3>Update Task</h3></header>
        <form action="{{route('task.update',['task'=>$tasks->id])}}" method="POST" id="addtask">
            @method('PUT')
            @csrf
            <div class="form-group mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{$tasks->title}}">
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}*</span>
                @endif
            </div>

            <div class="form-group mb-4">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{$tasks->description}}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}*</span>
                @endif
            </div>

            <div class="form-group mb-4">
                <label for="emp">Select Employees</label>
                <select name="emp[]" id="emp" placeholder="Select Employees" multiple>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @foreach ($tasks->users as $task)
                                {{$task->id===$user->id ? 'selected': ''}}
                            @endforeach>{{$user->name}}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('emp'))
                    <span class="text-danger">{{ $errors->first('emp') }}*</span>
                @endif
            </div>

            <div class="form-group mb-4">
                <label for="deadline">Deadline</label>
                <input type="date" class="form-control border-1" id="deadline" name="deadline" value="{{$tasks->due_date}}">
                @if ($errors->has('deadline'))
                    <span class="text-danger">{{ $errors->first('deadline') }}*</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary me-2">Update Task</button>
            <a class="btn btn-danger" href="{{ route('user.Dashboard') }}">Cancel</a>
        </form>
    </div>
</section>
@endsection
@section('js')
    <script>
    $(function(){
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#deadline').attr('min', maxDate);
    });
    var multipleCancelButton = new Choices('#emp', {
        removeItemButton: true,
        // maxItemCount:5,
        // searchResultLimit:5,
        // renderChoiceLimit:5,
      });
    </script>
    <script src="{{URL::to('src/js/taskValidation.js')}}"></script>
@endsection