@extends('layouts.master')
@section('title')
    Task Details
@endsection
@section('content')
<div class="container mt-5 mb-5">
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3 mt-5">
            <div class="card mb-3 mt-5" style="width: 540px;">
                <h3 class="text-center card-header">Task Details</h3>
                    <div class="row g-0">
                        <div class="col-12 px-4 mt-3">
                            <p><span style="color: green">Title: </span>{{$tasks->title}}</p>
                            <p><span style="color: green">Description: </span>{{$tasks->description}}</p>
                            <p><span style="color: green">Deadline: </span>{{Carbon\Carbon::parse($tasks->due_date)->format('d/m/Y')}}</p>
                            <p><span style="color: green">Assigned To: </span>
                                @php
                                    $out=array();
                                    foreach ($tasks->users as $task) {
                                        array_push($out,"$task->name");
                                    }
                                    echo implode(', ',$out);
                                @endphp
                            </p>
                        </div>
                    </div>
            </div>
            <div>
                @if ($tasks->due_date>=Carbon\Carbon::now()->toDateString())
                    <a data-task={{$tasks->id}} data-user={{$user}} class="btn btn-primary mt-2 me-3 commentbtn">Comment</a>
                @endif
                @if ($tasks->assigned_by===$user)
                    <a href="{{route('task.edit',['task'=>$tasks->id])}}" class="btn btn-success mt-2">Edit</a>
                @endif
            </div>
            <div class="mt-4">
                <h4 style="color: #008000">All Comments</h4>
                <hr>
                <div class="test">
                    {{-- @foreach ($comments as $comment)
                        <p><span style="color: green">Commented By: </span>{{$comment->user->name}}</p>
                        <div class="d-flex justify-content-between align-items-center web">
                            <p style="margin: 0" id="comment_tag">{{$comment->comment}}</p>
                            @if (Carbon\Carbon::now()->toDateString()<=$tasks->due_date && $comment->user_id===$user)
                                <a data-task={{$tasks->id}} data-user={{$user}} data-comment={{$comment->id}} class="btn btn-sm btn-outline-info cmntupbtn">Edit</a>
                            @endif
                        </div>
                    @endforeach
                    <hr> --}}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- comment modal starts --}}
<div class="modal fade" tabindex="-1" id="cmntmodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="cmntform">
                @csrf
                <div class="form-group">
                    <label for="comment">Add Comment</label>
                    <textarea class="form-control" name="comment" placeholder="Enter Comment" id="comment" rows="5"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="modalsave">Add Comment</button>
        </div>
      </div>
    </div>
</div>
{{-- comment modal ends --}}

{{-- comment update starts --}}
<div class="modal fade" tabindex="-1" id="commentupdatemodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="cmntform">
                @csrf
                <div class="form-group">
                    <label for="comment">Update Comment</label>
                    <textarea class="form-control" name="comment" placeholder="Enter Comment" id="updatecomment" rows="5"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="modalsavee">Update Comment</button>
        </div>
      </div>
    </div>
</div>
{{-- comment update ends --}}
@endsection
@section('js')
    <script>
        var token="{{csrf_token()}}";
        var urlComment="{{route('add.Comment')}}";
        var urlUpdateComment="{{route('update.Comment')}}";
        // var currentDate= new Date().toLocaleDateString().split('/').reverse().join("-");
        var currentDate= new Date().toISOString().slice(0, 10);
        let task = {!! json_encode($tasks, JSON_HEX_TAG) !!};
        function getComment(){
            $.ajax({
                method: "get",
                url: '{{ route('get.comment',':id')}}'.replace(':id', task?.id),
                success: function (response) {
                    let data = '';
                    response?.comment?.map(e => 
                        data += '<div>'
                            +'<p><span style="color: green">Commented By: </span>'
                            +e.user.name
                            +'</p>'
                            +'<div class="d-flex justify-content-between align-items-center">'
                            +'<p style="margin: 0" id="comment_tag">'
                            +e.comment
                            +'</p>'
                            +(currentDate<=e.task.due_date && e.user_id===response.users.id?"<a class='btn btn-sm btn-outline-warning commentupdatebtn' data-comment="+e.id+" data-task="+e.task.id+" data-user="+response.users.id+" onclick=updateComment()>Edit</a>":"")
                            +'</div><hr>',
                    );
                    $('.test').html(data);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
        getComment();
        function addComment(){

        }
        function updateComment(){
            $(".commentupdatebtn").click(function (event) {
                event.preventDefault();
                userId = event.target.dataset["user"];
                taskId = event.target.dataset["task"];
                cmntId = event.target.dataset["comment"];
                taskbody = event.target.previousElementSibling;
                var cmntdata = taskbody.textContent;
                $("#updatecomment").val(cmntdata);
                $("#commentupdatemodal").modal("show");
            });
            $("#modalsavee").click(function () {
                $.ajax({
                    method: "POST",
                    url: urlUpdateComment,
                    data: {
                        userId: userId,
                        taskId: taskId,
                        cmntId: cmntId,
                        comment: $("#updatecomment").val(),
                        _token: token,
                    },
                    success: function (response) {
                        getComment();
                        $("#commentupdatemodal").modal("hide");
                        // alert("Comment updated");
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Comment not updated");
                    },
                });
            });
        }
    </script>
    <script src="{{URL::to('src/js/commentModal.js')}}"></script>
@endsection