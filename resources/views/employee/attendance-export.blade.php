@extends('layouts.blain')

@section('header')


@endsection


@section('content')

<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <div class="row">

            <table class="table table-bordered table-responsive" border="1">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Employee</th>
                        <th scope="col">In Time</th>
                        <th scope="col">OUT Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($model as $att)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$att->date}}</td>
                        <td>{{$att->employee->emp_name}}</td>
                        <td>{{$att->in_time}}</td>
                        <td>{{$att->out_time}}</td>
                        <td>{{$att->status}}</td>
                        <td></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection



@push('scripts')
<script type="text/javascript">

</script>
@endpush