@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="empdetails"><i class="fe fe-layers mr-2 fs-14"></i>Emp Details</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>EMS Login </a></li>
        </ol>
    </div>
</div>
@endsection


@section('content')
<div class="ml-1 mt-5" style="min-height: 370px;">

    <form action="{{ url('/storeuser') }}" method="POST" role="form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="emp_id" value="{{$model->id}}">
        <input type="hidden" name="name" value="{{$model->emp_name}}">
        <div class="form-group row">
        
            <label for="email" class="col-md-4 form-label text-md-right">Email</label>
            <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email" value="{{$model->mail }}" readonly>
            </div>

            <label for="password" class="col-md-4 form-label text-md-right pt-5"> Password</label>
            <div class="col-md-6">
                <input id="password" type="text" class="form-control mt-5" name="password" value="{{$model->emp_code}}" readonly>
            </div>

            <label for="password" class="col-md-4 form-label text-md-right pt-5"> </label>
            <div class="col-md-6">            
            @if(!App\Models\User::where(['emp_id'=>$model->id])->exists())
            <button type="submit" class="btn btn-primary mt-5">
                         Make Employee as EMS User
                    </button>
            @endif
            </div>
        </div>
     
</div>
@endsection