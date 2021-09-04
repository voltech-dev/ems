<?php
error_reporting(0);
?>
<table class="table text-nowrap table-responsive table-bordered " width="100%" >
    <thead class="thead-light">
        <tr>
            <th style="width:5%">id</th>
            <th data-dt="emp_code" data-type="varchar" style="width:10%">Emp Code</th>
            <th data-dt="emp_name" data-type="varchar" style="width:20%">Emp Name</th>
            <th data-dt="mail" data-type="varchar" style="width:20%">Email</th>
            <th data-dt="designation_id" data-type="int" data-table="designations" data-field ="designation_name,id" style="width:10%">Designation</th>
            <th data-dt="project_id" data-type="int" data-table="project_details" data-field ="project_name,id" style="width:20%">Project Name</th>
            <th data-dt="status_id" data-type="int" data-table="statuses" data-field ="status,id" style="width:10%">Status</th>
            <th style="width:5%">Action</th>         
        </tr>
    </thead>
    <tbody>
        @foreach($emp as $empd)
            <tr>
                <td>{{ ++$i }}</td>
                <td><a href="{{ url('empview/'.$empd->id)}}">{{ $empd->emp_code }}</a></td>
                <td>{{ $empd->emp_name }}</td>
                <td>{{ $empd->mail }}</td>
                <td>{{ $empd->designation->designation_name }}</td>
                <td>{{ $empd->project->project_name }}</td>
                <td>{{ $empd->status->status }}</td>
                <td><a href="{{ url('empdetails/'.$empd->id.'/edit') }}"> <i class="ion ion-edit"></i> </a></td>                            
            </tr>
        @endforeach
    </tbody>
</table>

{{ $emp->appends($data)->links('layouts.pagination') }}