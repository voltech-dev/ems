@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payroll</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Salary {{$model->employee->emp_name}}</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);

?>
@section('content')
<div class="ml-1">
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm ">
      

salary view by nehru
       



    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush