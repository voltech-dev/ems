@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>User List</a></li>

        </ol>
    </div>
</div>
<br>
<div class="col text-right"> <button onclick="location.href='#'" class="btn-primary">Create</button>
</div>
@endsection
<?php
use Carbon\Carbon;
$dt =new Carbon();
echo $dt->toDateString();
   
?>
@section('content')
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <table class="table table-striped" id="usertable" width=>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->id}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td><a href="#" data-toggle="modal" data-target="#exampleModal" data-id="{{ $user->id }}">Change
                            pwd</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('/passwordreset')}}">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name" class="col-form-label">User:</label>
                        <input type="text" class="form-control" id="user-name" value="">
                        <input type="hidden" class="form-control" id="user-id" name="user_id" value="">
                    </div>
                    <div class="form-group">
                        <label for="user-pass" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="user-password" name="user_password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('#exampleModal').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data('id');

        $.get('passresetdata/' + id, function(data) {
            $('#user-id').val(data.id);
            $('#user-name').val(data.name);

        });

    });
});
</script>
@endpush