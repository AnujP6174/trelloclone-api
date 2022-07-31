{{-- @if (count($errors)>0)
<div class="row">
    <div class="col-md-6 col-md-offset-4 error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif --}}
@if (Session::has('message'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <span>{{Session::get('message')}}</span>
    <button class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif