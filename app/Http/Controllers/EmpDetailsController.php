<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\ProjectDetails;
use App\Models\Locations;
use App\Models\Statuses;

class EmpDetailsController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    return view('EmpDetails.index');
  }

  public function create(Request $request)
  {
    return view('EmpDetails.add', [
      []
    ]);
  }

  public function edit(Request $request, $id)
  {
    $batch = EmpDetails::findOrFail($id);
    return view('EmpDetails.edit', [
      'model' => $batch    ]);
  }

  public function show(Request $request, $id)
  {
    $batch = EmpDetails::findOrFail($id);
    return view('EmpDetails.show', [
      'model' => $batch    ]);
  }

  public function viewdata(Request $request)
  {  
    $columns = [
        ['db' => 'id', 'dt' => 0],
        ['db' => 'emp_code', 'dt' => 1],
        ['db' => 'emp_name', 'dt' => 2],
        ['db' => 'designation_id', 'dt' => 3],
        ['db' => 'department_id', 'dt' => 4],

    ];
    // $where = 'status=>Entry Completed';
    echo json_encode(
        Dtssp::simple($_GET, 'emp_details', 'id', $columns, $jointable = null, $where=null)
    );

  }


  public function update(Request $request,$id) {
   $this->validate($request, [
    'customer_id' => 'required',
    'cases' => 'required',
    'tat' => 'required',
    'batch_date' => 'required',
  ]);

  $batch =  Batch::find($id);      
    $batch->customer_id = $request->customer_id;      
    $batch->batch_date = date('Y-m-d', strtotime($request->batch_date));      
    $batch->cases = $request->cases;      
    $batch->tat = $request->tat;      
   // $batch->created_at = $model->freshTimestamp();      
   // $batch->status = 'Entry Pending';     
  $batch->save();

  return redirect('/batches');

}

public function store(Request $request)
{
  $batch = new Batch;
  
    
    $this->validate($request, [
    'customer_id' => 'required',
    'cases' => 'required',
    'tat' => 'required',
    'batch_date' => 'required',
  ]);

      
    $batch->customer_id = $request->customer_id;      
    $batch->batch_date = date('Y-m-d', strtotime($request->batch_date));      
    $batch->cases = $request->cases;      
    $batch->tat = $request->tat;      
    $batch->created_at = $batch->freshTimestamp();      
    $batch->status = 'Entry Pending';     
  $batch->save();
     

  return redirect('/batches');
}

public function destroy(Request $request, $id) {

  $batch = Batch::findOrFail($id);

  $batch->delete();
  return "OK";

}

        ################ Project  ##############


 public function projectcreation(Request $request)
{

  return view('Project.projectcreation', [
    
  ]);
}
public function projectstore(Request $request)
{
    $project = new ProjectDetails();
    $project->project_name = $request->project_name;
    $project->save();

  return view('Project.projectlist', [
    
  ]);
}
public function projectlist(Request $request)
  {  
    return view('Project.projectlist', [
        ]);

  }

  public function projectdata(Request $request)
  {  
    $columns = [
        ['db' => 'id', 'dt' => 0],
        ['db' => 'project_name', 'dt' => 1],
        
       

    ];
    // $where = 'status=>Entry Completed';
    echo json_encode(
        Dtssp::simple($_GET, 'project_details', 'id', $columns, $jointable = null, $where=null)
    );

  }
  public function projectedit(Request $request, $id)
    {
        $project = ProjectDetails::findOrFail($id);
        return view('Project.projectedit', [
            'model' => $project]);
    }

    public function projectupdate(Request $request,$id)
{
    $project_update =ProjectDetails::find($request->id);
    $project_update->project_name = $request->project_name;
    $project_update->save();

  return view('Project.projectlist', [
    
  ]);
}

            ############  location  #########
    
public function locationcreation(Request $request)
{

  return view('Location.locationcreation', [
    
  ]);
}

  public function locationlist(Request $request)
  {  
    return view('Location.locationlist', [
        ]);

  }

  public function locationdata(Request $request)
  {  
    $columns = [
        ['db' => 'id', 'dt' => 0],
        ['db' => 'location', 'dt' => 1],
       

    ];
    // $where = 'status=>Entry Completed';
    echo json_encode(
        Dtssp::simple($_GET, 'locations', 'id', $columns, $jointable = null, $where=null)
    );

  }

  public function locationstore(Request $request)
{
    $location = new Locations();
    $location->location = $request->location_name;
    $location->save();

  return view('Location.locationlist', [
    
  ]);
}

public function locationedit(Request $request, $id)
{
    $location = Locations::findOrFail($id);
    return view('Location.locationedit', [
        'model' => $location]);
}

public function locationupdate(Request $request,$id)
{
$location_update =Locations::find($request->id);
$location_update->location = $request->location_name;
$location_update->save();

return view('Location.locationlist', [

]);
}

############## status ####################

public function statuslist(Request $request)
{  
  return view('Project.statuslist', [
      ]);

}

public function statusdata(Request $request)
  {  
    $columns = [
        ['db' => 'id', 'dt' => 0],
        ['db' => 'status', 'dt' => 1],
       

    ];
    // $where = 'status=>Entry Completed';
    echo json_encode(
        Dtssp::simple($_GET, 'statuses', 'id', $columns, $jointable = null, $where=null)
    );

  }

  public function statuscreation(Request $request)
{

  return view('Project.statuscreation', [
    
  ]);
}

public function statusstore(Request $request)
{
    $status = new Statuses();
    $status->status = $request->status;
    $status->save();

  return view('Project.statuslist', [
    
  ]);
}

public function statusedit(Request $request, $id)
{
    $status_edit = Statuses::findOrFail($id);
    return view('Project.statusedit', [
        'model' => $status_edit]);
}

public function statusupdate(Request $request,$id)
{
$status_update =Statuses::find($request->id);
$status_update->status = $request->status;
$status_update->save();

return view('Project.statuslist', [

]);
}


}
