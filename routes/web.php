<?php
use App\Http\Controllers\EmpDetailsController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    if (Auth::user()->role == 'Administrator') {
        return view('/dashboard');
    } elseif (Auth::user()->role == 'Employee') {
        return view('/empdashboard');
    } else {
        return view('/projectdashboard');
    }
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role == 'Administrator') {
        return view('/dashboard');
    } elseif (Auth::user()->role == 'Employee') {
        return view('/empdashboard');
    } else {
        return view('/projectdashboard');
    }
})->name('dashboard');
Route::get('/Project/projectlist', [App\Http\Controllers\EmpDetailsController::class, 'projectlist']);
Route::get('/projectdata', [App\Http\Controllers\EmpDetailsController::class, 'projectdata']);
Route::get('/Project/projectcreation', [App\Http\Controllers\EmpDetailsController::class, 'projectcreation']);
Route::post('/Project/projectstore', [App\Http\Controllers\EmpDetailsController::class, 'projectstore']);
Route::get('/Project/projectedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'projectedit']);
Route::post('/Project/projectupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'projectupdate']);
Route::get('/Project/statuslist', [App\Http\Controllers\EmpDetailsController::class, 'statuslist']);
Route::get('/statusdata', [App\Http\Controllers\EmpDetailsController::class, 'statusdata']);
Route::get('/Project/statuscreation', [App\Http\Controllers\EmpDetailsController::class, 'statuscreation']);
Route::post('/Project/statusstore', [App\Http\Controllers\EmpDetailsController::class, 'statusstore']);
Route::get('/Project/statusedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statusedit']);
Route::post('/Project/statusupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statusupdate']);
Route::get('/Project/authoritylist', [App\Http\Controllers\EmpDetailsController::class, 'authoritylist']);
Route::get('/authoritydata', [App\Http\Controllers\EmpDetailsController::class, 'authoritydata']);
Route::get('/Project/authoritycreation', [App\Http\Controllers\EmpDetailsController::class, 'authoritycreation']);
Route::post('/Project/authoritystore', [App\Http\Controllers\EmpDetailsController::class, 'authoritystore']);
Route::get('/Project/authorityedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'authorityedit']);
Route::post('/Project/authorityupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'authorityupdate']);

Route::get('/Location/locationlist', [App\Http\Controllers\EmpDetailsController::class, 'locationlist']);
Route::get('/locationdata', [App\Http\Controllers\EmpDetailsController::class, 'locationdata']);
Route::get('/Location/locationcreation', [App\Http\Controllers\EmpDetailsController::class, 'locationcreation']);
Route::post('/Location/locationstore', [App\Http\Controllers\EmpDetailsController::class, 'locationstore']);
Route::get('/Location/locationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'locationedit']);
Route::post('/Location/locationupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'locationupdate']);

Route::get('/viewdata', [App\Http\Controllers\EmpDetailsController::class, 'viewdata']);
Route::get('/empview/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empview']);

Route::get('/remuneration/{id}', [App\Http\Controllers\EmpDetailsController::class, 'remuneration']);
Route::get('/remunerationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'remunerationedit']);
Route::get('/salarystructure', [App\Http\Controllers\EmpDetailsController::class, 'salarystructure']);
Route::post('/remunerationstore', [App\Http\Controllers\EmpDetailsController::class, 'remunerationstore']);
Route::post('/remunerationeditstore', [App\Http\Controllers\EmpDetailsController::class, 'remunerationeditstore']);

Route::get('/statutory/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statutory']);
Route::get('/statutoryedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statutoryedit']);
Route::post('/statutorystore', [App\Http\Controllers\EmpDetailsController::class, 'statutorystore']);
Route::post('/statutoryeditstore', [App\Http\Controllers\EmpDetailsController::class, 'statutoryeditstore']);

Route::get('/bank/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bank']);
Route::post('/bankstore', [App\Http\Controllers\EmpDetailsController::class, 'bankstore']);
Route::get('/bankedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bankedit']);
Route::post('/bankeditstore', [App\Http\Controllers\EmpDetailsController::class, 'bankeditstore']);

######## export ########
Route::get('/importExportView', [EmpDetailsController::class, 'importExportView']);
Route::get('export', [EmpDetailsController::class, 'export'])->name('export');
Route::post('import', [EmpDetailsController::class, 'import'])->name('import');
######## export ########



/* Employee Role Route */
Route::get('/attendance', [App\Http\Controllers\EmployeeController::class, 'attendance']);
Route::post('/attendancestore', [App\Http\Controllers\EmployeeController::class, 'attendancestore']);
Route::get('/attendance-view', [App\Http\Controllers\EmployeeController::class, 'attendanceview']);
Route::get('/outtime/{id}', [App\Http\Controllers\EmployeeController::class, 'outtime']);
Route::get('/leaveform', [App\Http\Controllers\EmployeeController::class, 'leaveform']);
Route::post('/leavestore', [App\Http\Controllers\EmployeeController::class, 'leavestore']);
Route::get('/leave-view', [App\Http\Controllers\EmployeeController::class, 'leaveview']);
/*END Employee Role Route */
/* Project Admin  Role Route */
Route::get('/leave-show', [App\Http\Controllers\EmployeeController::class, 'leaveshow']);
Route::post('/leaveapprove', [App\Http\Controllers\EmployeeController::class, 'leaveapprove']);
Route::get('/attendance-show', [App\Http\Controllers\EmployeeController::class, 'attendanceshow']);
Route::get('/employee-index', [App\Http\Controllers\EmployeeController::class, 'empindex']);
Route::get('/projectemp', [App\Http\Controllers\EmployeeController::class, 'projectemp']);
Route::get('/emp-details/{id}', [App\Http\Controllers\EmployeeController::class, 'empdetails']);
Route::get('/project-attexport', [App\Http\Controllers\EmployeeController::class, 'attendanceexport']);
/*END Project Admin Role Route */
/* mail */
Route::get('/mail', [App\Http\Controllers\ScheduleController::class, 'Testmail']);
Route::get('/markattendance', [App\Http\Controllers\ScheduleController::class, 'markattendance']);
Route::get('/updateattendance', [App\Http\Controllers\ScheduleController::class, 'updateattendance']);
/* End Mail */

/* Payroll */
Route::get('/salarymonth', [App\Http\Controllers\EmpSalaryController::class, 'salarymonth']);
Route::post('/monthstore', [App\Http\Controllers\EmpSalaryController::class, 'monthstore']);
Route::get('/salaryupload', [App\Http\Controllers\EmpSalaryController::class, 'salaryupload']);
Route::get('/downloadtemplate', [App\Http\Controllers\EmpSalaryController::class, 'downloadtemplate']);
Route::post('/importtemplate', [App\Http\Controllers\EmpSalaryController::class, 'importtemplate']);
Route::get('/generate', [App\Http\Controllers\EmpSalaryController::class, 'generate']);
Route::post('/salaryprocess', [App\Http\Controllers\EmpSalaryController::class, 'salaryprocess']);
Route::get('/viewgeneratelist', [App\Http\Controllers\EmpSalaryController::class, 'viewgeneratelist']);
Route::get('/salarylist', [App\Http\Controllers\EmpSalaryController::class, 'salarylist']);

/* End Payroll */


/* admin activities */
Route::get('storeuser', [App\Http\Controllers\SiteController::class, 'storeuser']);
Route::get('user', [App\Http\Controllers\SiteController::class, 'user']);
Route::post('passwordreset', [App\Http\Controllers\SiteController::class, 'passwordreset']);
Route::get('passresetdata/{id}', [App\Http\Controllers\SiteController::class, 'passresetdata']);
/* End admin activities */

/*Super User Details     */
Route::get('/superuser_attendance', [App\Http\Controllers\EmployeeController::class, 'superuser_attendance']);
Route::get('/superuser_leavemgmt', [App\Http\Controllers\EmployeeController::class, 'superuser_leavemgmt']);
/*  Super User Details  End */

/* attendance export*/
Route::get('/export_excel', [App\Http\Controllers\EmployeeController::class, 'exportIntoExcel']);
/*End attendance export*/

/* settings */
Route::get('/holidays', [App\Http\Controllers\EmployeeController::class, 'holidays']);
Route::post('/holidays', [App\Http\Controllers\EmployeeController::class, 'holidaystore']);

Route::get('/leavedays', [App\Http\Controllers\EmployeeController::class, 'leavedays']);
Route::get('/leavedata', [App\Http\Controllers\EmployeeController::class, 'leavedata']);
/* settings end*/
/* settings end*/


/*resource route */
Route::resource('/empdetails', 'App\Http\Controllers\EmpDetailsController');
Route::resource('/empsalary', 'App\Http\Controllers\EmpSalaryController');
/*End resource route */
