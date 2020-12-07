@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Password Reset</a></li>

        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
    <div class="class">
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
          
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush