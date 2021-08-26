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
Route::get('/Project/projectdelete/{id}', [App\Http\Controllers\EmpDetailsController::class, 'projectdelete']);
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

Route::get('/offerletter/{id}/{empcode}', [App\Http\Controllers\EmpDetailsController::class, 'offerletter']);

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
Route::get('/file_download/{id}/{code}', [App\Http\Controllers\EmpDetailsController::class, 'file_download']);
Route::get('/file_delete/{id}/{code}', [App\Http\Controllers\EmpDetailsController::class, 'file_delete']);

######## End File Uploaded #########

######## export & import ########
Route::get('/importExportView', [EmpDetailsController::class, 'importExportView']);
Route::get('export', [EmpDetailsController::class, 'export'])->name('export');
Route::post('import', [EmpDetailsController::class, 'import'])->name('import');
Route::get('ImportEmployee', [EmpDetailsController::class, 'ImportEmployee']);
Route::post('ImportEmployee', [EmpDetailsController::class, 'ImportEmployee']);
######## export ########

/*leave balance */
Route::get('/leavebalance', [App\Http\Controllers\EmpDetailsController::class, 'leavebalance']);
Route::get('/lbdata', [App\Http\Controllers\EmpDetailsController::class, 'lbdata']);
Route::get('/lbedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'lbedit']);
Route::post('/lbedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'lbedit']);
Route::get('/leavereset', [App\Http\Controllers\EmpDetailsController::class, 'leavereset']);
/*end Leave Balknce */

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
/* End Mail */
Route::get('/processQueue', [App\Http\Controllers\ScheduleController::class, 'processQueue']);
Route::get('/markattendance', [App\Http\Controllers\ScheduleController::class, 'markattendance']);
Route::get('/updateattendance', [App\Http\Controllers\ScheduleController::class, 'updateattendance']);
Route::get('/autoUpdate', [App\Http\Controllers\ScheduleController::class, 'autoUpdate']);


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

Route::get('/todayattendance', [App\Http\Controllers\EmployeeController::class, 'todayattendance']);
Route::post('/todayattpost', [App\Http\Controllers\EmployeeController::class, 'todayattpost']);
Route::get('/todayattpost', [App\Http\Controllers\EmployeeController::class, 'todayattposts']);
Route::get('/superuser_attendance', [App\Http\Controllers\EmployeeController::class, 'superuser_attendance']);
Route::get('/superuser_leavemgmt', [App\Http\Controllers\EmployeeController::class, 'superuser_leavemgmt']);
Route::get('/musterroll', [App\Http\Controllers\EmployeeController::class, 'musterroll']);
Route::post('/musterroll', [App\Http\Controllers\EmployeeController::class, 'musterrollpost']);

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

/* Personal Details */
Route::get('/personal/{id}', [App\Http\Controllers\EmpDetailsController::class, 'personal']);
Route::post('/personalstore', [App\Http\Controllers\EmpDetailsController::class, 'personalstore']);
Route::get('/personaldetails_edit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'personaldetails_edit']);
Route::post('/personaldetails_editstore/{id}', [App\Http\Controllers\EmpDetailsController::class, 'personaldetails_editstore']);
/* Personal Details End*/

/* bgv Details */
Route::get('/bgv/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bgv']);
Route::post('/bgvstore', [App\Http\Controllers\EmpDetailsController::class, 'bgvstore']);
Route::get('/bgv_edit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bgvedit']);
Route::post('/bgv_editpost/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bgv_editpost']);
/* bgv Details End*/

/* exit Details */
Route::get('/exit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'exit']);
Route::post('/exitstore', [App\Http\Controllers\EmpDetailsController::class, 'exitstore']);
Route::get('/exit_edit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'exit_edit']);
Route::post('/exit_editpost/{id}', [App\Http\Controllers\EmpDetailsController::class, 'exit_editpost']);
/* exit Details End*/

/* */
Route::get('/empfileedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empfileedit']);
Route::post('/empfileeditstore', [App\Http\Controllers\EmpDetailsController::class, 'empfileeditstore']);
/* */


/* pf start here */
Route::get('/pf', [App\Http\Controllers\EmpDetailsController::class, 'pf']);
Route::post('/pfstore', [App\Http\Controllers\EmpDetailsController::class, 'pfstore']);
Route::get('/pfedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'pfedit']);
Route::post('/pfeditstore/{id}', [App\Http\Controllers\EmpDetailsController::class, 'pfeditstore']);
/* pf end here */

/* esi start here */
Route::get('/esi', [App\Http\Controllers\EmpDetailsController::class, 'esi']);
Route::post('/esistore', [App\Http\Controllers\EmpDetailsController::class, 'esistore']);
Route::get('/esiedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'esiedit']);
Route::post('/esieditstore/{id}', [App\Http\Controllers\EmpDetailsController::class, 'esieditstore']);
/* esi end here */

Route::get('/renewal/{id}', [App\Http\Controllers\EmpDetailsController::class, 'renewalget']);
Route::post('/renewal/{id}', [App\Http\Controllers\EmpDetailsController::class, 'renewal']);
/*    snappy     */
Route::get('graphs', 'PdfController@graphs');

Route::get('graphs-pdf', 'PdfController@graphPdf');
/*    snappy end    */

/* grievance list */
Route::get('/grievancelist', [App\Http\Controllers\EmpDetailsController::class, 'grievancelist']);
Route::get('/viewdatalist', [App\Http\Controllers\EmpDetailsController::class, 'viewdatalist']);
Route::get('/grievance', [App\Http\Controllers\EmpDetailsController::class, 'grievancecreate']);

Route::get('/grievance/{id}', [App\Http\Controllers\EmpDetailsController::class, 'grievance']);
Route::post('/grievancestore', [App\Http\Controllers\EmpDetailsController::class, 'grievancestore']);
Route::get('/grievance_edit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'grievance_edit']);
Route::post('/grievance_editpost/{id}', [App\Http\Controllers\EmpDetailsController::class, 'grievance_editpost']);
/* grievance Details End*/


/* employee grievance list start*/
Route::get('/empgrievancelist', [App\Http\Controllers\EmpDetailsController::class, 'empgrievancelist']);
Route::get('/empviewdatalist', [App\Http\Controllers\EmpDetailsController::class, 'empviewdatalist']);
Route::get('/empgrievance', [App\Http\Controllers\EmpDetailsController::class, 'empgrievance']);
Route::post('/empgrievancestore', [App\Http\Controllers\EmpDetailsController::class, 'empgrievancestore']);
Route::get('/empgrievanceshow/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empgrievanceshow']);
Route::get('/empgrievance_edit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empgrievance_edit']);
Route::post('/empgrievancepost/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empgrievancepost']);

/* employee grievance list end*/

/*  exit form view */
Route::get('/fandf/{id}', [App\Http\Controllers\EmpDetailsController::class, 'fandf']);

/* exit form end */ 
Route::get('/gather_data', [App\Http\Controllers\EmpDetailsController::class, 'gather_data']);

/*  department */
Route::get('/Department/departmentlist', [App\Http\Controllers\EmpDetailsController::class, 'departments']);
Route::get('/departmentdata', [App\Http\Controllers\EmpDetailsController::class, 'departmentdata']);
Route::get('/Department/departmentcreation', [App\Http\Controllers\EmpDetailsController::class, 'departmentcreation']);
Route::post('/Department/departmentstore', [App\Http\Controllers\EmpDetailsController::class, 'departmentstore']);
Route::get('/Department/departmentedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'departmentedit']);
Route::post('/Department/departmentupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'departmentupdate']);
/*  department end */
/*   designation    */
Route::get('/Designations/designationlist', [App\Http\Controllers\EmpDetailsController::class, 'designations']);
Route::get('/designationdata', [App\Http\Controllers\EmpDetailsController::class, 'designationdata']);
Route::get('/Designations/designationcreation', [App\Http\Controllers\EmpDetailsController::class, 'designationcreation']);
Route::post('/Designations/designationstore', [App\Http\Controllers\EmpDetailsController::class, 'designationstore']);
Route::get('/Designations/designationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'designationedit']);
Route::post('/Designations/designationupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'designationupdate']);
/* designation ens*/
/*    doc addition   */
Route::get('/Documents/doc_addition', [App\Http\Controllers\EmpDetailsController::class, 'doc_addition']);
Route::get('/Documents/documentdelete/{id}', [App\Http\Controllers\EmpDetailsController::class, 'documentdelete']);
Route::get('/Documents/documentcreation', [App\Http\Controllers\EmpDetailsController::class, 'documentcreation']);
Route::post('/Documents/documentstore', [App\Http\Controllers\EmpDetailsController::class, 'documentstore']);
Route::get('/Documents/documentedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'documentedit']);
Route::post('/Documents/documentupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'documentupdate']);
/*   doc addition  end  */

/* document view */
Route::get('/documentview/{id}', [App\Http\Controllers\EmpDetailsController::class, 'documentview']);
/* document view end */

/*   offer letter email sent  */ 
// Route::get('/sendmail', [App\Http\Controllers\EmpDetailsController::class, 'sendmail']);
Route::get('/sendmail/{id}/{email}', [App\Http\Controllers\ScheduleController::class, 'sendmail']);
/*   offer letter email sent end */ 

/* checklist export*/
Route::get('/checklistexport', [App\Http\Controllers\EmpDetailsController::class, 'checklistexport']);
Route::get('checklistexports', [EmpDetailsController::class, 'checklistexports'])->name('checklistexports');
Route::get('chklist', [App\Http\Controllers\EmpDetailsController::class, 'chklist']);
/* checklist export end*/
