<table class="table table-striped" id="thegrid" width="100%">
    <thead>
        <tr>
            <th>SI</th>
            <th>Emp Code</th>
            <th>Emp Name</th>
            <th>Designation</th>
            <th>Project Name</th>
            <th>Leave Balance</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($model as $sal)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$sal->employee->emp_code}}</td>
            <td>{{$sal->employee->emp_name}}</td>
            <td>{{$sal->employee->designation->designation_name}}</td>
            <td>{{$sal->employee->project->project_name}}</td>
            <td>{{$sal->leavebalance}}</td>
        </tr>
        @endforeach
    </tbody>
</table>