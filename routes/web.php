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
Route::get('/checklist/{id}', [App\Http\Controllers\EmpDetailsController::class, 'checklist']);
Route::get('/checklist_edit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'checklist_edit']);
Route::post('/chklststore', [App\Http\Controllers\EmpDetailsController::class, 'chklststore']);


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

Route::get('/education/{id}', [App\Http\Controllers\EmpDetailsController::class, 'education']);
Route::post('/educationstore', [App\Http\Controllers\EmpDetailsController::class, 'educationstore']);
Route::get('/educationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'educationedit']);
Route::post('/educationeditstore', [App\Http\Controllers\EmpDetailsController::class, 'educationeditstore']);

Route::get('/certificate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'certificate']);
Route::post('/certificatestore', [App\Http\Controllers\EmpDetailsController::class, 'certificatestore']);
Route::get('/certificateedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'certificateedit']);
Route::post('/certificateeditstore', [App\Http\Controllers\EmpDetailsController::class, 'certificateeditstore']);

Route::get('/offerletter/{id}', [App\Http\Controllers\EmpDetailsController::class, 'offerletter']);

######## Qualification #######

Route::get('/qualificationlist', [App\Http\Controllers\EmpDetailsController::class, 'qualificationlist']);
Route::get('/qualificationdata', [App\Http\Controllers\EmpDetailsController::class, 'qualificationdata']);
Route::get('/qualificationcreation', [App\Http\Controllers\EmpDetailsController::class, 'qualificationcreation']);
Route::post('/qualificationstore', [App\Http\Controllers\EmpDetailsController::class, 'qualificationstore']);

Route::get('/qualificationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'qualificationedit']);
Route::post('/qualificationupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'qualificationupdate']);

######## End Qualification ####

######## File uploaded ############

Route::get('/empfile/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empfile']);
Route::post('/empfilestore', [App\Http\Controllers\EmpDetailsController::class, 'empfilestore']);

######## End File Uploaded #########

######## export & Export ########
Route::get('/importExportView', [EmpDetailsController::class, 'importExportView']);
Route::get('export', [EmpDetailsController::class, 'export'])->name('export');
Route::post('import', [EmpDetailsController::class, 'import'])->name('import');
Route::get('ImportEmployee', [EmpDetailsController::class, 'ImportEmployee']);
Route::post('ImportEmployee', [EmpDetailsController::class, 'ImportEmployee']);
######## export ########



/* Employee Role Route */
Route::get('/attendance', [App\Http\Controllers\EmployeeController::class, 'attendance']);
Route::post('/attendancestore', [App\Http\Controllers\EmployeeController::class, 'attendancestore']);
Route::get('/attendance-view', [App\Http\Controllers\EmployeeController::class, 'attendanceview']);
Route::get('/outtime/{id}', [App\Http\Controllers\EmployeeController::class, 'outtime']);
Route::get('/leaveform', [App\Http\Controllers\EmployeeController::class, 'leaveform']);
Route::post('/leavestore', [App\Http\Controllers\EmployeeController::class, 'leavestore']);
Route::get('/leave-view', [App\Http\Controllers\EmployeeController::class, 'leaveview']);
Route::get('/credential/{id}', [App\Http\Controllers\EmployeeController::class, 'credential']);
Route::post('/storeuser', [App\Http\Controllers\EmployeeController::class, 'storeuser']);
Route::get('/leavebalance', [App\Http\Controllers\EmpDetailsController::class, 'leavebalance']);
Route::get('/lbdata', [App\Http\Controllers\EmpDetailsController::class, 'lbdata']);
Route::get('/lbedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'lbedit']);
Route::post('/lbedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'lbedit']);
Route::get('/leavereset', [App\Http\Controllers\EmpDetailsController::class, 'leavereset']);
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
Route::post('/payslipmail', [App\Http\Controllers\ScheduleController::class, 'payslipmail']);
Route::get('/punchmiss', [App\Http\Controllers\ScheduleController::class, 'punchmiss']);
//Route::get('/processQueue', [App\Http\Controllers\ScheduleController::class, 'processQueue']);
Route::get('/markattendance', [App\Http\Controllers\ScheduleController::class, 'markattendance']);
Route::get('/updateattendance', [App\Http\Controllers\ScheduleController::class, 'updateattendance']);
Route::get('/autoUpdate', [App\Http\Controllers\ScheduleController::class, 'autoUpdate']);

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
Route::get('/payslippdf/{id}', [App\Http\Controllers\ScheduleController::class, 'payslippdf']);
Route::get('/mailindex', [App\Http\Controllers\EmpSalaryController::class, 'mailindex']);
Route::get('/viewmaillist', [App\Http\Controllers\EmpSalaryController::class, 'viewmaillist']);
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
Route::get('/att_report', [App\Http\Controllers\EmployeeController::class, 'att_report']);
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


/*resource route */
Route::resource('/empdetails', 'App\Http\Controllers\EmpDetailsController');
Route::resource('/empsalary', 'App\Http\Controllers\EmpSalaryController');
/*End resource route */
