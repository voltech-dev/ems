@extends('layouts.project')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
<div class="page-leftheader">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>	  
    </ol>
</div>
</div>
@endsection

@section('content')
<div class="p-6">
    <div class="ml-1">
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <p>This is my body content.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush