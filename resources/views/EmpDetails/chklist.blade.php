

<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
?>

<div class="ml-1">

    <div style="line-height:2; font-size:16px">

        <div class="form-group row">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap table-hover" id="checklist" width="100%"
                    style="font-size: 0.575rem; padding:0px;">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Emp Code</th>
                            <th>Emp Name</th>
                            <th>Proj Site</th>
                            @foreach($model as $docu)
                            <th>{{$docu->doc_type_name}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emp as $empl)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$empl->emp_code}}</td>
                            <td>{{$empl->emp_name}}</td>
                            <td>{{$empl->project->project_name}}</td>
                            @foreach($model as $docu)
                            @if($docu->getDocuments($empl->id,$docu->doc_type_name))
                            <td>Y</td>
                            @else
                            <td>N</td>
                            @endif
                            @endforeach
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

