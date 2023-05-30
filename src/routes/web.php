<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/pmis');
    }
    return view('welcome');
})->name('login');



Route::get('/home', function (Redirect $redirect) {
    return redirect('/pmis');
});

Route::get('/pmis/acr/report', function (Redirect $redirect) {
   return view('pmis.acr.report');
});

Route::get('/forgot-password', function () {
    return view('forgotPassword');
});



/**
 * Authorization for the user
 */
Route::post('/authorization/login', 'Auth\LoginController@authorization')->name('authorization.login');
Route::post('/forget-password', 'Auth\LoginController@forget_password')->name('forget-password');


Route::group(['middleware' => ['auth']], function () {

    /** Dashboard for user */
    Route::get('/dashboard', 'Main_Dashborad\IndexController@index')->name('main_dashboard_test');
    Route::get('/my-account', 'Main_Dashborad\IndexController@my_account')->name('my_account');
    Route::get('/access-modules', 'Api\V2\CommonController@accessModules')->name('access_modules_test');
    Route::get('/cmdb', 'Main_Dashborad\IndexController@chairmanDashboard')->name('chairman_dashboard');

    //Chairman dashboard
    Route::get('/cdb', 'Main_Dashborad\IndexController@dashbaord')->name('c_dashboard');
    Route::get('/cdb/cases', 'Main_Dashborad\IndexController@cases')->name('c_dashboard_case');
    Route::get('/cdb/cases/details/{status}', 'Main_Dashborad\IndexController@caseDetails')->name('c_dashboard_case_details');
    Route::get('/cdb/audits', 'Main_Dashborad\IndexController@audits')->name('c_dashboard_audit');
    Route::get('/cdb/audit/details/{status}/{year}', 'Main_Dashborad\IndexController@audit_details')->name('c_dashboard_audit_details');
    Route::get('/cdb/salaries', 'Main_Dashborad\IndexController@salaries')->name('c_dashboard_salary');
    Route::get('/cdb/house-allotment', 'Main_Dashborad\IndexController@houseAllotment')->name('c_dashboard_house_allotment');
    Route::get('/cdb/recruitment', 'Main_Dashborad\IndexController@recruitment')->name('c_dashboard_recruitment');
    Route::get('/cdb/civil-engineering', 'Main_Dashborad\IndexController@civilEngineering')->name('c_dashboard_civil_engineering');
    Route::get('/cdb/trainings', 'Main_Dashborad\IndexController@trainings')->name('c_dashboard_training');
    Route::get('/cdb/authorized-positions', 'Main_Dashborad\IndexController@authorizedPosition')->name('c_dashboard_authorized-position');
    Route::get('/cdb/assets', 'Main_Dashborad\IndexController@assets')->name('c_dashboard_assets');
    Route::get('/cdb/gender-wise-officer-staff', 'Main_Dashborad\IndexController@genderWiseStafOfficer')->name('c_dashboard_gender_wise_officer_staff');
    Route::get('/cdb/employee-details', 'Main_Dashborad\IndexController@employee_details_data')->name('c_dashboard_employee_details');
    Route::get('/cdb/department-wise-employee-count/{data_for}/{emp_type}', 'Main_Dashborad\IndexController@department_wise_employee_count')->name('c_dashboard_department_wise_employee_count');
    Route::get('/cdb/employee-details-list/{data_for}/{emp_type}/{department_id}', 'Main_Dashborad\IndexController@employee_details_list')->name('c_dashboard_employee_details_list');
    Route::get('/cdb/hydrography', 'Main_Dashborad\IndexController@hydrographyData')->name('c_dashboard_hydrography');
    Route::get('/cdb/appointment', 'Main_Dashborad\IndexController@appointment_statistics_data')->name('c_dashboard_appointment');
    Route::get('/cdb/board_decision', 'Main_Dashborad\IndexController@board_meeting_data')->name('c_dashboard_board_decision');
    Route::get('/cdb/budget-position', 'Main_Dashborad\IndexController@budgetPosition')->name('c_dashboard_budget-position');
    Route::get('/cdb/salary-graph', 'Main_Dashborad\IndexController@salaryGraph')->name('c_dashboard_salary-graph');
    Route::get('/cdb/marine-daily/pilotage-service', 'Main_Dashborad\IndexController@marineDailyPilotageService')->name('c_dashboard_marine-daily-pilotage-service');
    Route::get('/cdb/marine-monthly/pilotage-service/line-chart', 'Main_Dashborad\IndexController@marineMonthlyPilotageServiceLineChart')->name('c_dashboard_marine-monthly-pilotage-service-line-chart');
    Route::get('/cdb/marine-monthly/pilotage-service', 'Main_Dashborad\IndexController@marineMonthlyPilotageService')->name('c_dashboard_marine-monthly-pilotage-service');
    Route::get('/cdb/marine-daily/mooring-service', 'Main_Dashborad\IndexController@marineDailyMooringService')->name('c_dashboard_marine-daily-mooring-service');
    Route::get('/cdb/marine-monthly/mooring-service', 'Main_Dashborad\IndexController@marineMonthlyMooringService')->name('c_dashboard_marine-monthly-mooring-service');
    Route::get('/cdb/marine-daily/dues-collection', 'Main_Dashborad\IndexController@marineDailyDuesCollection')->name('c_dashboard_marine-daily-dues-collection');
    Route::get('/cdb/marine-monthly/dues-collection', 'Main_Dashborad\IndexController@marineMonthlyDuesCollection')->name('c_dashboard_marine-monthly-dues-collection');
    Route::get('/cdb/marine-daily/fresh-water', 'Main_Dashborad\IndexController@marineDailyFreshWaterSupply')->name('c_dashboard_marine-daily-fresh-water');
    Route::get('/cdb/marian-daily-details/{type}', 'Main_Dashborad\IndexController@marineDailyDetails')->name('c_dashboard_marian-daily-details');
    Route::get('/cdb/marine-monthly/fresh-water', 'Main_Dashborad\IndexController@marineMonthlyFreshWaterSupply')->name('c_dashboard_marine-monthly-fresh-water');
    Route::get('/cdb/house-allot-pop-data/{status}', 'Main_Dashborad\IndexController@getHouseAllotPopData')->name('c_house_allot_pop_data');

    Route::get('/cdb/equipments', 'Main_Dashborad\IndexController@equipments')->name('c_dashboard_equipments');
    Route::get('/cdb/vehicles', 'Main_Dashborad\IndexController@vehicles')->name('c_dashboard_vehicles');
    Route::get('/cdb/vehicles/details/{status}', 'Main_Dashborad\IndexController@vehicleDetails')->name('c_dashboard_vehicle_details');
    Route::get('/cdb/vehicle-particulars', 'Main_Dashborad\IndexController@vehicle_particulars')->name('c_dashboard_vehicle_particulars');
    Route::get('/cdb/container-lying-position', 'Main_Dashborad\IndexController@container_lying_position')->name('c_dashboard_container_lying_position');
    Route::get('/cdb/incidents', 'Main_Dashborad\IndexController@incidents')->name('c_dashboard_incidents');
    Route::get('/cdb/backup-data', 'Main_Dashborad\IndexController@backupData')->name('c_dashboard_bdata');
    Route::get('/cdb/vesselbills', 'Main_Dashborad\IndexController@vesselbills')->name('c_dashboard_v_bill');
    Route::get('/cdb/vessel-handled', 'Main_Dashborad\IndexController@vesselHandled')->name('c_dashboard_vessel_handled');
    Route::get('/cdb/accounts', 'Main_Dashborad\IndexController@accountSummery')->name('c_dashboard_account_summery');
    Route::get('/cdb/one-stop', 'Main_Dashborad\IndexController@onceStopSummery')->name('c_dashboard_one_stop_summery');
    Route::get('/cdb/vessel-history', 'Main_Dashborad\IndexController@getVesselHistory')->name('c_dashboard_one_stop_vessel-history');
    Route::get('/cdb/vacant-berth', 'Main_Dashborad\IndexController@getVacantBerth')->name('c_dashboard_getVacantBerth');
    Route::get('/cdb/not-working-vessel-outer', 'Main_Dashborad\IndexController@getNotWorkingVesselOuter')->name('c_dashboard_getNotWorkingVesselOuter');
    Route::get('/cdb/ar_ap', 'Main_Dashborad\IndexController@payableAndReceivableSummery')->name('c_dashboard_ar_ap');

    Route::get('/cdb/container_details/{type}', 'Main_Dashborad\IndexController@containerDetails')->name('c_dashboard_container_details');
    Route::get('/cdb/handaling_details/{date}/{type}', 'Main_Dashborad\IndexController@containerhandalingDetails')->name('c_dashboard_container_details');

    Route::get('/cdb/daily-cont-hand', 'Main_Dashborad\IndexController@dailyContHand')->name('daily_cont_hand');
    Route::get('/cdb/daily-total-incoming', 'Main_Dashborad\IndexController@dailyTotalIncoming')->name('daily_total_incoming');
    Route::get('/cdb/daily-total-desp', 'Main_Dashborad\IndexController@dailyTotalDesp')->name('daily_total_desp');
    Route::get('/cdb/vessel-movement', 'Main_Dashborad\IndexController@vesselMovement')->name('vessel_movement');
    Route::get('/cdb/lying-details-pop-data/{date}', 'Main_Dashborad\IndexController@lyingDetailsPoup')->name('lying-details-pop-data');
    Route::get('/cdb/training-details-pop-data/{type}', 'Main_Dashborad\IndexController@trainingDetailsPopup')->name('training-details-pop-data');


    Route::get('/user/change-password', function () {
        return view('resetPassword');
    });
    Route::post('/user/change-password', 'Auth\ResetPasswordController@resetPassword')->name('user.reset-password');

    //Rending report must be authorize
    Route::post('/report/render/{title}', 'Report\OraclePublisherController@render')->name('report');
    Route::get('/report/render/{title?}', 'Report\OraclePublisherController@render')->name('report-get');
    Route::get('/report/pension-settlement-report', 'Api\V1\Report\PensionParameterController@pensionSettlement')->name('pension-settlement-report');
    //Mail
    Route::get('/mail/plain-mail/{to?}', 'SendMail\SendMailController@sendPlainMail')->name('attachmentMail');

    Route::get('/pmis', 'Pmis\IndexController@index')->name('Employee Information');
    Route::get('/pension', 'Pension\IndexController@index')->name('pension');
    Route::get('/pmis/operations ', 'Pmis\IndexController@operations')->name('Operations');
    Route::get('/pmis/acr', 'Pmis\IndexController@acr')->name('acr');
    Route::get('/pmis/provident-fund', 'Pmis\IndexController@provident_fund')->name('provident_fund');
    Route::get('/recruitment', 'Recruitment\IndexController@index')->name('recruitment');
    Route::get('/marine', 'Marine\IndexController@index')->name('marine');
    Route::get('/traffic', 'Traffic\IndexController@index')->name('traffic');
    Route::get('/hydrography', 'Hydrography\IndexController@index')->name('hydrography');
    Route::get('/leave', 'Leave\IndexController@index')->name('Leave');
    Route::get('/attendance', 'Attendance\IndexController@index')->name('Attendance');
    Route::post('/attendance/upload', 'Attendance\IndexController@upload')->name('Attendance-upload');
    Route::get('/admin', 'Admin\IndexController@index')->name('Administration');
    //Route::get('/dashboard', 'Pmis\IndexController@index')->name('main_dashboard');

    Route::get('/application-service', 'ApplicationService\IndexController@index')->name('application-service');
    Route::get('/accounts', 'Accounts\IndexController@index')->name('accounts');
    Route::get('/audit', 'Audit\IndexController@index')->name('audit');
    Route::get('/budget', 'Budget\IndexController@index')->name('budget');
    Route::get('/purchase', 'Purchase\IndexController@index')->name('purchase');
    Route::get('/inventory', 'Inventory\IndexController@index')->name('inventory');
    Route::get('/fixed_asset', 'Fixed_Asset\IndexController@index')->name('fixed_asset');
    Route::get('/online_vessel_billing', 'Online_Vessel_Billing\IndexController@index')->name('online_vessel_billing');
    Route::get('/approval-service', 'Approval_service\IndexController@index')->name('approval-service');
    Route::post('/authorization/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/authorization/change-password', 'Pmis\IndexController@change_password')->name('change-password');
    Route::get('/overtime', 'Overtime\IndexController@index')->name('Over Time');
    Route::get('/payroll', 'Payroll\IndexController@index')->name('Payroll');
    Route::get('/loan', 'Loan\IndexController@index')->name('loan');
    // Attachment downloading api.
    Route::get('/pmis/basic-info/download-authentication-document/{id}', 'Attachment\DownloaderController@basicInfoAuthDoc')->name('basic-info-download-authentication-document');
    Route::get('/pmis/nominee/download-authentication-document/{id}', 'Attachment\DownloaderController@nomineeAuthDoc')->name('nominee-download-authentication-document');
    Route::get('/pmis/training/download-authentication-document/{id}', 'Attachment\DownloaderController@trainingAuthDoc')->name('training-download-authentication-document');
    Route::get('/pmis/prof-cert/download-authentication-document/{id}', 'Attachment\DownloaderController@profCertAuthDoc')->name('prof-cert-download-authentication-document');
    Route::get('/overtime/report', 'Overtime\IndexController@report')->name('overtime-report');
});
