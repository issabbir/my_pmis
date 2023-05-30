<?php
use \Illuminate\Support\Facades\DB;
// PMIS module
//Route::group(['prefix' => 'pmis', 'name' => 'pmis.', 'middleware' => ['auth']], function () {
Route::group(['prefix' => 'pmis', 'name' => 'pmis.', 'middleware' => ['auth']], function () {


    //Chairman Dashboard
    Route::group(['prefix' => 'cmdb'], function () {
        Route::get('employees', 'Api\V2\EmployeeController@dashboardData');
        Route::get('salaries', 'Api\V2\SalaryController@employeeSalary');
        Route::get('case', 'Api\V2\CaseController@cases');
    });

    Route::group(['prefix' => 'api', 'name' => 'api.'], function () {
       // Route::get('profile', 'Api\V2\ProfileController@profile');

        Route::get('access-modules', 'Api\V2\CommonController@accessModules');
        Route::get('monthly-salaries', 'Api\V2\CommonController@monthSalary');
        Route::get('department-wise-employee', 'Api\V2\CommonController@departmentWiseEmployee');

        Route::get('nominee', 'Api\V2\NomineeController@nominee');

        Route::get('leave', 'Api\V2\LeaveController@leave');

        Route::get('fiscal-year', 'Api\V2\FiscalYearController@fiscal_year');
        Route::post('fiscal-year-wise-month', 'Api\V2\FiscalYearController@fiscal_year_wise_month');

        Route::post('attendance', 'Api\V2\AttendanceController@attendance');

        Route::get('loan-pf-loan-type', 'Api\V2\LoanPfController@loan_type');
        Route::get('loans', 'Api\V2\LoanPfController@loans');


        Route::post('employee-loans', 'Api\V2\LoanController@employee_loan');

        Route::post('payslip/details', 'Api\V2\FileDownloadController@payslip_details');
        Route::post('bonus-payslip/details', 'Api\V2\FileDownloadController@bonus_payslip_details');
        Route::get('bonus-type', 'Api\V2\FileDownloadController@get_bonus_type');

        Route::get('get-bill-month', 'Api\V2\FileDownloadController@bill_month');
        Route::post('get-bill-code', 'Api\V2\FileDownloadController@bill_code');


        Route::post('gpf-summary', 'Api\V2\GpfController@gpf_summary');
        Route::post('employee-provident-fund', 'Api\V2\ProvidentFundController@employee_provident_fund');


        Route::get('month/list', 'Api\V2\MonthController@list');
        Route::get('getMonthsById', 'Api\V2\MonthController@getMonthsById');
        Route::get('year/list', 'Api\V2\YearController@list');
    });



    // ChargeEntryController
    Route::group(['name' => 'charge-entry.'], function() {
        // v1/pmis/charge-entry
        Route::get('/charge-entry', 'Api\V1\Pmis\ChargeEntryController@index')->name('index');
        Route::get('/charge-entry/{id}', 'Api\V1\Pmis\ChargeEntryController@view')->name('view');
        Route::post('/charge-entry', 'Api\V1\Pmis\ChargeEntryController@store')->name('store');
        Route::get('/charge-entry/emp-info/{id}', 'Api\V1\Pmis\ChargeEntryController@getEmpInfo')->name('getEmpInfo');
        Route::get('/charge-entry-specific/{id}', 'Api\V1\Pmis\ChargeEntryController@specific')->name('specific');
        Route::get('/charge-entry/prelovertime/ot-roster-group/detailsoad-data', 'Api\V1\Pmis\ChargeEntryController@index')->name('getPreloadInfo');
        Route::post('/charge-entry/search_result', 'Api\V1\Pmis\ChargeEntryController@search_result')->name('search_result');
        Route::delete('/charge-entry/{id}', 'Api\V1\Pmis\ChargeEntryController@remove')->name('remove');
        Route::get('/unapproved-in-charge', 'Api\V1\Pmis\ChargeEntryController@unapprovedInCharge')->name('unapproved-in-charge');
        Route::put('/charge-entry-approval', 'Api\V1\Pmis\ChargeEntryController@inChargeApproval')->name('inChargeApproval');
    });
    // Employee
    Route::group(['prefix' => 'employee', 'name' => 'employee'], function() {

        Route::get('/generate-emp-code', function() {
           $employee = DB::selectOne('select emp_code from employee_temp order by emp_code desc');
           //dd($employee);
           if ($employee)
               return $employee->emp_code + 1;
        });

         Route::get('/report-parameters', 'Api\V1\Report\EmployeeParameterController@index')->name('index');
        // AcademicController
        Route::group(['name' => 'academic.'], function() {
            // v1/pmis/employee/academics
            Route::get('/academics', 'Api\V1\Pmis\Employee\AcademicController@index')->name('index');
            Route::get('/academics/specific/{id}', 'Api\V1\Pmis\Employee\AcademicController@specific')->name('index-specific');
            Route::get('/academics/{id}', 'Api\V1\Pmis\Employee\AcademicController@view')->name('view');
            Route::get('/exam-result-by-type/{id}', 'Api\V1\Pmis\Employee\AcademicController@getResultByType')->name('exam-result-by-type');
            Route::post('/academics', 'Api\V1\Pmis\Employee\AcademicController@store')->name('store');
            Route::put('/academics/{id}', 'Api\V1\Pmis\Employee\AcademicController@update')->name('update');
            Route::delete('/academics/{id}', 'Api\V1\Pmis\Employee\AcademicController@remove')->name('remove');
        });
        // OtherController
        Route::group(['name' => 'other.'], function() {
            Route::get('/others/{id}', 'Api\V1\Pmis\Employee\OthersController@index')->name('index');
            Route::get('/others-list/{id}', 'Api\V1\Pmis\Employee\OthersController@list')->name('list');
            Route::get('/others/club-records/{id}', 'Api\V1\Pmis\Employee\OthersController@clubspecific')->name('clubspecific');
            Route::post('/others', 'Api\V1\Pmis\Employee\OthersController@store')->name('store');
            Route::get('/salary-heads/visible_scope', 'Api\V1\Pmis\Employee\OthersController@salaryHeads')->name('salary-heads');
        });

        // AccommodationController
        Route::group(['name' => 'accommodation.'], function() {
            // v1/pmis/employee/accommodations
            Route::get('/accommodations', 'Api\V1\Pmis\Employee\AccommodationController@index')->name('index');
            Route::get('/accommodations/specific/{id}', 'Api\V1\Pmis\Employee\AccommodationController@specific')->name('index-specific');
            Route::get('/accommodations/{id}', 'Api\V1\Pmis\Employee\AccommodationController@view')->name('view');
            Route::post('/accommodations', 'Api\V1\Pmis\Employee\AccommodationController@store')->name('store');
            Route::put('/accommodations/{id}', 'Api\V1\Pmis\Employee\AccommodationController@update')->name('update');
            Route::delete('/accommodations/{id}', 'Api\V1\Pmis\Employee\AccommodationController@remove')->name('remove');
        });

        // AddressController
        Route::group(['name' => 'address.'], function() {
            // v1/pmis/employee/addresses
            Route::get('/addresses', 'Api\V1\Pmis\Employee\AddressController@index')->name('index');
            Route::get('/addresses/specific/{id}', 'Api\V1\Pmis\Employee\AddressController@specific')->name('index-specific');
            Route::get('/accommodation', 'Api\V1\Pmis\Employee\AddressController@accommodation')->name('accommodation');
            Route::get('/addresses/{id}', 'Api\V1\Pmis\Employee\AddressController@view')->name('view');
            Route::post('/addresses', 'Api\V1\Pmis\Employee\AddressController@store')->name('store');
            Route::put('/addresses/{id}', 'Api\V1\Pmis\Employee\AddressController@update')->name('update');
            Route::delete('/addresses/{id}', 'Api\V1\Pmis\Employee\AddressController@remove')->name('remove');
        });
        // BasicInfoController
        Route::group(['name' => 'basic-info.'], function() {
            Route::get('/basic-infos', 'Api\V1\Pmis\Employee\BasicInfoController@index')->name('index');
            Route::get('/basic-infos/by-designation/{did}', 'Api\V1\Pmis\Employee\BasicInfoController@infoByDesignation')->name('index');
            Route::get('/get-notification/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@getNotification')->name('getNotification');
            Route::post('/seen-notification', 'Api\V1\Pmis\Employee\BasicInfoController@seen_notification')->name('seen_notification');
            Route::get('/basic-infos/unique-employee-code', 'Api\V1\Pmis\Employee\BasicInfoController@uniqueEmployeeCode')->name('unique-employee-code');
            Route::get('/basic-infos/check-valid-nid', 'Api\V1\Pmis\Employee\BasicInfoController@checkIsValidNID')->name('checkIsValidNID');
            Route::get('/basic-infos/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@view')->name('view');
            Route::get('/basic-infos/charge-entry/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@chargeEntryDetails')->name('view');
            Route::get('/employeeProfile', 'Api\V1\Pmis\Employee\BasicInfoController@employeeProfile')->name('employeeProfile');
            Route::get('/employee-profile-by-id/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@employeeProfileById')->name('employee-profile-by-id');
            Route::get('/basic-infos/employee-information/{name}', 'Api\V1\Pmis\Employee\BasicInfoController@employeeInformation')->name('employee-information');
            Route::get('/basic-infos/controlling-officer/{name}', 'Api\V1\Pmis\Employee\BasicInfoController@controllingOfficer')->name('controlling-officer');
            Route::get('/basic-infos/all-controlling-officer/{name}', 'Api\V1\Pmis\Employee\BasicInfoController@allcontrollingOfficer')->name('all-controlling-Officer');
            Route::get('/basic-infos/pay-grades/{empTypeId}', 'Api\V1\Pmis\Employee\BasicInfoController@payGrades')->name('pay-grades');
            Route::get('/basic-infos/gpf-subscription/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@gpfSubscription')->name('gpf-subscription');
            Route::post('/basic-infos', 'Api\V1\Pmis\Employee\BasicInfoController@store')->name('store');
            Route::get('/basic-infos/by-designation/{depId}/{desId}/{empType}/{deputationYn}', 'Api\V1\Pmis\Employee\BasicInfoController@getParams')->name('getParams');
            Route::post('/profile-update', 'Api\V1\Pmis\Employee\BasicInfoController@update')->name('update-profile');
            Route::post('/basic-infos/update-gpf-subscription/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@updateGpfSubscription')->name('update-gpf-subscription');
            //Route::put('/basic-infos/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@update')->name('update');
            Route::delete('/basic-infos/{id}', 'Api\V1\Pmis\Employee\BasicInfoController@remove')->name('remove');
         });

        // ChildrenController
        Route::group(['name' => 'family.'], function() {
            // v1/pmis/employee/children
            Route::get('/families', 'Api\V1\Pmis\Employee\FamilyController@index')->name('index');
            Route::get('/families/unique-family-auth-id', 'Api\V1\Pmis\Employee\FamilyController@uniqueFamilyAuthId')->name('unique-family-auth-id');
            Route::get('/families/my-family-unique-family-auth-id', 'Api\V1\Pmis\Employee\FamilyController@myFamilyUniqueFamilyAuthId')->name('my-family-unique-family-auth-id');
            Route::get('/families/specific/{id}', 'Api\V1\Pmis\Employee\FamilyController@specific')->name('index-specific');
            Route::get('/families/my-family', 'Api\V1\Pmis\Employee\FamilyController@myFamily')->name('my-family');
            Route::get('/families/{id}', 'Api\V1\Pmis\Employee\FamilyController@view')->name('view');
            Route::get('/family-files/{id}', 'Api\V1\Pmis\Employee\FamilyController@getFamilyFiles')->name('getFamilyFiles');
            Route::get('/nominee-for-list', 'Api\V1\Pmis\Employee\FamilyController@nominee_for_list')->name('nominee_for_list');
            Route::post('/families', 'Api\V1\Pmis\Employee\FamilyController@store')->name('store');
            Route::post('/my-families', 'Api\V1\Pmis\Employee\FamilyController@myFamilyStore')->name('myFamilyStore');
            Route::put('/families/{id}', 'Api\V1\Pmis\Employee\FamilyController@update')->name('update');
            Route::delete('/families/{id}', 'Api\V1\Pmis\Employee\FamilyController@remove')->name('remove');

            Route::get('/families/update-contacts-hold-yn/{id}/{holdYN}', 'Api\V1\Pmis\Employee\FamilyController@holdFamily')->name('update-families-hold-yn');
            Route::get('/families/unapproved-families', 'Api\V1\Pmis\Employee\FamilyController@unapprovedFamily')->name('unapproved-families');
            Route::get('/approve-families', 'Api\V1\Pmis\Employee\FamilyController@approveFamily')->name('approve-families');
            Route::get('/download-authentication-document/{id}', 'Api\V1\Pmis\Employee\FamilyController@familyAuthDoc')->name('download-authentication-document');
        });

        // ExperienceController
        Route::group(['name' => 'experience.'], function() {
            // v1/pmis/employee/experiences
            Route::get('/experiences', 'Api\V1\Pmis\Employee\ExperienceController@index')->name('index');
            Route::get('/experiences/specific/{id}', 'Api\V1\Pmis\Employee\ExperienceController@specific')->name('index-specific');
            Route::get('/experiences/{id}', 'Api\V1\Pmis\Employee\ExperienceController@view')->name('view');
            Route::post('/experiences', 'Api\V1\Pmis\Employee\ExperienceController@store')->name('store');
            Route::put('/experiences/{id}', 'Api\V1\Pmis\Employee\ExperienceController@update')->name('update');
            Route::delete('/experiences/{id}', 'Api\V1\Pmis\Employee\ExperienceController@remove')->name('remove');
        });

        // IdentificationController
        Route::group(['name' => 'identification.'], function() {
            // v1/pmis/employee/identifications
            Route::get('/identifications', 'Api\V1\Pmis\Employee\IdentificationController@index')->name('index');
            Route::get('/identifications/specific/{id}', 'Api\V1\Pmis\Employee\IdentificationController@specific')->name('index-specific');
            Route::get('/identifications/{id}', 'Api\V1\Pmis\Employee\IdentificationController@view')->name('view');
            Route::post('/identifications', 'Api\V1\Pmis\Employee\IdentificationController@store')->name('store');
            Route::put('/identifications/{id}', 'Api\V1\Pmis\Employee\IdentificationController@update')->name('update');
            Route::delete('/identifications/{id}', 'Api\V1\Pmis\Employee\IdentificationController@remove')->name('remove');
        });

        // IncrementController
        Route::group(['name' => 'increment.'], function() {
            // v1/pmis/employee/increments
            Route::get('/increments', 'Api\V1\Pmis\Employee\IncrementController@index')->name('index');
            Route::get('/increments/{id}', 'Api\V1\Pmis\Employee\IncrementController@view')->name('view');
            Route::get('/increments/specific/{id}', 'Api\V1\Pmis\Employee\IncrementController@specific')->name('index-specific');
            Route::post('/increments', 'Api\V1\Pmis\Employee\IncrementController@store')->name('store');
            Route::put('/increments/{id}', 'Api\V1\Pmis\Employee\IncrementController@update')->name('update');
            Route::delete('/increments/{id}', 'Api\V1\Pmis\Employee\IncrementController@remove')->name('remove');
        });

        // NomineeController
        Route::group(['name' => 'nominee.'], function() {
            // v1/pmis/employee/nominees
            Route::get('/nominees', 'Api\V1\Pmis\Employee\NomineeController@index')->name('index');

            Route::get('/nominees/update-nominee-hold-yn/{id}/{holdYN}', 'Api\V1\Pmis\Employee\NomineeController@holdNominee')->name('update-nominee-hold-yn');
            Route::get('/nominees/unapproved-nominees', 'Api\V1\Pmis\Employee\NomineeController@unapprovedNominee')->name('unapproved-nominees');
            Route::put('/approve-nominee', 'Api\V1\Pmis\Employee\NomineeController@approveNominee')->name('approve-nominee');

            Route::get('/nominees/unique-nominee-auth-id', 'Api\V1\Pmis\Employee\NomineeController@uniqueNomineeAuthId')->name('unique-nominee-auth-id');
            Route::get('/nominees/specific/{id}', 'Api\V1\Pmis\Employee\NomineeController@specific')->name('index-specific');
            Route::get('/pension-nominees/{emp_id}', 'Api\V1\Pension\EmployeeServiceRecordController@pensionNominee')->name('pension-nominees');
            Route::post('/pension-nominees-update', 'Api\V1\Pension\EmployeeServiceRecordController@pensionNomineeUpdate')->name('pension-nominee-update');
            Route::get('/pension-nominees-delete/{emp_id}/{nominee_id}', 'Api\V1\Pension\EmployeeServiceRecordController@pensionNomineeDelete')->name('pension-nominee-deletes');
            Route::get('/nominees/specific/gpf/{id}', 'Api\V1\Pmis\Employee\NomineeController@specificGPF')->name('index-specific-gpf');
            Route::get('/nominees/current-employee-nominee', 'Api\V1\Pmis\Employee\NomineeController@currentEmployeeNominees')->name('currentEmployeeNominees');
            Route::get('/nominees/current-employee', 'Api\V1\Pmis\Employee\NomineeController@currentEmployee')->name('currentEmployee');
            Route::get('/nominees/my-nominee', 'Api\V1\Pmis\Employee\NomineeController@myNominee')->name('my-nominee');
            Route::get('/nominees/{id}', 'Api\V1\Pmis\Employee\NomineeController@view')->name('view');
            Route::post('/nominees/{id}', 'Api\V1\Pmis\Employee\NomineeController@store')->name('store');
            Route::put('/nominees/{id}', 'Api\V1\Pmis\Employee\NomineeController@update')->name('update');
            Route::delete('/nominees/{id}', 'Api\V1\Pmis\Employee\NomineeController@remove')->name('remove');
            Route::put('/update-nominee-workflow/{id}', 'Api\V1\Pmis\Employee\NomineeController@updateNomineeWorkflow')->name('updateNomineeWorkflow');
            Route::post('/final-approve/{workflowId}/{objectId}', 'Api\V1\Pmis\Employee\NomineeController@nomineeFinalApprove')->name('nomineeFinalApprove');




        });
        // contact
        Route::group(['name' => 'contact.'], function() {
            // v1/pmis/employee/contact
            Route::get('/contacts', 'Api\V1\Pmis\Employee\ContactController@index')->name('index');
            Route::get('/contacts/specific/{id}', 'Api\V1\Pmis\Employee\ContactController@specific')->name('index-specific');
            Route::get('/contacts/{id}', 'Api\V1\Pmis\Employee\ContactController@view')->name('view');
            Route::post('/contacts', 'Api\V1\Pmis\Employee\ContactController@store')->name('store');
            Route::put('/contacts/{id}', 'Api\V1\Pmis\Employee\ContactController@update')->name('update');
            Route::delete('/contacts/{id}', 'Api\V1\Pmis\Employee\ContactController@remove')->name('remove');

            Route::get('/contacts/update-contacts-hold-yn/{id}/{holdYN}', 'Api\V1\Pmis\Employee\ContactController@holdContact')->name('update-contacts-hold-yn');
            Route::get('/contacts/unapproved-contacts', 'Api\V1\Pmis\Employee\ContactController@unapprovedContact')->name('unapproved-contacts');
            Route::post('/approve-contacts', 'Api\V1\Pmis\ContactsApprovalController@approveContact')->name('approve-contacts');
        });

        // OtherQualificationController
        Route::group(['name' => 'other-qualification.'], function() {
            // v1/pmis/employee/other-qualifications
            Route::get('/other-qualifications', 'Api\V1\Pmis\Employee\OtherQualificationController@index')->name('index');
            Route::get('/other-qualifications/specific/{id}', 'Api\V1\Pmis\Employee\OtherQualificationController@specific')->name('index-specific');
            Route::get('/other-qualifications/{id}', 'Api\V1\Pmis\Employee\OtherQualificationController@view')->name('view');
            Route::post('/other-qualifications', 'Api\V1\Pmis\Employee\OtherQualificationController@store')->name('store');
            Route::put('/other-qualifications/{id}', 'Api\V1\Pmis\Employee\OtherQualificationController@update')->name('update');
            Route::delete('/other-qualifications/{id}', 'Api\V1\Pmis\Employee\OtherQualificationController@remove')->name('remove');
        });

        // PfLoanController
        Route::group(['name' => 'pf-loan.'], function() {
            // v1/pmis/employee/pf-loans
            Route::get('/pf-loans', 'Api\V1\Pmis\Employee\PfLoanController@index')->name('index');
            Route::get('/pf-loans/specific/{id}', 'Api\V1\Pmis\Employee\PfLoanController@specific')->name('index-specific');
            Route::get('/pf-loans/{id}', 'Api\V1\Pmis\Employee\PfLoanController@view')->name('view');
            Route::post('/pf-loans', 'Api\V1\Pmis\Employee\PfLoanController@store')->name('store');
            Route::put('/pf-loans/{id}', 'Api\V1\Pmis\Employee\PfLoanController@update')->name('update');
            Route::delete('/pf-loans/{id}', 'Api\V1\Pmis\Employee\PfLoanController@remove')->name('remove');
        });

        // ProfCertController
        Route::group(['name' => 'prof-cert.'], function() {
            // v1/pmis/employee/prof-certs
            Route::get('/prof-certs', 'Api\V1\Pmis\Employee\ProfCertController@index')->name('index');
            Route::get('/prof-certs/specific/{id}', 'Api\V1\Pmis\Employee\ProfCertController@specific')->name('index-specific');
            Route::get('/prof-certs/{id}', 'Api\V1\Pmis\Employee\ProfCertController@view')->name('view');
            Route::post('/prof-certs', 'Api\V1\Pmis\Employee\ProfCertController@store')->name('store');
            Route::put('/prof-certs/{id}', 'Api\V1\Pmis\Employee\ProfCertController@update')->name('update');
            Route::delete('/prof-certs/{id}', 'Api\V1\Pmis\Employee\ProfCertController@remove')->name('remove');
        });

        // PromotionController
        Route::group(['name' => 'promotion.'], function() {
            // v1/pmis/employee/promotions
            Route::get('/promotions', 'Api\V1\Pmis\Employee\PromotionController@index')->name('index');
            Route::get('/promotions/specific/{id}', 'Api\V1\Pmis\Employee\PromotionController@specific')->name('index-specific');
            Route::get('/promotions/{id}', 'Api\V1\Pmis\Employee\PromotionController@view')->name('view');
            Route::post('/promotions', 'Api\V1\Pmis\Employee\PromotionController@store')->name('store');
            Route::put('/promotions/{id}', 'Api\V1\Pmis\Employee\PromotionController@update')->name('update');
            Route::delete('/promotions/{id}', 'Api\V1\Pmis\Employee\PromotionController@remove')->name('remove');
        });

        // PunishmentController
        Route::group(['name' => 'punishment.'], function() {
            // v1/pmis/employee/punishments
            Route::get('/punishments', 'Api\V1\Pmis\Employee\PunishmentController@index')->name('index');
            Route::get('/punishments/specific/{id}', 'Api\V1\Pmis\Employee\PunishmentController@specific')->name('index-specific');
            Route::get('/punishments/{id}', 'Api\V1\Pmis\Employee\PunishmentController@view')->name('view');
            Route::post('/punishments', 'Api\V1\Pmis\Employee\PunishmentController@store')->name('store');
            Route::put('/punishments/{id}', 'Api\V1\Pmis\Employee\PunishmentController@update')->name('update');
            Route::delete('/punishments/{id}', 'Api\V1\Pmis\Employee\PunishmentController@remove')->name('remove');
        });

        // ServiceController
        Route::group(['name' => 'service.'], function() {
            // v1/pmis/employee/services
            Route::get('/services', 'Api\V1\Pmis\Employee\ServiceController@index')->name('index');
            Route::get('/services/{id}', 'Api\V1\Pmis\Employee\ServiceController@view')->name('view');
            Route::post('/services', 'Api\V1\Pmis\Employee\ServiceController@store')->name('store');
            Route::put('/services/{id}', 'Api\V1\Pmis\Employee\ServiceController@update')->name('update');
            Route::delete('/services/{id}', 'Api\V1\Pmis\Employee\ServiceController@remove')->name('remove');
        });

        // TaxBankController
        Route::group(['name' => 'tax-bank.'], function() {
            // v1/pmis/employee/tax-banks
            Route::get('/tax-banks', 'Api\V1\Pmis\Employee\TaxBankController@index')->name('index');
            Route::get('/tax-banks/{id}', 'Api\V1\Pmis\Employee\TaxBankController@view')->name('view');
            Route::post('/tax-banks', 'Api\V1\Pmis\Employee\TaxBankController@store')->name('store');
            Route::put('/tax-banks/{id}', 'Api\V1\Pmis\Employee\TaxBankController@update')->name('update');
            Route::delete('/tax-banks/{id}', 'Api\V1\Pmis\Employee\TaxBankController@remove')->name('remove');
        });

        // TourController
        Route::group(['name' => 'tour.'], function() {
            // v1/pmis/employee/tours
            Route::get('/tours', 'Api\V1\Pmis\Employee\TourController@index')->name('index');
            Route::get('/tours/specific/{id}', 'Api\V1\Pmis\Employee\TourController@specific')->name('index-specific');
            Route::get('/tours/{id}', 'Api\V1\Pmis\Employee\TourController@view')->name('view');
            Route::post('/tours', 'Api\V1\Pmis\Employee\TourController@store')->name('store');
            Route::put('/tours/{id}', 'Api\V1\Pmis\Employee\TourController@update')->name('update');
            Route::delete('/tours/{id}', 'Api\V1\Pmis\Employee\TourController@remove')->name('remove');
        });

        // TrainingController
        Route::group(['name' => 'training.'], function() {
            // v1/pmis/employee/trainings
            Route::get('/trainings', 'Api\V1\Pmis\Employee\TrainingController@index')->name('index');
            Route::get('/trainings/specific/{id}', 'Api\V1\Pmis\Employee\TrainingController@specific')->name('index-specific');
            Route::get('/trainings/{id}', 'Api\V1\Pmis\Employee\TrainingController@view')->name('view');
            Route::get('/trainings/check-country-field/{id}', 'Api\V1\Pmis\Employee\TrainingController@checkCountryField')->name('check-country-field');
            Route::post('/trainings', 'Api\V1\Pmis\Employee\TrainingController@store')->name('store');
            Route::put('/trainings/{id}', 'Api\V1\Pmis\Employee\TrainingController@update')->name('update');
            Route::delete('/trainings/{id}', 'Api\V1\Pmis\Employee\TrainingController@remove')->name('remove');
        });

        // TransferController
        Route::group(['name' => 'transfer.'], function() {
            // v1/pmis/employee/transfers
            Route::get('/transfers', 'Api\V1\Pmis\Employee\TransferController@index')->name('index');
            Route::get('/transfers/specific/{id}', 'Api\V1\Pmis\Employee\TransferController@specific')->name('index-specific');
            Route::get('/transfers/{id}', 'Api\V1\Pmis\Employee\TransferController@view')->name('view');
            Route::post('/transfers', 'Api\V1\Pmis\Employee\TransferController@store')->name('store');
            Route::put('/transfers/{id}', 'Api\V1\Pmis\Employee\TransferController@update')->name('update');
            Route::delete('/transfers/{id}', 'Api\V1\Pmis\Employee\TransferController@remove')->name('remove');
        });
        // TempBasicInfoCollectionController
        Route::group(['name' => 'basic-info-collection.'], function() {
            // v1/pmis/employee/basic-info-collection
            Route::get('/basic-info-collection/get-basic-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@getEmployeeBasicInfo')->name('getEmployeeBasicInfo');
            Route::get('/basic-info-collection/get-club-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@getEmployeeClubInfo')->name('getEmployeeClubInfo');
            Route::get('/basic-info-collection/get-loan-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@getEmployeeLoanInfo')->name('getEmployeeLoanInfo');
            Route::get('/basic-info-collection/get-family-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@getEmployeeFamilyInfo')->name('getEmployeeFamilyInfo');
            Route::get('/basic-info-collection/get-gpf-info/{emp_code}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@getEmployeeGPFInfo')->name('getEmployeeGPFInfo');
            Route::post('/basic-info-collection/basic', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@storeBasicInfo')->name('storeBasicInfo');
            Route::post('/basic-info-collection/club', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@storeClubInfo')->name('storeClubInfo');
            Route::post('/basic-info-collection/loan', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@storeLoanInfo')->name('storeLoanInfo');
            Route::post('/basic-info-collection/gpf-info', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@storeGPFInfo')->name('storeGPFInfo');
            Route::post('/basic-info-collection/family', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@storeFamilyInfo')->name('storeFamilyInfo');
            Route::delete('/basic-info-collection/del-club-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@deleteClubInfo')->name('deleteClubInfo');
            Route::delete('/basic-info-collection/del-loan-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@deleteLoanInfo')->name('deleteLoanInfo');
            Route::delete('/basic-info-collection/del-family-info/{id}', 'Api\V1\Pmis\Employee\TempBasicInfoCollectionController@deleteFamilyInfo')->name('deleteFamilyInfo');
        });
    });

    //Deputation employee
    Route::group(['prefix' => 'deputation-employee', 'name' => 'deputation-employee'], function() {

        // DepuEmpBasicInfoController
        Route::group(['name' => 'deputation-emp-basic-info.'], function() {
            // v1/pmis/employee/basic-infos
            Route::get('/basic-infos', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@index')->name('index');
            Route::get('/basic-infos/unique-employee-code', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@uniqueEmployeeCode')->name('unique-employee-code');
            Route::get('/basic-infos/check-valid-nid', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@checkIsValidNID')->name('checkIsValidNID');
            Route::get('/basic-infos/{id}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@view')->name('view');
            Route::get('/basic-infos/employee-information/{name}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@employeeInformation')->name('employee-information');
            Route::get('/basic-infos/pay-grades/{empTypeId}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@payGrades')->name('pay-grades');
            Route::get('/basic-infos/gpf-subscription/{id}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@gpfSubscription')->name('gpf-subscription');
            Route::post('/basic-infos', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@store')->name('store');
            Route::post('/basic-infos/update-gpf-subscription/{id}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@updateGpfSubscription')->name('update-gpf-subscription');
            Route::put('/basic-infos/{id}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@update')->name('update');
            Route::delete('/basic-infos/{id}', 'Api\V1\Pmis\Employee\DepuEmpBasicInfoController@remove')->name('remove');
        });
    });

    // Operations
    Route::group(['prefix' => 'operations', 'name' => 'operations.'], function() {

        // IncrementController
        Route::group(['name' => 'increment.'], function() {
            // v1/pmis/operations/increments
            Route::get('/increments', 'Api\V1\Pmis\Operations\IncrementController@index')->name('index');
            Route::get('/increments/{id}', 'Api\V1\Pmis\Operations\IncrementController@view')->name('view');
            Route::post('/increments', 'Api\V1\Pmis\Operations\IncrementController@store')->name('store');
            Route::put('/increments/{id}', 'Api\V1\Pmis\Operations\IncrementController@update')->name('update');
            Route::delete('/increments/{id}', 'Api\V1\Pmis\Operations\IncrementController@remove')->name('remove');
        });

        // PromotionController
        Route::group(['name' => 'promotion.'], function() {
            // v1/pmis/operations/promotions
            Route::get('/promotions', 'Api\V1\Pmis\Operations\PromotionController@index')->name('index');
            Route::get('/promotions/{id}', 'Api\V1\Pmis\Operations\PromotionController@view')->name('view');
            Route::post('/promotions', 'Api\V1\Pmis\Operations\PromotionController@store')->name('store');
            Route::put('/promotions/{id}', 'Api\V1\Pmis\Operations\PromotionController@update')->name('update');
            Route::delete('/promotions/{id}', 'Api\V1\Pmis\Operations\PromotionController@remove')->name('remove');

            //Route::get('/test/{id}', 'Api\V1\Pmis\Operations\PromotionController@test')->name('test');
        });

        // PunishmentController
        Route::group(['name' => 'punishment.'], function() {
            // v1/pmis/operations/punishments
            Route::get('/punishments', 'Api\V1\Pmis\Operations\PunishmentController@index')->name('index');
            Route::get('/punishments/{id}', 'Api\V1\Pmis\Operations\PunishmentController@view')->name('view');
            Route::post('/punishments', 'Api\V1\Pmis\Operations\PunishmentController@store')->name('store');
            Route::put('/punishments/{id}', 'Api\V1\Pmis\Operations\PunishmentController@update')->name('update');
            Route::delete('/punishments/{id}', 'Api\V1\Pmis\Operations\PunishmentController@remove')->name('remove');
        });

        // TourController
        Route::group(['name' => 'tour.'], function() {
            // v1/pmis/operations/tours
            Route::get('/tours', 'Api\V1\Pmis\Operations\TourController@index')->name('index');
            Route::get('/tours/{id}', 'Api\V1\Pmis\Operations\TourController@view')->name('view');
            Route::post('/tours', 'Api\V1\Pmis\Operations\TourController@store')->name('store');
            Route::put('/tours/{id}', 'Api\V1\Pmis\Operations\TourController@update')->name('update');
            Route::delete('/tours/{id}', 'Api\V1\Pmis\Operations\TourController@remove')->name('remove');
        });

        // TransferController
        Route::group(['name' => 'transfer.'], function() {
            // v1/pmis/operations/transfers
            Route::get('/transfers', 'Api\V1\Pmis\Operations\TransferController@index')->name('index');
            Route::get('/transfers/{id}', 'Api\V1\Pmis\Operations\TransferController@view')->name('view');
            Route::post('/transfers', 'Api\V1\Pmis\Operations\TransferController@store')->name('store');
            Route::put('/transfers/{id}', 'Api\V1\Pmis\Operations\TransferController@update')->name('update');
            Route::delete('/transfers/{id}', 'Api\V1\Pmis\Operations\TransferController@remove')->name('remove');
        });
    });

    // Generic routes. Note: Generic routes should be at the very bottom after matching most specific routes.
    // v1/pmis/add-employee
    Route::get('/add-employees', 'Api\V1\Pmis\AddEmployeeController@index')->name('add-employee');
    Route::get('/dashboard', 'Api\V1\Pmis\DashboardController@index')->name('dashboard');
    Route::get('/search-employees', 'Api\V1\Pmis\SearchEmployeeController@index')->name('search-employee');
    Route::get('/search-employees-for-basic', 'Api\V1\Pmis\SearchEmployeeController@lookupDataForBasic')->name('search-employee-for-basic');
    Route::get('/all-grades', 'Api\V1\Admin\AdminController@allGrades')->name('allGrades');
    Route::get('/get-modules', 'Api\V1\Admin\AdminController@getModules')->name('getModules');
    Route::get('/employeeSearch/{department_id}/{section_id}/{emp_grade_id}/{designation_id}/{status_id}/{deputation_yn}/{emp_active_yn}/{actual_grade_id?}/{emp_code?}', 'Api\V1\Pmis\SearchEmployeeController@search')->name('search');
    Route::get('/employeeSearchForBasic/{department_id}/{section_id}/{emp_grade_id}/{designation_id}/{status_id}/{emp_code?}', 'Api\V1\Pmis\SearchEmployeeController@searchForBasic')->name('searchForBasic');
    Route::get('/search-deputation-employees', 'Api\V1\Pmis\SearchDeputationEmployeeController@index')->name('search-deputation-employee');
    Route::get('/deputation-employee-search/{department_id}/{section_id}/{emp_code?}', 'Api\V1\Pmis\SearchDeputationEmployeeController@search')->name('deputation-search');
    Route::get('/employee-for-manual-setup/{bill_code}/{emp_code?}', 'Api\V1\Pmis\SearchDeputationEmployeeController@searchEmployeeByBillcode')->name('deputation-search');
    Route::get('/details-records/{id}', 'Api\V1\Pmis\EmployeeDetailsController@index')->name('details-records');
    Route::get('/search-unapproved-employee/{id}', 'Api\V1\Pmis\SearchEmployeeController@searchUnapprovedEmployees')->name('search-unapproved-employee');
    Route::get('/unapproved-employees', 'Api\V1\Pmis\SearchEmployeeController@unapprovedEmployees')->name('unapproved-employees');
    Route::get('/comparison-employee-update/{id}', 'Api\V1\Pmis\SearchEmployeeController@comparisonEmployeeUpdate')->name('comparison-employee-update');
    Route::post('/update-employee-hold-yn/{id}/{holdYN}', 'Api\V1\Pmis\EmployeeApprovalController@updateEmployeeTemp')->name('update-employee-hold-yn');
    Route::post('/approve-employee', 'Api\V1\Pmis\EmployeeApprovalController@approveEmployee')->name('approve-employee');
    Route::post('/approve-employee-single', 'Api\V1\Pmis\EmployeeApprovalController@approveSingleEmployee')->name('approve-employee');
    Route::post('/approve-contact', 'Api\V1\Pmis\ContactsApprovalController@approveContact')->name('approve-contact');
    Route::post('/update-contact-temp/{id}/{holdYN}', 'Api\V1\Pmis\ContactsApprovalController@updateContactTemp')->name('update-contact-temp');
    Route::post('/unapproved-contact-list', 'Api\V1\Pmis\ContactsApprovalController@unapprovedContactList')->name('unapproved-contact-list');
    Route::post('/unapproved-address-list', 'Api\V1\Pmis\AddressApprovalController@unapprovedAddressList')->name('unapproved-address-list');
    Route::post('/update-address-temp/{id}/{holdYN}', 'Api\V1\Pmis\AddressApprovalController@updateAddressTemp')->name('update-address-temp');
    Route::post('/approve-address', 'Api\V1\Pmis\AddressApprovalController@approveAddress')->name('approve-address');
    Route::post('/approve-family', 'Api\V1\Pmis\FamiliesApprovalController@approveFamily')->name('approve-family');
    Route::post('/approve-family-single', 'Api\V1\Pmis\FamiliesApprovalController@approveSingleFamily')->name('approve-family');
    Route::post('/update-family-temp/{id}/{holdYN}', 'Api\V1\Pmis\FamiliesApprovalController@updateFamilyTemp')->name('update-family-temp');
    Route::post('/unapproved-family-list', 'Api\V1\Pmis\FamiliesApprovalController@unapprovedFamilyList')->name('unapproved-family-list');
    // Academic Approval
    Route::get('/unapproved-academic-list', 'Api\V1\Pmis\AcademicApprovalController@unapprovedAcademicList')->name('unapproved-academic-list');
    Route::put('/update-academic-temp/{id}/{holdYN}', 'Api\V1\Pmis\AcademicApprovalController@updateAcademicTemp')->name('update-academic-temp');
    Route::put('/approve-academic', 'Api\V1\Pmis\AcademicApprovalController@approveAcademic')->name('approve-academic');

    // Training Approval
    Route::get('/unapproved-traning-list', 'Api\V1\Pmis\TraningApprovalController@unapprovedTraningList')->name('unapproved-traning-list');
    Route::put('/update-traning-temp/{id}/{holdYN}', 'Api\V1\Pmis\TraningApprovalController@updateTraningTemp')->name('update-traning-temp');
    Route::put('/approve-traning', 'Api\V1\Pmis\TraningApprovalController@approveTraning')->name('approve-traning');

    // Tour Approval
    Route::get('/unapproved-tour-list', 'Api\V1\Pmis\TourApprovalController@unapprovedTourList')->name('unapproved-tour-list');
    Route::put('/update-tour-temp/{id}/{holdYN}', 'Api\V1\Pmis\TourApprovalController@updateTourTemp')->name('update-tour-temp');
    Route::put('/approve-tour', 'Api\V1\Pmis\TourApprovalController@approveTour')->name('approve-tour');
//    Route::put('/charge-entry-approval', 'Api\V1\Pmis\ChargeEntryController@inChargeApproval')->name('inChargeApproval');


});

Route::group(['prefix' => 'attendance', 'name' => 'attendance.'], function() {
    Route::get('/report-parameters', 'Api\V1\Report\AttendanceParameterController@index')->name('index');
    Route::post('/attendances-upload', 'Api\V1\Attendance\AttendanceUploadController@store')->name('store');
    Route::get('/months', 'Api\V1\Attendance\AttendanceController@getMonthAction')->name('get-month');
    Route::post('/process', 'Api\V1\Attendance\AttendanceController@processAttendance')->name('process');
    Route::get('/entry/emp-info/{id}/{dpt?}', 'Api\V1\Leave\EmpLeaveTempController@getAttentDanceEmpInfo')->name('getEmpInfo');

    Route::group(['name' => 'entry.'], function() {
        Route::get('/attendances', 'Api\V1\Attendance\AttendanceController@index')->name('index');
        Route::post('/attendances', 'Api\V1\Attendance\AttendanceController@store')->name('store');
        Route::post('/search', 'Api\V1\Attendance\AttendanceController@search')->name('search');
        Route::post('/cal-hour', 'Api\V1\Attendance\AttendanceController@calHour')->name('cal-hour');
        Route::post('/academic-status', 'Api\V1\Attendance\AttendanceController@academicStatus')->name('academic-status');
    });

    Route::group(['name' => 'details.'], function() {
        Route::get('/details', 'Api\V1\Attendance\AttendanceDetailsController@index')->name('index');
        Route::get('/details/{id}/{fromDate}/{toDate}/{type}', 'Api\V1\Attendance\AttendanceDetailsController@attendanceDetails')->name('attendanceDetails');
        Route::post('/details', 'Api\V1\Attendance\AttendanceDetailsController@searchAttendanceDetails')->name('search-attendance-employees');
    });

    Route::group(['name' => 'approval.'], function() {
        Route::get('/approvals', 'Api\V1\Attendance\AttendanceApprovalController@index')->name('index');
        Route::post('/approvals', 'Api\V1\Attendance\AttendanceApprovalController@store')->name('store');
        Route::post('/approvals-search', 'Api\V1\Attendance\AttendanceApprovalController@search')->name('approval-search');
        Route::post('/department-approval-search', 'Api\V1\Attendance\AttendanceApprovalController@departmentSearch')->name('department-search');
    });
});

//Admin module
Route::group(['prefix' => 'leave', 'name' => 'admin.'], function () {
    Route::get('/leave-summery-form-data', 'Api\V1\Leave\SummeryController@formData')->name('summery-form-data');
    Route::post('/leave-summery-search', 'Api\V1\Leave\SummeryController@search')->name('summery-search');

    Route::group(['prefix' => 'attendance', 'name' => 'attendance'], function() {
        //route = /leave/attendance/employees
        Route::get('/employees', 'Api\V1\Leave\AttendanceController@index')->name('leave-attendance-employees');
        Route::get('/attendances', 'Api\V1\Leave\AttendanceController@load')->name('leave-attendance-add');
        Route::get('/attendance-entry', 'Api\V1\Leave\AttendanceController@loadAll')->name('attendance-entry');
        Route::get('/attendance-entry/{id}', 'Api\V1\Leave\AttendanceController@viewData')->name('attendance-view');
        Route::post('/approval-list-search', 'Api\V1\Leave\AttendanceController@approvalList')->name('search');
        Route::post('/approval-list', 'Api\V1\Leave\AttendanceController@approved')->name('approval-list');
        Route::post('/attendance-entry', 'Api\V1\Leave\AttendanceController@save')->name('save');
        Route::post('/attendances', 'Api\V1\Leave\AttendanceController@post')->name('leave-temp-attendance');
    });


});


//Admin module
Route::group(['prefix' => 'admin', 'name' => 'admin.'], function () {

    Route::get('/auth-acl', 'Api\V1\Security\UserController@getPermissions')->name('acl-permissions');

// Generic routes. Note: Generic routes should be at the very bottom after matching most specific routes.
    // System Admin
    Route::group(['prefix' => 'system-admin', 'name' => 'system-admin.'], function() {
        // SearchUserController
        Route::group(['name' => 'system-admin.'], function() {
            // v1/admin/system-admin/search-users
            Route::get('/search-users', 'Api\V1\Admin\SystemSetup\SearchUserController@index')->name('index');
            Route::post('/search-employee', 'Api\V1\Admin\SystemSetup\SearchUserController@searchEmployee')->name('searchEmployee');
            Route::post('/search-user', 'Api\V1\Admin\SystemSetup\SearchUserController@searchUser')->name('searchUser');
        });

            // CreateUserController
        Route::group(['name' => 'system-admin.'], function() {
            // v1/admin/system-admin/create-user
            Route::get('/create-users', 'Api\V1\Admin\SystemSetup\CreateUserController@index')->name('index');
            Route::get('/create-users/emp-info/{id}', 'Api\V1\Admin\SystemSetup\CreateUserController@getEmpInfo')->name('index');
            Route::get('/create-user/{id}', 'Api\V1\Admin\SystemSetup\CreateUserController@view')->name('view');
            Route::get('/getUserData/{id}', 'Api\V1\Admin\SystemSetup\CreateUserController@getUserData')->name('getUserData');
            Route::post('/create-user', 'Api\V1\Admin\SystemSetup\CreateUserController@store')->name('store');
            Route::post('/create-user-role-assign', 'Api\V1\Admin\SystemSetup\CreateUserController@createUserRoleAssign')->name('create-user-role-assign');
            Route::post('/update-user', 'Api\V1\Admin\SystemSetup\CreateUserController@updateUser')->name('updateUser');
            Route::get('/update-user/{id}', 'Api\V1\Admin\SystemSetup\CreateUserController@getUpdateUserInfo')->name('updateUser');
            Route::post('/update-user-password', 'Api\V1\Admin\SystemSetup\CreateUserController@updateUserPassword')->name('update-user-password');
            Route::put('/create-user/{id}', 'Api\V1\Admin\SystemSetup\CreateUserController@update')->name('update');
            Route::delete('/create-user/{id}', 'Api\V1\Admin\SystemSetup\CreateUserController@remove')->name('remove');
        });

        // RoleMenuMapController
        Route::group(['name' => 'system-admin.'], function() {
            // v1/admin/system-admin/rome-menu-map
            Route::get('/role-menu-map', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@index')->name('index');
            Route::get('/role/search-user/{name}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@searchUser')->name('search-user');
            Route::post('/role', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@roleSave')->name('roleSave');
            Route::get('/role', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@roles')->name('roles');
            Route::get('/fetch-user-roles/{userId}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@fetchUserRoles')->name('fetch-user-roles');
            Route::post('/roles/save-user-roles', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@saveUserRoles')->name('save-user-roles');
            Route::post('/roles/unassign-user-roles/{role_id}/{user_id}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@unAssignUserRole')->name('unassign-user-roles');
            Route::get('/fetch-roles', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@fetchRoles')->name('fetch-roles');
            Route::post('/acl/permission/{roleId}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@postPermissionAcl')->name('post-permission-acl');
            Route::post('/acl/report/{roleId}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@postReportAcl')->name('post-report-acl');
            Route::get('/acl/{roleId}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@acl')->name('get-acl');
            Route::post('/acl/{roleId}', 'Api\V1\Admin\SystemSetup\RoleMenuMapController@postAcl')->name('post-acl');
        });

        Route::group(['name' => 'report.'], function() {
            // v1/admin/system-admin/reports
            Route::get('/reports', 'Api\V1\Admin\SystemSetup\ReportController@index')->name('index');
            Route::get('/reports/{id}', 'Api\V1\Admin\SystemSetup\ReportController@view')->name('view');
            Route::post('/reports', 'Api\V1\Admin\SystemSetup\ReportController@store')->name('store');
            Route::put('/reports/{id}', 'Api\V1\Admin\SystemSetup\ReportController@update')->name('update');
            Route::delete('/reports/{id}', 'Api\V1\Admin\SystemSetup\ReportController@remove')->name('remove');
        });

             // UserIpAssignController
        Route::group(['name' => 'system-admin.'], function() {
            // v1/admin/system-admin/user-ip-assign
            Route::get('/user-ip-assign', 'Api\V1\Admin\SystemSetup\UserIpAssignController@index')->name('index');
            Route::get('/user-ip/{id}', 'Api\V1\Admin\SystemSetup\UserIpAssignController@view')->name('view');
            Route::get('/getAssignUserData/{id}', 'Api\V1\Admin\SystemSetup\UserIpAssignController@getAssignUserData')->name('getAssignUserData');
            Route::post('/user-ip-assign', 'Api\V1\Admin\SystemSetup\UserIpAssignController@store')->name('store');
            Route::put('/user-ip-assign/{id}', 'Api\V1\Admin\SystemSetup\UserIpAssignController@update')->name('update');
            Route::delete('/user-ip-assign/{id}/{ip}', 'Api\V1\Admin\SystemSetup\UserIpAssignController@remove')->name('remove');
        });
    });


     // General
    Route::group(['prefix' => 'general', 'name' => 'general.'], function() {
     // BankController
        Route::group(['name' => 'general.'], function() {
            // v1/banks
            Route::get('/banks', 'Api\V1\Admin\General\BankController@index')->name('index');
            Route::get('/bank/{id}', 'Api\V1\Admin\General\BankController@view')->name('view');
            Route::post('/bank', 'Api\V1\Admin\General\BankController@store')->name('store');
            Route::put('/bank/{id}', 'Api\V1\Admin\General\BankController@update')->name('update');
            Route::delete('/bank/{id}', 'Api\V1\Admin\General\BankController@remove')->name('remove');
        });
        // BranchController
        Route::group(['name' => 'general.'], function() {
            // v1/banks
            Route::get('/branches', 'Api\V1\Admin\General\BranchController@index')->name('index');
            Route::get('/branch/{id}', 'Api\V1\Admin\General\BranchController@view')->name('view');
            Route::post('/branch', 'Api\V1\Admin\General\BranchController@store')->name('store');
            Route::put('/branch/{id}', 'Api\V1\Admin\General\BranchController@update')->name('update');
            Route::delete('/branch/{id}', 'Api\V1\Admin\General\BranchController@remove')->name('remove');
        });
      });

    // Biller
    Route::group(['prefix' => 'biller', 'name' => 'biller.'], function() {
        // BilerCodeController
        Route::group(['name' => 'biller.'], function() {
            Route::get('/bill-code', 'Api\V1\Admin\Biller\BillerCodeController@index')->name('index');
            Route::get('/bill-code-master', 'Api\V1\Admin\Biller\BillerCodeController@billCodeMaster')->name('billCodeMaster');
            Route::get('/biller-map/{id}', 'Api\V1\Admin\Biller\BillerCodeController@specific')->name('specific');
            Route::get('/employee-list/{billerCode}/{billCode}', 'Api\V1\Admin\Biller\BillerCodeController@employees')->name('employees');
            Route::post('/biller-entry', 'Api\V1\Admin\Biller\BillerCodeController@save')->name('save');
            Route::get('/billerinfo/{id}', 'Api\V1\Admin\Biller\BillerCodeController@getBillerInfo')->name('billerinfo');
        });
        // BilerController
        Route::group(['name' => 'biller.'], function() {
            Route::get('/biller-list', 'Api\V1\Admin\Biller\BillerController@index')->name('index');
            Route::get('/biller-list/{id}', 'Api\V1\Admin\Biller\BillerController@specific')->name('specific');
            Route::post('/biller', 'Api\V1\Admin\Biller\BillerController@save')->name('save');
        });
    });

    Route::group(['prefix' => 'post', 'name' => 'news.'], function() {
            //v1/admin/post/news/active   -- all active news
            //v1/admin/post/news/{id}/active -- singe active news
            Route::get('/news', 'Api\V1\Admin\News\PostController@index')->name('index');
            Route::get('/news/active', 'Api\V1\Admin\News\PostController@activeNews')->name('news-active');
            Route::get('/news/{id}/active', 'Api\V1\Admin\News\PostController@getNews')->name('single-news-active');
            Route::post('/news', 'Api\V1\Admin\News\PostController@store')->name('save');
            Route::put('/news/{id}', 'Api\V1\Admin\News\PostController@update')->name('update');
            Route::delete('/news/{id}', 'Api\V1\Admin\News\PostController@remove')->name('delete');
            Route::put('/approved/news/{id}', 'Api\V1\Admin\News\PostController@approved')->name('approved');
            Route::put('/published/news/{id}', 'Api\V1\Admin\News\PostController@published')->name('published');
            Route::get('/attachment/news/{news_id}', 'Api\V1\Admin\News\PostController@downloadAttachment')->name('download');

    });

    // Employee position
    Route::group(['prefix' => 'employee-position', 'name' => 'employee-position.'], function() {

        // DepartmentController
        Route::group(['name' => 'department.'], function() {
            // v1/admin/employee-position/departments
            Route::get('/departments', 'Api\V1\Admin\EmployeePosition\DepartmentController@index')->name('index');
            Route::get('/departments/{id}', 'Api\V1\Admin\EmployeePosition\DepartmentController@view')->name('view');
            Route::post('/departments', 'Api\V1\Admin\EmployeePosition\DepartmentController@store')->name('store');
            Route::put('/departments/{id}', 'Api\V1\Admin\EmployeePosition\DepartmentController@update')->name('update');
            Route::delete('/departments/{id}', 'Api\V1\Admin\EmployeePosition\DepartmentController@remove')->name('remove');
            Route::post('/dpt-designation-mapping', 'Api\V1\Admin\EmployeePosition\DepartmentController@deptBasedDesignationMapping')->name('deptBasedDesignationMapping');
            Route::get('/dpt-designation-mapping-data', 'Api\V1\Admin\EmployeePosition\DepartmentController@getDesinationMapping')->name('getDesinationMapping');
        });

        // DesignationController
        Route::group(['name' => 'designation.'], function() {
            // v1/admin/employee-position/designations
            Route::get('/designations', 'Api\V1\Admin\EmployeePosition\DesignationController@index')->name('index');
            Route::get('/designations/{id}', 'Api\V1\Admin\EmployeePosition\DesignationController@view')->name('view');
            Route::post('/designations', 'Api\V1\Admin\EmployeePosition\DesignationController@store')->name('store');
            Route::put('/designations/{id}', 'Api\V1\Admin\EmployeePosition\DesignationController@update')->name('update');
            Route::delete('/designations/{id}', 'Api\V1\Admin\EmployeePosition\DesignationController@remove')->name('remove');
        });

        // DivisionController
        Route::group(['name' => 'division.'], function() {
            // v1/admin/employee-position/divisions
            Route::get('/divisions', 'Api\V1\Admin\EmployeePosition\DivisionController@index')->name('index');
            Route::get('/divisions/{id}', 'Api\V1\Admin\EmployeePosition\DivisionController@view')->name('view');
            Route::post('/divisions', 'Api\V1\Admin\EmployeePosition\DivisionController@store')->name('store');
            Route::put('/divisions/{id}', 'Api\V1\Admin\EmployeePosition\DivisionController@update')->name('update');
            Route::delete('/divisions/{id}', 'Api\V1\Admin\EmployeePosition\DivisionController@remove')->name('remove');
        });

        // SectionController
        Route::group(['name' => 'section.'], function() {
            // v1/admin/employee-position/sections
            Route::get('/sections', 'Api\V1\Admin\EmployeePosition\SectionController@index')->name('index');
            Route::get('/search-by-deptId/{id}', 'Api\V1\Admin\EmployeePosition\SectionController@getSectionsByBptId')->name('getSectionsByBptId');
            Route::get('/sections/{id}', 'Api\V1\Admin\EmployeePosition\SectionController@view')->name('view');
            Route::post('/sections', 'Api\V1\Admin\EmployeePosition\SectionController@store')->name('store');
            Route::put('/sections/{id}', 'Api\V1\Admin\EmployeePosition\SectionController@update')->name('update');
            Route::delete('/sections/{id}', 'Api\V1\Admin\EmployeePosition\SectionController@remove')->name('remove');
        });
    });

    // Exam setup
    Route::group(['prefix' => 'exam-setup', 'name' => 'exam-setup.'], function() {

        // ExamBodyController
        Route::group(['name' => 'exam-body.'], function() {
            // v1/admin/exam-setup/exam-bodies
            Route::get('/exam-bodies', 'Api\V1\Admin\ExamSetup\ExamBodyController@index')->name('index');
            Route::get('/exam-bodies/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyController@view')->name('view');
            Route::post('/exam-bodies', 'Api\V1\Admin\ExamSetup\ExamBodyController@store')->name('store');
            Route::put('/exam-bodies/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyController@update')->name('update');
            Route::delete('/exam-bodies/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyController@remove')->name('remove');

            //v1/admin/exam-setup/exam-body-mapping
            //Dipu
            Route::get('/exam-body-mapping', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@getInitData')->name('getInitData');//load data on dropdown and multi select(Dipu)

            Route::get('/search-by-examBodyId/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@getExamByExamId')->name('getExamByExamId'); //Search by exam id

            Route::get('/exam-body-mapping', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@index')->name('index');
            Route::get('/exam-body-mapping/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@view')->name('view');
            Route::post('/exam-body-mapping', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@store')->name('store');
            Route::put('/exam-body-mapping/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@update')->name('update');
            Route::delete('/exam-body-mapping/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@remove')->name('remove');
            Route::post('/exam-body-store', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@bodyStore')->name('exam-body-store');

            Route::get('/institute-entry', 'Api\V1\Admin\ExamSetup\InstituteEntryController@index')->name('institute-entry');
            Route::post('/institute-store', 'Api\V1\Admin\ExamSetup\InstituteEntryController@bodyStore')->name('institute-store');
            Route::get('/institute-entry-datatable', 'Api\V1\Admin\ExamSetup\InstituteEntryController@bodyDatatable')->name('institute-entry-datatable');
            Route::delete('/institute-entry-delete/{id}', 'Api\V1\Admin\ExamSetup\InstituteEntryController@destroy')->name('institute-entry-delete');

            Route::get('/subject-entry', 'Api\V1\Admin\ExamSetup\SubjectEntryController@index')->name('subject-entry');
            Route::post('/subject-store', 'Api\V1\Admin\ExamSetup\SubjectEntryController@bodyStore')->name('subject-store');
            Route::get('/subject-entry-datatable', 'Api\V1\Admin\ExamSetup\SubjectEntryController@bodyDatatable')->name('subject-entry-datatable');
            Route::delete('/subject-entry-delete/{id}', 'Api\V1\Admin\ExamSetup\SubjectEntryController@destroy')->name('subject-entry-delete');


            Route::get('/exam-body-datatable', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@bodyDatatable')->name('exam-body-datatable');
            Route::delete('/exam-body-delete/{id}', 'Api\V1\Admin\ExamSetup\ExamBodyMappingController@destroy')->name('exam-body-delete');

            //v1/admin/exam-setup/exam-mapping
            Route::get('/exam-mapping', 'Api\V1\Admin\ExamSetup\ExamMappingController@getInitData')->name('getInitData');//load data on dropdown as well as multi select(Dipu)

            Route::get('/search-by-examId/{id}', 'Api\V1\Admin\ExamSetup\ExamMappingController@getExamByExamId')->name('getExamByExamId');

            Route::get('/exam-mapping', 'Api\V1\Admin\ExamSetup\ExamMappingController@index')->name('index');
            Route::get('/exam-mapping/{id}', 'Api\V1\Admin\ExamSetup\ExamMappingController@view')->name('view');
            Route::post('/exam-mapping', 'Api\V1\Admin\ExamSetup\ExamMappingController@store')->name('store');
            Route::put('/exam-mapping/{id}', 'Api\V1\Admin\ExamSetup\ExamMappingController@update')->name('update');
            Route::delete('/exam-mapping/{id}', 'Api\V1\Admin\ExamSetup\ExamMappingController@remove')->name('remove');


        });

        // ExamInfoController
        Route::group(['name' => 'exam-info.'], function() {
            // v1/admin/exam-setup/exam-infos
            Route::get('/exam-infos', 'Api\V1\Admin\ExamSetup\ExamInfoController@index')->name('index');
            Route::get('/exam-infos/{id}', 'Api\V1\Admin\ExamSetup\ExamInfoController@view')->name('view');
            Route::post('/exam-infos', 'Api\V1\Admin\ExamSetup\ExamInfoController@store')->name('store');
            Route::put('/exam-infos/{id}', 'Api\V1\Admin\ExamSetup\ExamInfoController@update')->name('update');
            Route::delete('/exam-infos/{id}', 'Api\V1\Admin\ExamSetup\ExamInfoController@remove')->name('remove');
        });

        // ExamResultController
        Route::group(['name' => 'exam-result.'], function() {
            // v1/admin/exam-setup/exam-results
            Route::get('/exam-results', 'Api\V1\Admin\ExamSetup\ExamResultController@index')->name('index');
            Route::get('/exam-results/{id}', 'Api\V1\Admin\ExamSetup\ExamResultController@view')->name('view');
            Route::post('/exam-results', 'Api\V1\Admin\ExamSetup\ExamResultController@store')->name('store');
            Route::put('/exam-results/{id}', 'Api\V1\Admin\ExamSetup\ExamResultController@update')->name('update');
            Route::delete('/exam-results/{id}', 'Api\V1\Admin\ExamSetup\ExamResultController@remove')->name('remove');
        });
    });

    // Leave setup
    Route::group(['prefix' => 'leave-setup', 'name' => 'leave-setup.'], function() {

        // HolidayController
        Route::group(['name' => 'holiday.'], function() {
            // v1/admin/leave-setup/holidays
            Route::get('/holidays', 'Api\V1\Admin\LeaveSetup\HolidayController@index')->name('index');
            Route::get('/holidays/{id}', 'Api\V1\Admin\LeaveSetup\HolidayController@view')->name('view');
            Route::get('/holidays-fetch/{id}', 'Api\V1\Admin\LeaveSetup\HolidayController@fetch')->name('fetch');
            Route::post('/holidays', 'Api\V1\Admin\LeaveSetup\HolidayController@store')->name('store');
            Route::put('/holidays/{id}', 'Api\V1\Admin\LeaveSetup\HolidayController@update')->name('update');
            Route::delete('/holidays/{id}', 'Api\V1\Admin\LeaveSetup\HolidayController@remove')->name('remove');

            Route::get('/teachers-holiday-setup', 'Api\V1\Leave\HolidayTeacherController@index')->name('index');
            Route::post('/teachers-holiday-setup', 'Api\V1\Leave\HolidayTeacherController@store')->name('store');
            Route::delete('/teachers-holiday-setup/{id}', 'Api\V1\Leave\HolidayTeacherController@remove')->name('remove');
        });

        Route::group(['name' => 'academic-holiday-duty.'], function() {
            Route::get('/all-teachers', 'Api\V1\Leave\EmpAcademicHolidayDutyController@allTeachers')->name('allTeachers');
            Route::get('/academic-holiday-duty', 'Api\V1\Leave\EmpAcademicHolidayDutyController@index')->name('index');
            Route::post('/academic-holiday-duty', 'Api\V1\Leave\EmpAcademicHolidayDutyController@store')->name('store');
            Route::put('/academic-holiday-duty', 'Api\V1\Leave\EmpAcademicHolidayDutyController@approve')->name('approve');
            Route::delete('/academic-holiday-duty/{emp_id}/{emp_code}/{duty_start_date}/{duty_end_date}', 'Api\V1\Leave\EmpAcademicHolidayDutyController@remove')
                ->name('remove');
        });

        // TypeInfoController
        Route::group(['name' => 'type-info.'], function() {
            // v1/admin/leave-setup/type-infos
            Route::get('/type-infos', 'Api\V1\Admin\LeaveSetup\TypeInfoController@index')->name('index');
            Route::get('/type-infos/{id}', 'Api\V1\Admin\LeaveSetup\TypeInfoController@view')->name('view');
            Route::get('/type-infos-fetch/{id}', 'Api\V1\Admin\LeaveSetup\TypeInfoController@fetch')->name('fetch');
            Route::post('/type-infos', 'Api\V1\Admin\LeaveSetup\TypeInfoController@store')->name('store');
            Route::put('/type-infos/{id}', 'Api\V1\Admin\LeaveSetup\TypeInfoController@update')->name('update');
            Route::delete('/type-infos/{id}', 'Api\V1\Admin\LeaveSetup\TypeInfoController@remove')->name('remove');
        });

        // WorkDayController
        Route::group(['name' => 'work-day.'], function() {
            // v1/admin/leave-setup/work-days
            Route::get('/work-days', 'Api\V1\Admin\LeaveSetup\WorkDayController@index')->name('index');
            Route::get('/work-days/{id}', 'Api\V1\Admin\LeaveSetup\WorkDayController@view')->name('view');
            Route::get('/work-days-fetch/{id}', 'Api\V1\Admin\LeaveSetup\WorkDayController@fetch')->name('fetch');
            Route::post('/work-days', 'Api\V1\Admin\LeaveSetup\WorkDayController@store')->name('store');
            Route::put('/work-days/{id}', 'Api\V1\Admin\LeaveSetup\WorkDayController@update')->name('update');
            Route::delete('/work-days/{id}', 'Api\V1\Admin\LeaveSetup\WorkDayController@remove')->name('remove');
        });

        Route::group(['name' => 'applicable-employee-type.'], function() {
            // v1/admin/leave-setup/applicable-employee-types
            Route::get('/applicable-employee-types', 'Api\V1\Admin\LeaveSetup\ApplicableEmployeeTypeController@index')->name('index');
            Route::get('/applicable-employee-types-dropdown', 'Api\V1\Admin\LeaveSetup\ApplicableEmployeeTypeController@dropdown')->name('dropdown');
        });

        Route::group(['name' => 'applicable-gender.'], function() {
            // v1/admin/leave-setup/applicable-genders
            Route::get('/applicable-genders', 'Api\V1\Admin\LeaveSetup\ApplicableGenderController@index')->name('index');
            Route::get('/applicable-genders-dropdown', 'Api\V1\Admin\LeaveSetup\ApplicableGenderController@dropdown')->name('dropdown');
        });

        Route::group(['name' => 'work-day-status.'], function() {
            // v1/admin/leave-setup/work-day-statuses
            Route::get('/work-day-statuses', 'Api\V1\Admin\LeaveSetup\WorkDayStatusController@index')->name('index');
            Route::get('/work-day-statuses-dropdown', 'Api\V1\Admin\LeaveSetup\WorkDayStatusController@dropdown')->name('dropdown');
        });

        Route::group(['name' => 'holiday-type.'], function() {
            // v1/admin/leave-setup/holiday-types
            Route::get('/holiday-types', 'Api\V1\Admin\LeaveSetup\HolidayTypeController@index')->name('index');
            Route::get('/holiday-types-dropdown', 'Api\V1\Admin\LeaveSetup\HolidayTypeController@dropdown')->name('dropdown');
        });

        Route::group(['name' => 'holiday-status.'], function() {
            // v1/admin/leave-setup/holiday-statuses
            Route::get('/holiday-statuses', 'Api\V1\Admin\LeaveSetup\HolidayStatusController@index')->name('index');
            Route::get('/holiday-statuses-dropdown', 'Api\V1\Admin\LeaveSetup\HolidayStatusController@dropdown')->name('dropdown');
        });
    });

    // Location setup
    Route::group(['prefix' => 'location-setup', 'name' => 'location-setup.'], function() {

        // DistrictController
        Route::group(['name' => 'district.'], function() {
            // v1/admin/location-setup/districts
            Route::get('/districts', 'Api\V1\Admin\LocationSetup\DistrictController@index')->name('index');
            Route::get('/all-districts', 'Api\V1\Admin\LocationSetup\DistrictController@all_districts')->name('all_districts');
            Route::get('/districts/{divisionId}', 'Api\V1\Admin\LocationSetup\DistrictController@dropdown')->name('dropdown');
            Route::get('/districts/{id}', 'Api\V1\Admin\LocationSetup\DistrictController@view')->name('view');
            Route::post('/districts', 'Api\V1\Admin\LocationSetup\DistrictController@store')->name('store');
            Route::put('/districts/{id}', 'Api\V1\Admin\LocationSetup\DistrictController@update')->name('update');
            Route::delete('/districts/{id}', 'Api\V1\Admin\LocationSetup\DistrictController@remove')->name('remove');
        });

        // DivisionController
        Route::group(['name' => 'division.'], function() {
            // v1/admin/location-setup/divisions
            Route::get('/divisions', 'Api\V1\Admin\LocationSetup\DivisionController@index')->name('index');
            Route::get('/divisions-dropdown', 'Api\V1\Admin\LocationSetup\DivisionController@dropdown')->name('dropdown');
            Route::get('/divisions/{id}', 'Api\V1\Admin\LocationSetup\DivisionController@view')->name('view');
            Route::post('/divisions', 'Api\V1\Admin\LocationSetup\DivisionController@store')->name('store');
            Route::put('/divisions/{id}', 'Api\V1\Admin\LocationSetup\DivisionController@update')->name('update');
            Route::delete('/divisions/{id}', 'Api\V1\Admin\LocationSetup\DivisionController@remove')->name('remove');
        });

        // ThanaController
        Route::group(['name' => 'thana.'], function() {
            // v1/admin/location-setup/thanas
            Route::get('/thanas', 'Api\V1\Admin\LocationSetup\ThanaController@index')->name('index');
            Route::get('/thanas/{id}', 'Api\V1\Admin\LocationSetup\ThanaController@view')->name('view');
            Route::post('/thanas', 'Api\V1\Admin\LocationSetup\ThanaController@store')->name('store');
            Route::put('/thanas/{id}', 'Api\V1\Admin\LocationSetup\ThanaController@update')->name('update');
            Route::delete('/thanas/{id}', 'Api\V1\Admin\LocationSetup\ThanaController@remove')->name('remove');
        });
    });

    // Salary setup
    Route::group(['prefix' => 'salary-setup', 'name' => 'salary-setup.'], function() {

        // EmployeeSalaryController
        Route::group(['name' => 'employee-salary.'], function() {
            // v1/admin/salary-setup/employee-salaries
            Route::get('/employee-salaries', 'Api\V1\Admin\SalarySetup\EmployeeSalaryController@index')->name('index');
            Route::get('/employee-salaries/{id}', 'Api\V1\Admin\SalarySetup\EmployeeSalaryController@view')->name('view');
            Route::post('/employee-salaries', 'Api\V1\Admin\SalarySetup\EmployeeSalaryController@store')->name('store');
            Route::put('/employee-salaries/{id}', 'Api\V1\Admin\SalarySetup\EmployeeSalaryController@update')->name('update');
            Route::delete('/employee-salaries/{id}', 'Api\V1\Admin\SalarySetup\EmployeeSalaryController@remove')->name('remove');
        });

        // HeadSetupController
        Route::group(['name' => 'head-setup.'], function() {
            // v1/admin/salary-setup/head-setups
            Route::get('/head-setups', 'Api\V1\Admin\SalarySetup\HeadSetupController@index')->name('index');
            Route::get('/head-setups/{id}', 'Api\V1\Admin\SalarySetup\HeadSetupController@view')->name('view');
            Route::post('/head-setups', 'Api\V1\Admin\SalarySetup\HeadSetupController@store')->name('store');
            Route::put('/head-setups/{id}', 'Api\V1\Admin\SalarySetup\HeadSetupController@update')->name('update');
            Route::delete('/head-setups/{id}', 'Api\V1\Admin\SalarySetup\HeadSetupController@remove')->name('remove');
        });
    });
});

//Application service module
Route::group(['prefix' => 'application-service', 'name' => 'application-service.'], function () {

    // PfApplicationController
    Route::group(['name' => 'pf-application.'], function() {
        // v1/application-service/pf-applications
        Route::get('/pf-applications', 'Api\V1\ApplicationService\PfApplicationController@index')->name('index');
        Route::get('/pf-applications/{id}', 'Api\V1\ApplicationService\PfApplicationController@view')->name('view');
        Route::post('/pf-applications', 'Api\V1\ApplicationService\PfApplicationController@store')->name('store');
        Route::put('/pf-applications/{id}', 'Api\V1\ApplicationService\PfApplicationController@update')->name('update');
        Route::delete('/pf-applications/{id}', 'Api\V1\ApplicationService\PfApplicationController@remove')->name('remove');
    });

    // CpfGfApplicationController
    Route::group(['name' => 'cpf-gf-application.'], function() {
        // v1/application-service/cpf-gf-application
        Route::get('/cpf-gf-applications', 'Api\V1\ApplicationService\CpfGfApplicationController@index')->name('index');
        Route::get('/cpf-gf-applications/{id}', 'Api\V1\ApplicationService\CpfGfApplicationController@view')->name('view');
        Route::post('/cpf-gf-applications', 'Api\V1\ApplicationService\CpfGfApplicationController@store')->name('store');
        Route::put('/cpf-gf-applications/{id}', 'Api\V1\ApplicationService\CpfGfApplicationController@update')->name('update');
        Route::delete('/cpf-gf-applications/{id}', 'Api\V1\ApplicationService\CpfGfApplicationController@remove')->name('remove');
    });

    // LeaveApplicationController
    Route::group(['name' => 'leave-application.'], function() {
        // v1/application-service/leave-application
        Route::get('/leave-applications', 'Api\V1\ApplicationService\LeaveApplicationController@index')->name('index');
        Route::get('/leave-applications/{id}', 'Api\V1\ApplicationService\LeaveApplicationController@view')->name('view');
        Route::post('/leave-applications', 'Api\V1\ApplicationService\LeaveApplicationController@store')->name('store');
        Route::put('/leave-applications/{id}', 'Api\V1\ApplicationService\LeaveApplicationController@update')->name('update');
        Route::delete('/leave-applications/{id}', 'Api\V1\ApplicationService\LeaveApplicationController@remove')->name('remove');
    });

    // LeaveApplicationController
    Route::group(['name' => 'leave-application.'], function() {
        // v1/application-service/leave-application
        Route::get('/leave-applications', 'Api\V1\ApplicationService\LeaveApplicationController@index')->name('index');
        Route::get('/leave-applications/{id}', 'Api\V1\ApplicationService\LeaveApplicationController@view')->name('view');
        Route::post('/leave-applications', 'Api\V1\ApplicationService\LeaveApplicationController@store')->name('store');
        Route::put('/leave-applications/{id}', 'Api\V1\ApplicationService\LeaveApplicationController@update')->name('update');
        Route::delete('/leave-applications/{id}', 'Api\V1\ApplicationService\LeaveApplicationController@remove')->name('remove');
    });

});

//Overtime module
Route::group(['prefix' => 'overtime', 'name' => 'overtime.'], function () {

    Route::get('/report-parameters', 'Api\V1\Report\OvertimeParameterController@index')->name('index');
    Route::get('/section-by-department/{id}', 'Api\V1\Overtime\OtMonthsDetailsController@sectionByDepartment')->name('section-by-department');
    Route::get('/ot-disbursement', 'Api\V1\Overtime\OtRegisterController@disbursement')->name('disbursement');
    Route::post('/ot-disbursement', 'Api\V1\Overtime\OtRegisterController@disbursementStore')->name('disbursement-store');
    // OtRegisterController
    Route::group(['name' => 'ot-months-details.'], function() {
        // v1/overtime/ot-months-detail
        Route::get('/ot-months-detail', 'Api\V1\Overtime\OtMonthsDetailsController@index')->name('index');
        //Route::get('/ot-months-detail/{id}', 'Api\V1\Overtime\OtMonthsDetailsController@view')->name('view');
        Route::post('/ot-months-detail', 'Api\V1\Overtime\OtMonthsDetailsController@store')->name('store');
        // Route::get('/ot-months-detail/preload-data', 'Api\V1\Overtime\OtMonthsDetailsController@index')->name('getPreloadInfo');
        //Route::post('/ot-months-detail/update/{id}','Api\V1\Overtime\OtMonthsDetailsController@update')->name('update');
        Route::post('/ot-months-detail/search_result', 'Api\V1\Overtime\OtMonthsDetailsController@search_result')->name('search_result');
        //Route::get('/ot-months-detail/load_ot_tmp_data', 'Api\V1\Overtime\OtMonthsDetailsController@load_ot_tmp_data')->name('load_ot_tmp_data');
        // Route::post('/ot-months-detail/calculate-ot-date', 'Api\V1\Overtime\OtMonthsDetailsController@calculate_ot_date')->name('calculate_ot_date');
        Route::get('/ot-months-detail/remove/{id}', 'Api\V1\Overtime\OtMonthsDetailsController@remove')->name('remove');
    });

    // OtRegisterController
    Route::group(['name' => 'ot-register.'], function() {
        // v1/overtime/ot-registers
        Route::get('/ot-registers', 'Api\V1\Overtime\OtRegisterController@index')->name('index');
        //Route::get('/ot-registers/{id}', 'Api\V1\Overtime\OtRegisterController@view')->name('view');
        Route::post('/ot-registers', 'Api\V1\Overtime\OtRegisterController@store')->name('store');
        Route::get('/ot-registers/emp-info-unregistered/{id}', 'Api\V1\Overtime\OtRegisterController@getUnRegisteredEmpInfo')->name('getUnRegisteredEmpInfo');
        Route::get('/ot-registers/emp-info-registered/{id}', 'Api\V1\Overtime\OtRegisterController@getRegisteredEmpInfo')->name('getRegisteredEmpInfo');
        Route::get('/ot-registers/emp-otslab-used-unused-info/{id}', 'Api\V1\Overtime\OtRegisterController@getUsedUnUsedSlab')->name('getUsedUnUsedSlab');
        Route::get('/ot-registers/preload-data', 'Api\V1\Overtime\OtRegisterController@index')->name('getPreloadInfo');
        Route::post('/ot-registers/update/{id}','Api\V1\Overtime\OtRegisterController@update')->name('update');
        Route::post('/ot-registers/search_result', 'Api\V1\Overtime\OtRegisterController@search_result')->name('search_result');
        Route::get('/ot-date-from-group/{id}', 'Api\V1\Overtime\OtRegisterController@otDateFromGroup')->name('ot-date-from-group');
        //Route::get('/ot-registers/load_ot_tmp_data', 'Api\V1\Overtime\OtRegisterController@load_ot_tmp_data')->name('load_ot_tmp_data');
        Route::post('/ot-registers/calculate-ot-date', 'Api\V1\Overtime\OtRegisterController@calculate_ot_date')->name('calculate_ot_date');
        Route::delete('/ot-registers/{id}', 'Api\V1\Overtime\OtRegisterController@remove')->name('remove');
        Route::get('/ot-registers-details/{id}', 'Api\V1\Overtime\OtRegisterController@view')->name('view');
        Route::post('/ot-registers-details-update', 'Api\V1\Overtime\OtRegisterController@ot_registers_details_update')->name('ot_registers_details_update');
        Route::post('/ot-registers/calculate-ot-datetime-diff', 'Api\V1\Overtime\OtRegisterController@calculate_ot_datetime_diff')->name('calculate_ot_datetime_diff');
    });

    // OtGroupRegisterController
    Route::group(['name' => 'ot-register-group.'], function() {
        // v1/overtime/ot-registers
        Route::get('/ot-register-booking-groups', 'Api\V1\Overtime\OtGroupRegisterController@otRosterGroups')->name('ot-booking-groups');
        Route::post('/ot-group-registers', 'Api\V1\Overtime\OtGroupRegisterController@store')->name('store');

    });

    // OtProcessController
    Route::group(['name' => 'ot-process.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-processes', 'Api\V1\Overtime\OtProcessController@index')->name('index');
        Route::get('/ot-processes/{id}', 'Api\V1\Overtime\OtProcessController@view')->name('view');
        Route::post('/ot-processes', 'Api\V1\Overtime\OtProcessController@store')->name('store');
        Route::get('/ot-processes/emp-info/{id}', 'Api\V1\Overtime\OtProcessController@getEmpInfo')->name('getEmpInfo');
        Route::post('/ot-processes/search_result', 'Api\V1\Overtime\OtProcessController@search_result')->name('search_result');
       // Route::post('/ot-processes/send_to_ot_process', 'Api\V1\Overtime\OtProcessController@send_to_ot_process')->name('send_to_ot_process');
        Route::put('/ot-processes/{id}', 'Api\V1\Overtime\OtProcessController@update')->name('update');
        Route::delete('/ot-processes/{id}', 'Api\V1\Overtime\OtProcessController@remove')->name('remove');
    });

    // OtProcessApprovalController
    Route::group(['name' => 'ot-process-approvals.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-process-approval', 'Api\V1\Overtime\OtProcessApprovalController@index')->name('index');
        Route::post('/ot-process-approval/search_result', 'Api\V1\Overtime\OtProcessApprovalController@search_result')->name('search_result');
        Route::post('/ot-process-approval/search_result_report', 'Api\V1\Overtime\OtProcessApprovalController@search_result_report')->name('search_result_report');
        //Route::get('/ot-process-approval/{id}', 'Api\V1\Overtime\OtProcessApprovalController@view')->name('view');
        Route::post('/ot-process-approval', 'Api\V1\Overtime\OtProcessApprovalController@store')->name('store');
    });

    // OtApprovalController
    Route::group(['name' => 'ot-approval.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-approvals', 'Api\V1\Overtime\OtApprovalController@index')->name('index');
        Route::get('/ot-approvals/emp-info/{id}', 'Api\V1\Overtime\OtApprovalController@getEmpInfo')->name('getEmpInfo');
        Route::get('/ot-approvals/{id}', 'Api\V1\Overtime\OtApprovalController@view')->name('view');
        Route::get('/ot-get-group/{department}/{month}/{section}', 'Api\V1\Overtime\OtApprovalController@getGroupByMonth')->name('view');
        Route::post('/ot-approvals', 'Api\V1\Overtime\OtApprovalController@store')->name('store');
        Route::post('/ot-approvals/search', 'Api\V1\Overtime\OtApprovalController@search')->name('search');
        Route::put('/ot-approvals/{id}', 'Api\V1\Overtime\OtApprovalController@update')->name('update');
        Route::delete('/ot-approvals/{id}', 'Api\V1\Overtime\OtApprovalController@remove')->name('remove');
    });

    // OtActualSetupController
    Route::group(['name' => 'ot-approval.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-actuals', 'Api\V1\Overtime\OtActualSetupController@index')->name('index');
        Route::get('/ot-actuals/emp-info/{id}/{dptId}', 'Api\V1\Overtime\OtActualSetupController@getEmpInfo')->name('getEmpInfo');
        Route::post('/ot-actuals-status', 'Api\V1\Overtime\OtActualSetupController@updateOtActualStatus')->name('updateOtActualStatus');
        Route::post('/ot-actuals', 'Api\V1\Overtime\OtActualSetupController@store')->name('store');
        Route::post('/ot-actuals/search', 'Api\V1\Overtime\OtActualSetupController@search')->name('search');
        Route::get('/ot-actuals/{id}', 'Api\V1\Overtime\OtActualSetupController@getActualOvertimeEmployeeInfo')->name('getActualOvertimeEmployeeInfo');
        Route::get('/ot-actual-time-slab/{id}', 'Api\V1\Overtime\OtActualSetupController@getActualTimeSlab')->name('getActualTimeSlab');
    });

    // OtIrregularController
    Route::group(['name' => 'ot-irregular.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-irregulars', 'Api\V1\Overtime\OtIrregularController@index')->name('index');
        Route::get('/ot-irregulars/emp-info/{id}/{dptId}', 'Api\V1\Overtime\OtIrregularController@getEmpInfo')->name('getEmpInfo');
        Route::get('/ot-irregulars/{id}/{dpt_id}', 'Api\V1\Overtime\OtIrregularController@getOTMontSlab')->name('getOTMontSlab');
        Route::post('/ot-irregulars', 'Api\V1\Overtime\OtIrregularController@store')->name('store');
        Route::post('/ot-irregulars/search', 'Api\V1\Overtime\OtIrregularController@search')->name('search');
    });

    // OtRosterMonthSetupController
    Route::group(['name' => 'ot-roster-month.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-roster-months', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@index')->name('index');
        Route::get('/ot-lastyearmonths', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@getNextOTYearMonth')->name('getNextOTYearMonth');
        Route::get('/roster-years', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@getRosterYears')->name('getRosterYears');
        Route::get('/ot-roster-month/{id}', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@view')->name('view');
        Route::post('/ot-roster-month', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@store')->name('store');
        Route::post('/ot-roster-month-closed', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@otMonthClosed')->name('otMonthClosed');
        Route::post('/ot-roster-month/{id}', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@update')->name('update');
        Route::post('/search-roster-months', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@search')->name('search');
        Route::delete('/ot-roster-month/{id}', 'Api\V1\Overtime\Setup\OtRosterMonthSetupController@remove')->name('remove');
    });
    // Employee Ot Rule
    Route::group(['name' => 'employee-ot-rule.'], function() {
        Route::get('/employee-ot-rule', 'Api\V1\Overtime\Setup\EmpOtRuleController@index')->name('index');
        Route::post('/employee-ot-rule', 'Api\V1\Overtime\Setup\EmpOtRuleController@store')->name('store');
        Route::post('/employee-ot-rule/search-ot-emp', 'Api\V1\Overtime\Setup\EmpOtRuleController@searchResult')->name('search-ot-emp');
        Route::post('/employee-ot-rule/search-ot-rule', 'Api\V1\Overtime\Setup\EmpOtRuleController@searchRuleResult')->name('search-ot-rule');
        Route::get('/employee-ot-rule/{id}', 'Api\V1\Overtime\Setup\EmpOtRuleController@view')->name('view');
        Route::post('/employee-ot-rule/details', 'Api\V1\Overtime\Setup\EmpOtRuleController@ruleDetails')->name('view');

        //OT Rule
        Route::get('/ot-rule-list', 'Api\V1\Overtime\Setup\OtRuleController@index')->name('ot-rule-list');
        Route::post('/ot-rule-add', 'Api\V1\Overtime\Setup\OtRuleController@store')->name('ot-rule-add');
        Route::get('/ot-rule-delete/{id}', 'Api\V1\Overtime\Setup\OtRuleController@remove')->name('ot-rule-delete');
        Route::get('/ot-rule-details/{id}', 'Api\V1\Overtime\Setup\OtRuleController@editOt')->name('ot-rule-details');

    });
    // OtRosterGroupController
    Route::group(['name' => 'ot-roster-group.'], function() {
        // v1/overtime/ot-roster-group
        Route::get('/ot-roster-group', 'Api\V1\Overtime\Setup\OtRosterGroupController@index')->name('index');
        Route::get('/ot-roster-group/emp-info/{id}/{dptId}', 'Api\V1\Overtime\Setup\OtRosterGroupController@getEmpInfo')->name('getEmpInfo');
        Route::get('/ot-roster-group/{id}', 'Api\V1\Overtime\Setup\OtRosterGroupController@view')->name('view');
        Route::get('/ot-roster-group/find-group-by-months/{id}', 'Api\V1\Overtime\Setup\OtRosterGroupController@findGroupByMonths')->name('find-group-by-months');
        Route::post('/ot-roster-group/details', 'Api\V1\Overtime\Setup\OtRosterGroupController@groupDetails')->name('view');
        Route::post('/ot-previous-group', 'Api\V1\Overtime\Setup\OtRosterGroupController@previousGroupData')->name('ot-previous-group');
        Route::post('/ot-roster-group', 'Api\V1\Overtime\Setup\OtRosterGroupController@store')->name('store');
        Route::post('/ot-roster-group-approval', 'Api\V1\Overtime\Setup\OtRosterGroupController@storeApproval')->name('storeApproval');
        Route::post('/ot-roster-group/search', 'Api\V1\Overtime\Setup\OtRosterGroupController@searchResult')->name('search');
        Route::post('/ot-roster-group/search-with-group-section', 'Api\V1\Overtime\Setup\OtRosterGroupController@searchWithGroupSectionResult')->name('searchWithGroupSectionResult');
        Route::post('/ot-roster-group/search-group', 'Api\V1\Overtime\Setup\OtRosterGroupController@searchGroupResult')->name('search-group');
        Route::put('/ot-roster-group/{id}', 'Api\V1\Overtime\Setup\OtRosterGroupController@update')->name('update');
        Route::delete('/ot-roster-group/{id}/{empId}', 'Api\V1\Overtime\Setup\OtRosterGroupController@remove')->name('remove');
    });

    // OtRosterDetailController
    Route::group(['name' => 'ot-roster-details.'], function() {
        // v1/overtime/ot-processes
        Route::get('/ot-roster-details', 'Api\V1\Overtime\Setup\OtRosterDetailController@index')->name('index');
        Route::get('/ot-roster-details/ot-roster-groups', 'Api\V1\Overtime\Setup\OtRosterDetailController@otRosterGroups')->name('ot-roster-groups');
        Route::get('/ot-booking-groups', 'Api\V1\Overtime\Setup\OtRosterGroupController@otRosterGroups')->name('ot-booking-groups');
        Route::get('/ot-roster-details/find-groups/{monthId}/{departmentId}/{sectionId}', 'Api\V1\Overtime\Setup\OtRosterDetailController@findGroups')->name('find-groups');
        Route::get('/ot-roster-details/find-groups/{departmentId}', 'Api\V1\Overtime\Setup\OtRosterDetailController@findGroupsDeptChange')->name('find-groups-dept-change');
        Route::get('/ot-roster-details/{id}', 'Api\V1\Overtime\Setup\OtRosterDetailController@view')->name('view');
        Route::post('/ot-roster-details', 'Api\V1\Overtime\Setup\OtRosterDetailController@store')->name('store');
        Route::post('/ot-roster-details/{id}', 'Api\V1\Overtime\Setup\OtRosterDetailController@update')->name('update');
        Route::delete('/ot-roster-details/{id}', 'Api\V1\Overtime\Setup\OtRosterDetailController@remove')->name('remove');
        Route::get('/ot-roster-details/employee/{monthId}/{empId}', 'Api\V1\Overtime\Setup\OtRosterDetailController@findEmpDetails')->name('find-emp-details');
        Route::put('/ot-roster-details/update', 'Api\V1\Overtime\Setup\OtRosterDetailController@updateEmpDetails')->name('change-emp-details');
    });
});

//ProvidentFund module
Route::group(['prefix' => 'providentFund', 'name' => 'providentFund.'], function () {

    Route::get('/report-parameters', 'Api\V1\Report\ProvidentFundParameterController@index')->name('report');
    // PfContributionUpdate
    Route::group(['name' => 'providentFund.'], function() {
        // v1/ProvidentFund/PfContributionUpdate
        Route::get('/form-data', 'Api\V1\ProvidentFund\Application\PfContribution@formData')->name('form-data');
        Route::post('/employees/add', 'Api\V1\ProvidentFund\Application\PfContribution@addNew')->name('add-new');
        Route::post('/search-pf-employees', 'Api\V1\ProvidentFund\Application\PfContribution@searchPfEmployees')->name('searchPfEmployees');
        Route::put('/update-workflow-id/{id}', 'Api\V1\ProvidentFund\Application\PfContribution@updateWorkflowId')->name('updateWorkflowId');
        Route::put('/update-loan-workflow/{id}', 'Api\V1\ProvidentFund\Application\PfContribution@updateLoanWorkflow')->name('updateLoanWorkflow');
        Route::put('/update-settlement-workflow/{id}', 'Api\V1\ProvidentFund\Application\PfContribution@updateSettlementWorkflow')->name('updateSettlementWorkflow');
        Route::get('/pf-employees/emp-info/{id}', 'Api\V1\ProvidentFund\Application\PfContribution@getEmpInfo')->name('getEmpInfo');
        Route::get('/pf-opening/{id}', 'Api\V1\ProvidentFund\Application\PfContribution@getPfOpeningEmployeeInfo')->name('getPfOpeningEmployeeInfo');
        Route::post('/pf-store', 'Api\V1\ProvidentFund\Application\PfContribution@store')->name('store');
        Route::get('/pf-employees/{id}/{option}', 'Api\V1\ProvidentFund\Application\PfContribution@employee')->name('employee');
        Route::get('/pf-employee-self/{id}/{option}', 'Api\V1\ProvidentFund\Application\PfContribution@employeeSelf')->name('employeeSelf');
        Route::get('/search-employees/{id}/{dpt}', 'Api\V1\ProvidentFund\Application\PfContribution@searchEmployee')->name('search_employee');
        Route::get('/search-employees-dpt/{id}/{dpt}', 'Api\V1\ProvidentFund\Application\PfContribution@searchEmployeeDpt')->name('search_employee_dpt');
        Route::get('/non-pf-employees/{search}', 'Api\V1\ProvidentFund\Application\PfContribution@nonEmployee')->name('non-employee');
        Route::get('/gpf/employees/{search}', 'Api\V1\ProvidentFund\Application\PfContribution@gpfEmployees')->name('gpf-employees');
        Route::get('/gpf/settlement/employees', 'Api\V1\ProvidentFund\Application\PfContribution@getGpfSettlementData')->name('gpf-settlement-employees');
        Route::post('/gpf/settlement', 'Api\V1\ProvidentFund\Application\PfContribution@storeGpfSettlement')->name('store-gpf-settlement');
        Route::post('/gpf/employees/search', 'Api\V1\ProvidentFund\Application\PfContribution@gpfSearch')->name('gpf-search');
        Route::post('/gpf/statement/{empId}/{date}', 'Api\V1\ProvidentFund\Application\PfContribution@statementList')->name('gpf-statement');
        Route::post('/application/pf-with-draw', 'Api\V1\ProvidentFund\Application\PfWithdraw@store')->name('store');
        Route::get('/gpf/settlement/emp/{param}', 'Api\V1\ProvidentFund\Application\PfWithdraw@searchEmployees')->name('get-emp');
        Route::get('/gpf/settlement/emp-self/{param}', 'Api\V1\ProvidentFund\Application\PfWithdraw@searchEmployeesSelf')->name('get-emp-self');
        Route::get('/application/pf-with-draw-list', 'Api\V1\ProvidentFund\Application\PfWithdraw@get')->name('get');
        Route::get('/application/pf-with-draw-list/self', 'Api\V1\ProvidentFund\Application\PfWithdraw@getSelf')->name('get-self');
        Route::put('/application/pf-with-draw-update', 'Api\V1\ProvidentFund\Application\PfWithdraw@put')->name('put');
        Route::post('/pf/interest-store', 'Api\V1\ProvidentFund\Application\PfInterestRate@store')->name('store');
        Route::get('/pf/interest-list', 'Api\V1\ProvidentFund\Application\PfInterestRate@get')->name('get');
        Route::put('/pf/interest-update', 'Api\V1\ProvidentFund\Application\PfInterestRate@put')->name('put');
    });

});


//Payroll module
Route::group(['prefix' => 'payroll', 'name' => 'payroll.'], function () {

    // SallerySetupController
    Route::group(['payroll' => 'salary-setup.'], function() {
        // v1/payroll/salary-setup
        Route::get('/allowance-types', 'Api\V1\Payroll\OtherAllowanceController@otherAllowanceTypeList')->name('allowance-types');
        Route::get('/allowance-list', 'Api\V1\Payroll\OtherAllowanceController@allowanceList')->name('allowance-list');
        Route::post('/allowance-add', 'Api\V1\Payroll\OtherAllowanceController@store')->name('allowance-add');
        Route::post('/allowance-approve', 'Api\V1\Payroll\OtherAllowanceController@approve')->name('allowance-approve');
        Route::post('/allowance-hold', 'Api\V1\Payroll\OtherAllowanceController@hold')->name('allowance-hold');
        Route::post('/allowance-disburse', 'Api\V1\Payroll\OtherAllowanceController@disburse')->name('allowance-disburse');


        Route::get('/bonus-setup', 'Api\V1\Payroll\BonusSetupController@index')->name('bonus-index');
        Route::post('/bonus-setup-store', 'Api\V1\Payroll\BonusSetupController@store')->name('bonus-store');

        Route::get('/salary-setup', 'Api\V1\Payroll\SallerySetupController@index')->name('index');
        Route::get('/year-list', 'Api\V1\Payroll\SallerySetupController@yearList')->name('yearList');
        Route::get('/salary-setup/months/{year}', 'Api\V1\Payroll\SallerySetupController@months')->name('months');
        Route::get('/salary-setup/months-by-year-id/{year}', 'Api\V1\Payroll\SallerySetupController@monthsByYearId')->name('monthsByYearId');
        Route::get('/salary-setup/year/{id}', 'Api\V1\Payroll\SallerySetupController@getMonthsById')->name('months');
        Route::get('/bonus-setup/year/{id}', 'Api\V1\Payroll\SallerySetupController@getBonusMonthsById')->name('bonus-months');
        Route::get('/depu-bonus-setup/year/{id}', 'Api\V1\Payroll\SallerySetupController@getDepuBonusMonthsById')->name('depu-bonus-setup');
        Route::get('/salary-setup/{id}', 'Api\V1\Payroll\SallerySetupController@noMonthSalaryHead')->name('view');
        Route::post('/salary-setup', 'Api\V1\Payroll\SallerySetupController@store')->name('store');
        Route::put('/salary-setup/{id}', 'Api\V1\Payroll\SallerySetupController@update')->name('update');
        Route::delete('/salary-setup/{id}/{month_id}', 'Api\V1\Payroll\SallerySetupController@remove')->name('remove');
        Route::get('/salary-setup/bill-codes/{yid}/{mid}', 'Api\V1\Payroll\SallerySetupController@getBillCodes')->name('bill-codes');
        Route::get('/bonus-setup/bill-codes/{yid}/{mid}', 'Api\V1\Payroll\SallerySetupController@getBonusBillCodes')->name('bonus-bill-codes');
        Route::get('/depu-bonus-setup/bill-codes/{yid}/{mid}', 'Api\V1\Payroll\SallerySetupController@getDepuBonusBillCodes')->name('depu-bonus-bill-codes');
    });
    //salaryProcessUpdate controller
    Route::group(['name' => 'arrear-bill.'], function() {
        Route::get('/search-employee/{name}', 'Api\V1\Payroll\ArrearBillController@searchEmployee')->name('search-employee');
        Route::get('/search-employees-dpt/{dpt}/{id}', 'Api\V1\Payroll\ArrearBillController@searchEmployeeDpt')->name('search_employee_dpt');
        Route::get('/search-all-employees/{emp_code}', 'Api\V1\Payroll\ArrearBillController@searchAllEmployee')->name('search_all_employees');
        Route::get('/bill-status-list', 'Api\V1\Payroll\ArrearBillController@billStatusList')->name('bill-status-list');
        Route::post('/arrear-details-list', 'Api\V1\Payroll\ArrearBillController@arrearDetailsList')->name('arrear-details-list');
        Route::get('/bill-type-list', 'Api\V1\Payroll\ArrearBillController@billTypeList')->name('bill-type-list');
        Route::get('/bill-head-list', 'Api\V1\Payroll\ArrearBillController@billHeadList')->name('bill-head-list');
        Route::get('/fy-list', 'Api\V1\Payroll\ArrearBillController@fyList')->name('fy-list');
        Route::get('/pr-month-list/{id}', 'Api\V1\Payroll\ArrearBillController@prMonthList')->name('pr-month-list');
        Route::get('/arrear-master-by-bill-no/{id}', 'Api\V1\Payroll\ArrearBillController@arrearMasterByBillNo')->name('arrear-master-by-bill-no');
        Route::get('/get-pr-month-id/{fyId}/{monthId}', 'Api\V1\Payroll\ArrearBillController@getPrMonthId')->name('get-pr-month-id');
        Route::post('/arrear-bill', 'Api\V1\Payroll\ArrearBillController@store')->name('arrear-bill');
        Route::post('/update-process-id', 'Api\V1\Payroll\ArrearBillController@updateProcessId')->name('updateProcessId');
    });

    Route::group(['name' => 'arrear-bill-settlement.'], function() {
        Route::post('/arrear-details-list-settlement', 'Api\V1\Payroll\ArrearBillSettlementController@arrearDetailsList')->name('arrear-details-list-settlement');
        Route::post('/add-bill-details', 'Api\V1\Payroll\ArrearBillSettlementController@addBillDetails')->name('add-bill-details');
        Route::put('/update-bill-details', 'Api\V1\Payroll\ArrearBillSettlementController@updateBillDetails')->name('update-bill-details');
        Route::delete('/delete-bill-details/{id}', 'Api\V1\Payroll\ArrearBillSettlementController@deleteBillDetails')->name('delete-bill-details');
        Route::get('/get-fiscal-years', 'Api\V1\Payroll\ArrearBillSettlementController@getFiscalYears')->name('get-fiscal-years');
        Route::get('/get-active-fiscal-years', 'Api\V1\Payroll\ArrearBillSettlementController@getActiveFiscalYears')->name('get-active-fiscal-years');
        Route::get('/get-pr-months/{fy_id}', 'Api\V1\Payroll\ArrearBillSettlementController@getPrMonths')->name('get-pr-months');
        Route::get('/get-active-pr-months/{fy_id}', 'Api\V1\Payroll\ArrearBillSettlementController@getActivePrMonths')->name('get-active-pr-months');
        Route::get('/active-pr-months/{fy_id}', 'Api\V1\Payroll\ArrearBillSettlementController@activePrMonths')->name('active-pr-months');
        Route::get('/get-bill-codes/{pr_month_id}', 'Api\V1\Payroll\ArrearBillSettlementController@getBillCodes')->name('get-bill-codes');
        Route::get('/get-workflow-steps/{approval_workflow_id}', 'Api\V1\Payroll\ArrearBillSettlementController@getWorkFlowSteps')->name('get-workflow-steps');
    });

    Route::group(['name' => 'salary-process-update.'], function() {
        Route::post('/search', 'Api\V1\Payroll\SalaryProcessUpdateController@search')->name('search');
        Route::get('/salary-process-update', 'Api\V1\Payroll\SalaryProcessUpdateController@index')->name('index');
    });

    //salaryProcess controller
    Route::group(['name' => 'salary-process.'], function() {
        Route::get('/salary-process', 'Api\V1\Payroll\SalaryProcessController@index')->name('salary-process-form-data');
        Route::post('/salary-process', 'Api\V1\Payroll\SalaryProcessController@process')->name('salary-process');
        Route::post('/salary-heads', 'Api\V1\Payroll\SalaryProcessController@payrollHeads')->name('salary-heads');
        Route::put('/salary-process/heads', 'Api\V1\Payroll\SalaryProcessController@payrollHeadsUpdate')->name('salary-heads-update');
        Route::post('/salary-process/heads', 'Api\V1\Payroll\SalaryProcessController@deletePayrollHead')->name('salary-heads-delete');
        Route::post('/monthly-process', 'Api\V1\Payroll\SalaryProcessController@monthlyProcess')->name('monthly.process');
        Route::put('/salary-process/{id}', 'Api\V1\Payroll\SalaryProcessController@update')->name('salary-process-update');
        Route::get('/salaries/{fiscalYear}/{fYear}/{prMonth}', 'Api\V1\Payroll\SalaryProcessController@list')->name('salary-list');
        Route::post('/salary-process', 'Api\V1\Payroll\SalaryProcessController@process')->name('salary-process');
        Route::post('/pr-salary-heads/{deduction_yn}', 'Api\V1\Payroll\SalaryProcessController@loadHeads')->name('pr-salary-heads');
        Route::post('/pr-salary-heads/{deduction_yn}/add', 'Api\V1\Payroll\SalaryProcessController@addHead')->name('pr-salary-heads-add');

    });
        //bonusProcess controller
        Route::group(['name' => 'salary-process.'], function() {
            Route::get('/bonus-process', 'Api\V1\Payroll\BonusProcessController@index')->name('bonus-process-form-data');
            Route::get('/bonus-process-heads', 'Api\V1\Payroll\BonusProcessController@getBonusHeads')->name('bonus-process-head-list');
            Route::post('/bonus-process', 'Api\V1\Payroll\BonusProcessController@process')->name('bonus-process');
            Route::post('/bonus-heads', 'Api\V1\Payroll\BonusProcessController@bonusHeads')->name('bonus-heads');
            Route::put('/bonus-process/heads', 'Api\V1\Payroll\BonusProcessController@bonusHeadsUpdate')->name('bonus-heads-update');
            Route::post('/bonus-process/heads', 'Api\V1\Payroll\BonusProcessController@deleteBonusHead')->name('bonus-heads-delete');
            Route::post('/monthly-bonus-process', 'Api\V1\Payroll\BonusProcessController@monthlyProcess')->name('monthly.bonus-process');
            Route::put('/bonus-process/{id}', 'Api\V1\Payroll\BonusProcessController@update')->name('bonus-process-update');
            Route::get('/bonuses/{fiscalYear}/{fYear}/{prMonth}/{head}', 'Api\V1\Payroll\BonusProcessController@list')->name('bonus-list');
            Route::post('/bonus-process', 'Api\V1\Payroll\BonusProcessController@process')->name('bonus-process');
            Route::post('/pr-bonus-heads/{deduction_yn}', 'Api\V1\Payroll\BonusProcessController@loadHeads')->name('pr-bonus-heads');
            Route::post('/pr-bonus-heads/{deduction_yn}/add', 'Api\V1\Payroll\BonusProcessController@addHead')->name('pr-bonus-heads-add');
    });
    //PeriodController
    Route::group(['name' => 'period.'], function() {
        // v1/payroll/period
        Route::get('/periods/search-fiscal-year/{fiscalYear}', 'Api\V1\Payroll\PeriodController@searchFiscalYear')->name('search-fiscal-year');
        Route::get('/periods', 'Api\V1\Payroll\PeriodController@index')->name('index');
        Route::get('/periods/{id}', 'Api\V1\Payroll\PeriodController@view')->name('view');
        Route::post('/periods', 'Api\V1\Payroll\PeriodController@store')->name('store');
        Route::put('/periods/{id}', 'Api\V1\Payroll\PeriodController@update')->name('update');
        Route::delete('/periods/{id}', 'Api\V1\Payroll\PeriodController@remove')->name('remove');
    });

    //FinancialYearController
    Route::group(['name' => 'fy.'], function() {
        // v1/payroll/FinancialYear
        Route::get('/financial-years', 'Api\V1\Payroll\FinancialYearController@index')->name('index');
        Route::get('/financial-year/{id}', 'Api\V1\Payroll\FinancialYearController@view')->name('view');
        Route::post('/financial-year', 'Api\V1\Payroll\FinancialYearController@store')->name('store');
        Route::put('/financial-year/{id}', 'Api\V1\Payroll\FinancialYearController@store')->name('update');
        Route::delete('/financial-year/{id}', 'Api\V1\Payroll\FinancialYearController@remove')->name('remove');
    });

    // EmpWiseSalaryController
    Route::group(['name' => 'salary-allocation.'], function() {
        // v1/payroll/EmpWiseSalaryController
        Route::get('/salary-allocation', 'Api\V1\Payroll\EmpWiseSalaryController@index')->name('index');
        Route::get('/salary-allocation/search_emp_salary_allocation_record/{id}', 'Api\V1\Payroll\EmpWiseSalaryController@search_emp_salary_allocation_record')->name('search_emp_salary_allocation_record');
        Route::get('/salary-allocation/get-empinfo/{id}', 'Api\V1\Payroll\EmpWiseSalaryController@getempinfo')->name('getempinfo');
        Route::get('/salary-allocation/get-empwise-salaryheads/{id}', 'Api\V1\Payroll\EmpWiseSalaryController@getEmpWiseSalaryHeads')->name('getEmpWiseSalaryHeads');
        Route::get('/salary-allocation/{id}', 'Api\V1\Payroll\EmpWiseSalaryController@view')->name('view');
        Route::post('/salary-allocation', 'Api\V1\Payroll\EmpWiseSalaryController@store')->name('store');
        Route::post('/salary-allocation/update', 'Api\V1\Payroll\EmpWiseSalaryController@update')->name('update');
    });

    // SearchEmpWiseSalaryController
    Route::group(['name' => 'search-salary-allocation.'], function() {
        // v1/payroll/EmpWiseSalaryController
        Route::get('/search-salary-allocation', 'Api\V1\Payroll\SearchEmpWiseSalaryController@index')->name('index');
        Route::get('/search-salary-allocation/emp-info/{id}', 'Api\V1\Payroll\SearchEmpWiseSalaryController@getempinfo')->name('getempinfo');
        Route::post('/search-salary-allocation/search', 'Api\V1\Payroll\SearchEmpWiseSalaryController@search')->name('search');
    });

    // ReportParameterController
    Route::group(['name' => 'report-parameter.'], function() {
        // v1/payroll/ReportParameterController
        Route::get('/report-parameters/{module}', 'Api\V1\Payroll\ReportParameterController@index')->name('index');
        Route::get('/report-parameters/months/{yr?}', 'Api\V1\Payroll\ReportParameterController@getMonthsById')->name('month');
        Route::get('/report-parameters/year-months/{yr?}', 'Api\V1\Payroll\ReportParameterController@getMonths')->name('year-month');
        Route::get('/report-parameters/bill-codes/{mid}', 'Api\V1\Payroll\ReportParameterController@getBillCodes')->name('bill-codes');
    });

    Route::group(['name' => 'state.'], function() {
        Route::get('/bill-status/{fiscalYear}/{fYear}/{prMonth}', 'Api\V1\Payroll\BillStatusController@getCurrentStatus')->name('get-current-status');
        Route::get('/bonus-bill-status/{fYear}/{prMonth}/{head}/{billCode}', 'Api\V1\Payroll\BillStatusController@getCurrentBonusStatus')->name('get-current-bonus-status');
        Route::get('/{billCode}/status/{monthId}', 'Api\V1\Payroll\BillStatusController@get')->name('get-status');
        Route::post('/{billCode}/status/{monthId}', 'Api\V1\Payroll\BillStatusController@post')->name('post-status');
        Route::post('/disburse', 'Api\V1\Payroll\BillStatusController@disbursement')->name('post-disburse');
        Route::get('/bonus/{billCode}/status/{monthId}/{head}', 'Api\V1\Payroll\BillStatusController@getBonus')->name('get-bonus-status');
        Route::post('/bonus/{billCode}/status/{monthId}/{head}', 'Api\V1\Payroll\BillStatusController@postBonus')->name('post--bonus-status');
        Route::post('/bonus-disburse', 'Api\V1\Payroll\BillStatusController@bonusDisbursement')->name('post-bonus-disburse');
    });

});
Route::group(['prefix' => 'deputation-payroll', 'name' => 'deputation-payroll.'],function (){
    // DepuEmpWiseSalaryController
    Route::group(['name' => 'depu-head-allocation.'], function() {
        // v1/payroll/DepuEmpWiseSalaryController
        Route::get('depu-emp/salary-head/{id}', 'Api\V1\Payroll\DepuEmpWiseSalaryController@getDeputationEmp')->name('depu-emp-info');
        Route::get('/salary-allocation/heads/{id}/{emp_id}', 'Api\V1\Payroll\DepuEmpWiseSalaryController@getEmpWiseSalaryHeads')->name('depu-emp-salary-head');
        Route::get('/salary-allocation/allocated-list/{id}', 'Api\V1\Payroll\DepuEmpWiseSalaryController@getAllocatedSalaryHead')->name('depu-emp-salary-allocated-head');
        Route::get('/salary-allocation/{id}/{emp_id}', 'Api\V1\Payroll\DepuEmpWiseSalaryController@view')->name('view');
        Route::post('/salary-allocation', 'Api\V1\Payroll\DepuEmpWiseSalaryController@store')->name('store');
    });
    //DepuEmpSalaryProcessController
    Route::group(['name' => 'salary-process.'], function() {
        Route::get('/salary-process', 'Api\V1\Payroll\DepuEmpSalaryProcessController@index')->name('salary-process-form-data');
        Route::post('/salary-process', 'Api\V1\Payroll\DepuEmpSalaryProcessController@process')->name('salary-process');
        Route::post('/salary-heads', 'Api\V1\Payroll\DepuEmpSalaryProcessController@payrollHeads')->name('salary-heads');
        Route::put('/salary-process/heads', 'Api\V1\Payroll\DepuEmpSalaryProcessController@payrollHeadsUpdate')->name('salary-heads-update');
        Route::post('/salary-process/heads', 'Api\V1\Payroll\DepuEmpSalaryProcessController@deletePayrollHead')->name('salary-heads-delete');
        Route::post('/monthly-process', 'Api\V1\Payroll\DepuEmpSalaryProcessController@monthlyProcess')->name('monthly.process');
        Route::put('/salary-process/{id}', 'Api\V1\Payroll\DepuEmpSalaryProcessController@update')->name('salary-process-update');
        Route::get('/salaries/{fiscalYear}/{fYear}/{prMonth}', 'Api\V1\Payroll\DepuEmpSalaryProcessController@list')->name('salary-list');
        Route::post('/salary-process', 'Api\V1\Payroll\DepuEmpSalaryProcessController@process')->name('salary-process');
        Route::post('/pr-salary-heads/{deduction_yn}', 'Api\V1\Payroll\DepuEmpSalaryProcessController@loadHeads')->name('pr-salary-heads');
        Route::post('/pr-salary-heads/{deduction_yn}/add', 'Api\V1\Payroll\DepuEmpSalaryProcessController@addHead')->name('pr-salary-heads-add');

    });
    //DepuEmpBonusProcessController
    Route::group(['name' => 'salary-process.'], function() {
        Route::get('/bonus-process', 'Api\V1\Payroll\DepuEmpBonusProcessController@index')->name('bonus-process-form-data');
        Route::get('/bonus-process-heads', 'Api\V1\Payroll\DepuEmpBonusProcessController@getBonusHeads')->name('bonus-process-head-list');
        Route::post('/bonus-process', 'Api\V1\Payroll\DepuEmpBonusProcessController@process')->name('bonus-process');
        Route::post('/bonus-heads', 'Api\V1\Payroll\DepuEmpBonusProcessController@bonusHeads')->name('bonus-heads');
        Route::put('/bonus-process/heads', 'Api\V1\Payroll\DepuEmpBonusProcessController@bonusHeadsUpdate')->name('bonus-heads-update');
        Route::post('/bonus-process/heads', 'Api\V1\Payroll\DepuEmpBonusProcessController@deleteBonusHead')->name('bonus-heads-delete');
        Route::post('/monthly-bonus-process', 'Api\V1\Payroll\DepuEmpBonusProcessController@monthlyProcess')->name('monthly.bonus-process');
        Route::put('/bonus-process/{id}', 'Api\V1\Payroll\DepuEmpBonusProcessController@update')->name('bonus-process-update');
        Route::get('/bonuses/{fiscalYear}/{fYear}/{prMonth}/{head}', 'Api\V1\Payroll\DepuEmpBonusProcessController@list')->name('bonus-list');
        Route::post('/bonus-process', 'Api\V1\Payroll\DepuEmpBonusProcessController@process')->name('bonus-process');
        Route::post('/pr-bonus-heads/{deduction_yn}', 'Api\V1\Payroll\DepuEmpBonusProcessController@loadHeads')->name('pr-bonus-heads');
        Route::post('/pr-bonus-heads/{deduction_yn}/add', 'Api\V1\Payroll\DepuEmpBonusProcessController@addHead')->name('pr-bonus-heads-add');
    });

    Route::group(['name' => 'state.'], function() {
        Route::get('/bill-status/{fiscalYear}/{fYear}/{prMonth}', 'Api\V1\Payroll\DepuEmpBillStatusController@getCurrentStatus')->name('get-current-status');
        Route::get('/bonus-bill-status/{fYear}/{prMonth}/{head}/{billCode}', 'Api\V1\Payroll\DepuEmpBillStatusController@getCurrentBonusStatus')->name('get-current-bonus-status');
        Route::get('/{billCode}/status/{monthId}', 'Api\V1\Payroll\DepuEmpBillStatusController@get')->name('get-status');
        Route::post('/{billCode}/status/{monthId}', 'Api\V1\Payroll\DepuEmpBillStatusController@post')->name('post-status');
        Route::post('/disburse', 'Api\V1\Payroll\DepuEmpBillStatusController@disbursement')->name('post-disburse');
        Route::get('/bonus/{billCode}/status/{monthId}/{head}', 'Api\V1\Payroll\DepuEmpBillStatusController@getBonus')->name('get-bonus-status');
        Route::post('/bonus/{billCode}/status/{monthId}/{head}', 'Api\V1\Payroll\DepuEmpBillStatusController@postBonus')->name('post--bonus-status');
        Route::post('/bonus-disburse', 'Api\V1\Payroll\DepuEmpBillStatusController@bonusDisbursement')->name('post-bonus-disburse');
    });

});

//Leave Module
Route::group(['prefix' => 'leave', 'name' => 'leave.'], function () {
     Route::get('/report-parameters', 'Api\V1\Report\LeaveParameterController@index')->name('index');
    // EmpLeaveTempController
    Route::group(['name' => 'leave-entry.'], function() {
        // v1/Leave/EmpLeaveTempController
        Route::get('/leave-entry', 'Api\V1\Leave\EmpLeaveTempController@index')->name('index');
        Route::get('/department-wise-leave/{department_id}', 'Api\V1\Leave\EmpLeaveTempController@departmentWiseLeave')->name('departmentWiseLeave');
        Route::get('/old-leave-data', 'Api\V1\Leave\EmpLeaveTempController@oldLeaveData')->name('oldLeaveData');
        Route::get('/leave-attachment-download/{leave_id}', 'Api\V1\Leave\EmpLeaveTempController@downloadAttachment')->name('leave-attachment-download');
        Route::get('/leave-entry/{id}', 'Api\V1\Leave\EmpLeaveTempController@view')->name('view');
        Route::post('/leave-entry', 'Api\V1\Leave\EmpLeaveTempController@store')->name('store');
        Route::get('/leave-entry/emp-info/{id}/{dpt?}', 'Api\V1\Leave\EmpLeaveTempController@getEmpInfo')->name('getEmpInfo');
        Route::post('/leave-entry/existing/{id}', 'Api\V1\Leave\EmpLeaveTempController@update')->name('update');
        Route::post('/old_leave_entry', 'Api\V1\Leave\EmpLeaveTempController@old_leave_entry')->name('old_leave_entry');
        Route::delete('/leave-entry/{id}', 'Api\V1\Leave\EmpLeaveTempController@remove')->name('remove');
    });

    // AttendanceApprovalController
    Route::group(['name' => 'leave-approval.'], function() {
        // v1/Leave/leave-approval
        Route::get('/leave-approval', 'Api\V1\Leave\AttendanceApprovalController@index')->name('leave-approval');
        Route::post('/leave-approval/approve', 'Api\V1\Leave\AttendanceApprovalController@approve')->name('approve');
        Route::post('/leave-approval/single-approve', 'Api\V1\Leave\AttendanceApprovalController@singleApproveReject')->name('singleApproveReject');
        Route::post('/leave-approval/search', 'Api\V1\Leave\AttendanceApprovalController@search')->name('search');
        Route::post('/leave-total-summery', 'Api\V1\Leave\AttendanceApprovalController@leaveSummery')->name('leaveSummery');
       });

    // HolidayController
    Route::group(['name' => 'holiday-entry.'], function() {
        // v1/Leave/HolidayController
        Route::get('/holiday-entry', 'Api\V1\Leave\HolidayController@index')->name('index');
        Route::get('/holiday-entry/calendar', 'Api\V1\Leave\HolidayController@holidayCalendar')->name('calendar');
        Route::get('/holiday-entry/{id}', 'Api\V1\Leave\HolidayController@view')->name('view');
        Route::post('/holiday-entry', 'Api\V1\Leave\HolidayController@store')->name('store');
        Route::post('/holiday-entry/update/{id}', 'Api\V1\Leave\HolidayController@update')->name('update');
        Route::delete('/holiday-entry/{id}', 'Api\V1\Leave\HolidayController@remove')->name('remove');
    });

});

Route::group(['prefix' => 'admin', 'name' => 'admin.'], function () {
    // AdminController
    Route::group(['name' => 'admin.'], function () {
        Route::get('/pay-grades/{id}', 'Api\V1\Admin\AdminController@findPayGradeById')->name('pay-grades');
        Route::get('/all-pay-grades/{id}', 'Api\V1\Admin\AdminController@findPayGrade')->name('all-pay-grades');
        Route::get('/departments/{id}', 'Api\V1\Admin\AdminController@findDepartmentsById')->name('departments');
        Route::get('/departments', 'Api\V1\Admin\AdminController@findAuthorizedDepartments')->name('findAuthorizedDepartments');
        Route::get('/designations/{id}', 'Api\V1\Admin\AdminController@findDesignationById')->name('departments');
        Route::get('/sections/{id}', 'Api\V1\Admin\AdminController@findSectionsById')->name('sections');
        Route::get('/branches/{id}', 'Api\V1\Admin\AdminController@findBranchById')->name('branches');
        Route::get('/modules', 'Api\V1\Admin\AdminController@modules')->name('modules');
        Route::get('/modules-datatable', 'Api\V1\Admin\AdminController@modulesDatatable')->name('modulesDatatable');
        Route::post('/module', 'Api\V1\Admin\AdminController@storeModule')->name('storeModule');
        Route::put('/module/{id}', 'Api\V1\Admin\AdminController@updateModule')->name('updateModule');
        Route::get('/menus', 'Api\V1\Admin\AdminController@menus')->name('menus');
        Route::get('/menus-datatable', 'Api\V1\Admin\AdminController@menusDatatable')->name('menusDatatable');
        Route::post('/menu', 'Api\V1\Admin\AdminController@storeMenu')->name('storeMenu');
        Route::put('/menu/{id}', 'Api\V1\Admin\AdminController@updateMenu')->name('updateMenu');
        Route::get('/sub-menus', 'Api\V1\Admin\AdminController@subMenus')->name('subMenus');
        Route::get('/sub-menus-datatable', 'Api\V1\Admin\AdminController@subMenusDatatable')->name('subMenusDatatable');
        Route::post('/sub-menu', 'Api\V1\Admin\AdminController@storeSubMenu')->name('storeSubMenu');
        Route::put('/sub-menu/{id}', 'Api\V1\Admin\AdminController@updateSubMenu')->name('updateSubMenu');
        Route::get('/exam-bodies-by-exam/{id}', 'Api\V1\Admin\AdminController@findExamBodiesByExam')->name('findExamBodiesByExam');
        Route::get('/result-type-by-exam/{id}', 'Api\V1\Admin\AdminController@findResultTypeByExam')->name('findResultTypeByExam');
        Route::get('/result-by-type/{id}', 'Api\V1\Admin\AdminController@findResultByType')->name('findResultByType');
        Route::get('/subject-by-exam/{id}', 'Api\V1\Admin\AdminController@findSubjectByExam')->name('findSubjectByExam');
        Route::get('/institute-by-body/{id}', 'Api\V1\Admin\AdminController@findInstituteByBody')->name('findInstituteByBody');
        Route::get('/institutes/{id}', 'Api\V1\Admin\AdminController@findInstituteById')->name('institutes');
        Route::get('/geo-districts/{id}', 'Api\V1\Admin\AdminController@findGeoDistrictById')->name('geo-district');
        Route::get('/employee-code/{id}', 'Api\V1\Admin\AdminController@employee_code')->name('employee_code');
        Route::get('/attachments-types', 'Api\V1\Admin\AdminController@attachmentTypes')->name('attachmentTypes');
        Route::delete('/delete-attachment/{id}', 'Api\V1\Admin\AdminController@deleteAttachment')->name('deleteAttachment');
        Route::post('/attachments', 'Api\V1\Admin\AdminController@attachments')->name('attachments');
        Route::get('/attachments', 'Api\V1\Admin\AdminController@attachmentList')->name('attachmentList');
        Route::get('/employee-attachments/{id}', 'Api\V1\Admin\AdminController@getEmployeeAttachment')->name('getEmployeeAttachment');
        Route::get('/geo-thanas/{id}', 'Api\V1\Admin\AdminController@findGeoThanaById')->name('geo-thana');
        Route::get('/new-recruit', 'Api\V1\Admin\AdminController@newRecruit')->name('new-recruit');
        Route::post('/recruit-process', 'Api\V1\Admin\AdminController@process')->name('recruit-process');
    });
});

//Loan
Route::group(['prefix' => 'loans', 'name' => 'loan.'], function () {
    Route::get('/pf', 'Api\V1\ProvidentFund\Loan\PfLoanController@get')->name('get');
    Route::get('/pf-self', 'Api\V1\ProvidentFund\Loan\PfLoanController@getSelf')->name('getSelf');
    Route::post('/pf', 'Api\V1\ProvidentFund\Loan\PfLoanController@post')->name('post');
    Route::put('/pf/{id}', 'Api\V1\ProvidentFund\Loan\PfLoanController@put')->name('put');
});

Route::group(['prefix' => 'house-allotment', 'name' => 'house-allotment.'], function () {
    Route::get('/self-allotment-information', 'Api\V1\HouseAllotment\HouseAllotmentController@selfAllotmentInformation')->name('selfAllotmentInformation');
    Route::get('/employees-from-house-allotment/{params}', 'Api\V1\HouseAllotment\HouseAllotmentController@EmployeesFromHouseAllotment')->name('EmployeesFromHouseAllotment');
    Route::post('/create', 'Api\V1\HouseAllotment\HouseAllotmentController@create')->name('create');
    Route::get('/request-list', 'Api\V1\HouseAllotment\HouseAllotmentController@request_list')->name('request_list');
});


//Pension
Route::group(['prefix' => 'pension', 'name' => 'pension.'], function () {
    Route::get('/report-parameters', 'Api\V1\Report\PensionParameterController@index')->name('index');
    Route::get('/applications/form-data', 'Api\V1\Pension\ApplicationController@formData')->name('form-data');
    Route::get('/applications/emp/{param}', 'Api\V1\Pension\ApplicationController@searchEmployees')->name('get-emp');
    Route::get('/applications/emp-for-fifteen-years/{param}', 'Api\V1\Pension\ApplicationController@searchEmployeesForFifteenYears')->name('searchEmployeesForFifteenYears');
    Route::get('/employees-for-fifteen-years', 'Api\V1\Pension\ApplicationController@employeesForFifteenYears')->name('employeesForFifteenYears');
    Route::get('/re-continuation-type-list', 'Api\V1\Pension\ApplicationController@reContinuationTypeList')->name('reContinuationTypeList');
    Route::get('/applications-controller-wise/emp/{param}', 'Api\V1\Pension\ApplicationController@searchEmployeesControllerWise')->name('searchEmployeesControllerWise');
    Route::get('/applications/emp/duration/{param}/{date}', 'Api\V1\Pension\ApplicationController@getDuration')->name('get-emp-duration');
    Route::get('/applications', 'Api\V1\Pension\ApplicationController@getPension')->name('get');
    Route::get('/applications-controller-wise', 'Api\V1\Pension\ApplicationController@getPensionControllerWise')->name('getPensionControllerWise');
    Route::get('/applications/nominee/{id}', 'Api\V1\Pension\ApplicationController@getPensionNominees')->name('getPensionNominees');
    Route::post('/applications', 'Api\V1\Pension\ApplicationController@createApplication')->name('post');
    Route::put('/open-for-clearance/{id}', 'Api\V1\Pension\ApplicationController@openForClearance')->name('openForClearance');
    Route::put('/applications/{id}', 'Api\V1\Pension\ApplicationController@updateApplication')->name('put');
    Route::post('/search-pension-applicant', 'Api\V1\Pension\ApplicationController@getEmpPensionSearchData')->name('getEmpPensionSearchData');
    Route::put('/update-workflow-id/{id}', 'Api\V1\Pension\ApplicationController@updateWorkflowId')->name('updateWorkflowId');
    Route::post('/search-pension-calculated-data', 'Api\V1\Pension\ApplicationController@getEmpPensionCalculatedData')->name('getEmpPensionCalculatedData');
    Route::post('/search-pension-settlement-data', 'Api\V1\Pension\ApplicationController@getEmpPensionSettlementData')->name('getEmpPensionSettlementData');
    Route::post('/search-pension-settlement-data-list', 'Api\V1\Pension\ApplicationController@getEmpPensionSettlementDataList')->name('getEmpPensionSettlementDataList');
    Route::post('/pension-settlement', 'Api\V1\Pension\ApplicationController@storePensionSettlement')->name('storePensionSettlement');
    Route::get('/search-pension-empcode/{id}', 'Api\V1\Pension\ApplicationController@searchPensionEmployeeCode')->name('searchPensionEmployeeCode');
    Route::get('/emp-search/{param}', 'Api\V1\Pension\ApplicationController@empSearch')->name('empSearch');
    Route::get('/department-wise-emp-search/{param}/{department_id}', 'Api\V1\Pension\ApplicationController@departmentWisEmpSearch')->name('departmentWisEmpSearch');
    Route::get('/get-pension-clearance-status/{id}', 'Api\V1\Pension\ApplicationController@getPensionClearanceStatus')->name('getPensionClearanceStatus');
//    new
    Route::get('/get-attachments/{id}', 'Api\V1\Pension\ApplicationController@getAttachments')->name('getAttachments');
    Route::get('/show-attachment/{id}', 'Pension\IndexController@showAttachments')->name('showAttachments');

    Route::get('/salary-setup/months-by-year-id/{year}', 'Api\V1\Pension\ApplicationController@monthsByYearId')->name('monthsByYearId');

    //Process
    Route::post('/pension-calculation', 'Api\V1\Pension\PensionProcessController@calculation')->name('calculation');
    Route::post('/monthly-pension-process', 'Api\V1\Pension\PensionProcessController@monthlyPensionProcess')->name('monthlyPensionProcess');
    Route::post('/pension-bonus-process', 'Api\V1\Pension\PensionProcessController@pensionBonusProcess')->name('pensionBonusProcess');
    Route::post('/monthly-pension-process-data', 'Api\V1\Pension\PensionProcessController@getMonthlyPensionProcessData')->name('getMonthlyPensionProcessData');
    Route::post('/pension-bonus-data', 'Api\V1\Pension\PensionProcessController@getMonthlyPensionBonusData')->name('getMonthlyPensionBonusData');
    Route::get('/pension-payable/emp/{param}', 'Api\V1\Pension\PensionProcessController@searchPensionPayableEmployee')->name('searchPensionPayableEmployee');
//    employee route
    Route::post('/monthly-pension-disbursement', 'Api\V1\Pension\PensionProcessController@monthlyPensionDisbursement')->name('monthlyPensionDisbursement');
    Route::post('/pension-bonus-disbursement', 'Api\V1\Pension\PensionProcessController@pensionBonusDisbursement')->name('pensionBonusDisbursement');
    Route::put('/update-pension-workflow/{id}', 'Api\V1\Pension\PensionProcessController@updatePensionApprovalWorkflow')->name('updateApprovalWorkflow');

    //Employee Service Record
    Route::get('/get-service-record', 'Api\V1\Pension\EmployeeServiceRecordController@getEmployeePensionRecord')->name('getEmployeePensionRecord');
    Route::post('/store-service-record', 'Api\V1\Pension\EmployeeServiceRecordController@storeServiceRecord')->name('storeServiceRecord');
    Route::get('/employees', 'Api\V1\Pension\EmployeeServiceRecordController@employee')->name('employee');
    Route::post('/employees', 'Api\V1\Pension\EmployeeServiceRecordController@updateEmployee')->name('updateEmployee');
    Route::get('/pension-heads', 'Api\V1\Pension\PensionHeadSetupController@getPensionHeads')->name('getPensionHeads');
    Route::get('/bonus-process-heads', 'Api\V1\Pension\PensionHeadSetupController@getBonusHeads')->name('getBonusHeads');
    Route::get('/pension-head-data', 'Api\V1\Pension\PensionHeadSetupController@getPensionHeadData')->name('getPensionHeadData');
    Route::post('/pension-head', 'Api\V1\Pension\PensionHeadSetupController@pensionHeadSetup')->name('pensionHeadSetup');
    Route::post('/delete-pension', 'Api\V1\Pension\PensionHeadSetupController@deletePensionHead')->name('deletePensionHead');

    //PrlNotificationController
    Route::post('/search-prl-notification', 'Api\V1\Pension\PrlNotificationController@searchPrlNotification')->name('searchPrlNotification');
    Route::post('/send-mail-notification', 'Api\V1\Pension\PrlNotificationController@sendPlainMail')->name('sendPlainMail');
    Route::post('/automatic-mail-notification', 'Api\V1\Pension\PrlNotificationController@automaticSendMail')->name('automaticSendMail');
    //PrlLeaveApplicationController
    Route::post('/store-prl-leave', 'Api\V1\Pension\PrlLeaveApplicationController@store')->name('store');
    Route::get('/get-prl-data', 'Api\V1\Pension\PrlLeaveApplicationController@getPrlData')->name('getPrlData');
    Route::get('/department-wise-prl-data/{department_id}', 'Api\V1\Pension\PrlLeaveApplicationController@departmentWisePrlData')->name('departmentWisePrlData');
    Route::post('/prl-approval', 'Api\V1\Pension\PrlLeaveApplicationController@prlApproval')->name('prlApproval');
    Route::get('/leave-balance/{id}', 'Api\V1\Pension\PrlLeaveApplicationController@getLeaveBalance')->name('getLeaveBalance');
    Route::post('/search-prl-unapproval-list', 'Api\V1\Pension\PrlLeaveApplicationController@searchPrlUnApprovalList')->name('searchPrlUnApprovalList');
    //LeaveEncashmentController
    Route::post('/store-leave-encashment', 'Api\V1\Pension\LeaveEncashmentController@store')->name('store');
    Route::post('/get-encashment-application-data', 'Api\V1\Pension\LeaveEncashmentController@getEncashmentApplicationData')->name('getEncashmentApplicationData');
    Route::post('/search-encashment-data', 'Api\V1\Pension\LeaveEncashmentController@searchEncashmentData')->name('searchEncashmentData');
    Route::get('/get-leave-balance/{emp_id}/{leaveTypeId}', 'Api\V1\Pension\LeaveEncashmentController@getEmpLeaveBalance')->name('getEmpLeaveBalance');
    Route::get('/encashment-emp-search/{param}', 'Api\V1\Pension\LeaveEncashmentController@encashmentEmpSearch')->name('encashmentEmpSearch');



    //NocAcknowledgmentController
    Route::post('/store-acknowledgement', 'Api\V1\Pension\NocAcknowledgmentController@store')->name('store');
    Route::get('/get-acknowledgement-data', 'Api\V1\Pension\NocAcknowledgmentController@getAcknowledgmentData')->name('getAcknowledgmentData');
    Route::get('/clearance-emp-search/{param}', 'Api\V1\Pension\NocAcknowledgmentController@empSearchForClearance')->name('empSearchForClearance');

    //NocSetupController
    Route::post('/store-noc-setup', 'Api\V1\Pension\NocSetupController@store')->name('store');
    Route::put('/update-noc-setup', 'Api\V1\Pension\NocSetupController@update')->name('update');
    Route::get('/get-noc-data', 'Api\V1\Pension\NocSetupController@getPensionDepartmentSetgrid')->name('getPensionDepartmentSetgrid');
    Route::get('/get-noc-detail-data/{department_id}', 'Api\V1\Pension\NocSetupController@pensionNocDepartmentDetail')->name('pensionNocDepartmentDetail');
    Route::get('/get-department-search-data', 'Api\V1\Pension\NocSetupController@getDepartmentSetSearchData')->name('getDepartmentSetSearchData');
    Route::post('/delete-noc', 'Api\V1\Pension\NocSetupController@delete')->name('delete');


    // Death Registration
    Route::post('/death-registration', 'Api\V1\Pension\DeathRegistrationController@store')->name('store');
    Route::get('/death-nature', 'Api\V1\Pension\DeathRegistrationController@death_nature')->name('death_nature');
    Route::get('/employee-for-death-registration/{param}', 'Api\V1\Pension\DeathRegistrationController@employee_search')->name('employee_search');
    Route::get('/death-registration-list', 'Api\V1\Pension\DeathRegistrationController@death_registration_list')->name('death_registration_list');
    Route::get('/unapproved-death-registration-list', 'Api\V1\Pension\DeathRegistrationController@unapproved_death_registration_list')->name('unapproved_death_registration_list');
    Route::put('/approve-death-registration/{id}', 'Api\V1\Pension\DeathRegistrationController@deathRegistrationApproval')->name('deathRegistrationApproval');

    // Pension Increment Process
    Route::post('/increment-process', 'Api\V1\Pension\PensionIncrementController@increment_process')->name('increment_process');

    // Pension Employee Attendance
    Route::post('/pension-attendance', 'Api\V1\Pension\PensionAttendanceController@store')->name('store');
    Route::get('/pension-attendance', 'Api\V1\Pension\PensionAttendanceController@all_attendance_data')->name('all_attendance_data');
    Route::get('/employee-search/{id}', 'Api\V1\Pension\PensionAttendanceController@employee_search')->name('employee_search');
    Route::get('/pension-nominee/{id}', 'Api\V1\Pension\PensionAttendanceController@pension_nominee')->name('pension_nominee');

    // Nominee
    Route::post('/nominee', 'Api\V1\Pension\NomineeController@store')->name('store');
    Route::post('/nominee-pension-application', 'Api\V1\Pension\NomineeController@pensionApplication')->name('pensionApplication');
    Route::get('/nominee', 'Api\V1\Pension\NomineeController@allNominee')->name('allNominee');
    Route::get('/nominee/{id}', 'Api\V1\Pension\NomineeController@pensionNominee')->name('pensionNominee');
    Route::get('/all-nominee-application', 'Api\V1\Pension\NomineeController@allPensionApplication')->name('allPensionApplication');
    Route::get('/all-continuation-application', 'Api\V1\Pension\NomineeController@allPensionContinuationApplication')->name('allPensionContinuationApplication');
    Route::get('/nominee-emp/{param}', 'Api\V1\Pension\NomineeController@employeeList')->name('employeeList');

    Route::put('/update-pension-recontinue/workflow/{id}', 'Api\V1\Pension\NomineeController@updatePensionRecontinueWorkflow')->name('updatePensionRecontinueWorkflow');
    Route::get('/pension-employee-details/{id}', 'Api\V1\Pension\PensionProcessController@getEmployeeDetailsByCode')->name('getEmployeeDetailsByCode');

});

//operations
Route::group(['prefix' => 'operation', 'name' => 'operation.'], function () {

    Route::get('/emp/{id}', 'Api\V1\Operation\PromotionController@searchEmployees')->name('get-employee');
    Route::get('/all-emp/{id}', 'Api\V1\Operation\PromotionController@searchAllEmployees')->name('get-all-employee');
    Route::get('/settlement-calculation-emp/{id}', 'Api\V1\Operation\PromotionController@searchSettlementCalculationEmployees')->name('searchSettlementCalculationEmployees');
    Route::get('/retired-dead-employee/{id}', 'Api\V1\Operation\PromotionController@searchRetiredDeadEmployees')->name('searchRetiredDeadEmployees');
    Route::get('/pension-application-employee/{id}', 'Api\V1\Operation\PromotionController@searchPensionApplicationEmployees')->name('searchPensionApplicationEmployees');
    Route::get('/pension-clearance-employee/{id}', 'Api\V1\Operation\PromotionController@searchPensionClearanceEmployees')->name('searchPensionClearanceEmployees');
    Route::get('controlling-officer/{id}/{department_id?}', 'Api\V1\Operation\PromotionController@searchControllingOfficer')->name('searchControllingOfficer');
    Route::get('controlling-officer-wise-employee/{emp_name}/{reporting_officer_id?}', 'Api\V1\Operation\PromotionController@controllingOfficerWiseEmployee')->name('controllingOfficerWiseEmployee');
    Route::get('academic-employee/', 'Api\V1\Operation\PromotionController@academicEmployee')->name('academic_employee');
    Route::get('/increment/emp/{id}', 'Api\V1\Operation\PromotionController@searchIncrementEmployees')->name('get-increment-employee');

    Route::group(['name' => 'promotion.'], function () {
        Route::get('/promotions/form-data', 'Api\V1\Operation\PromotionController@formData')->name('form-data');
        Route::get('/get-lookup-data/{id}', 'Api\V1\Operation\PromotionController@getlookupData')->name('getlookupData');
        Route::get('/get-designation-by-department/{id}', 'Api\V1\Operation\PromotionController@getDesignationByDepartment')->name('getDesignationByDepartment');
        Route::get('/get-designation-by-grade/{id}/{emp_grade_id}', 'Api\V1\Operation\PromotionController@getDesignationByGrade')->name('getDesignationByDepartment');
        Route::get('/get-locations-by-type/{id}', 'Api\V1\Operation\PromotionController@getLocationByType')->name('getLocationByType');
        Route::get('/get-emp-promotional-grades/{id}', 'Api\V1\Operation\PromotionController@getEmployeePromotionGrade')->name('getEmployeePromotionGrade');
        Route::get('/promotions', 'Api\V1\Operation\PromotionController@get')->name('get');
        Route::post('/promotions', 'Api\V1\Operation\PromotionController@post')->name('post');
        Route::put('/promotions/{id}', 'Api\V1\Operation\PromotionController@put')->name('put');
        Route::delete('/promotions/{pid}', 'Api\V1\Operation\PromotionController@del')->name('del');
        Route::post('/promotions/process', 'Api\V1\Operation\PromotionController@process')->name('process');
        Route::get('/employee-for-status/{name}', 'Api\V1\Operation\PromotionController@employeeForStatus')->name('employee-for-status');
    });

    Route::group(['name' => 'increment.'], function () {
        Route::get('/increments/form-data', 'Api\V1\Operation\IncrementController@formData')->name('form-data');
        Route::get('/get-grade-steps/{id}', 'Api\V1\Operation\IncrementController@getGradeSteps')->name('getGradeSteps');
        Route::get('/increments', 'Api\V1\Operation\IncrementController@get')->name('get');
        Route::post('/increments', 'Api\V1\Operation\IncrementController@post')->name('post');
        Route::put('/increments/{id}', 'Api\V1\Operation\IncrementController@put')->name('put');
        Route::delete('/increments/{pid}', 'Api\V1\Operation\IncrementController@del')->name('del');
        Route::post('/increments/process', 'Api\V1\Operation\IncrementController@process')->name('process');

        //process by tmp
        Route::get('/increment-tmp/emp/{p}', 'Api\V1\Operation\IncrementController@incrementEmployees')->name('emp_increment_search');

        Route::post('/increment-tmp/del', 'Api\V1\Operation\IncrementController@delIncrementTmp')->name('delete-increment-tmp');
        Route::post('/increment-tmp/add', 'Api\V1\Operation\IncrementController@addIncrementTmp')->name('add-increment-tmp');
        Route::post('/increment-tmp/pause/{id}/{status}', 'Api\V1\Operation\IncrementController@pauseIncrementTmp')->name('pause-increment-tmp');
        Route::post('/increment-tmp/process', 'Api\V1\Operation\IncrementController@processIncrement')->name('process-increment-tmp');
        Route::get('/increment-tmp/get', 'Api\V1\Operation\IncrementController@getIncrementTmp')->name('get-increment-tmp');
    });

    Route::group(['name' => 'punishment.'], function () {
        Route::get('/punishments/form-data', 'Api\V1\Operation\PunishmentController@formData')->name('form-data');
        Route::get('/punishments', 'Api\V1\Operation\PunishmentController@get')->name('get');
        Route::post('/punishments', 'Api\V1\Operation\PunishmentController@post')->name('post');
        Route::put('/punishments/{id}', 'Api\V1\Operation\PunishmentController@put')->name('put');
        Route::delete('/punishments/{pid}', 'Api\V1\Operation\PunishmentController@del')->name('del');
        Route::post('/punishments/process', 'Api\V1\Operation\PunishmentController@process')->name('process');
    });

    Route::group(['name' => 'punishment.'], function () {
        Route::get('/punishments-approval', 'Api\V1\Operation\Approval\PunishmentApprovalController@get')->name('get');
        Route::post('/punishments-approval', 'Api\V1\Operation\Approval\PunishmentApprovalController@store')->name('store');
    });

    Route::group(['name' => 'employee-status.'], function () {
        Route::get('/employee-status/{id}', 'Api\V1\Operation\EmployeeStatusController@get')->name('get');
        Route::get('/employee-status-change', 'Api\V1\Operation\EmployeeStatusController@employeeStatusChange')->name('employee-status-change');
        Route::post('/employee-status', 'Api\V1\Operation\EmployeeStatusController@store')->name('store');
        Route::post('/employee-status-datatable', 'Api\V1\Operation\EmployeeStatusController@datatable')->name('datatable');
    });

    Route::group(['name' => 'tour.'], function () {
        Route::get('/tours/form-data', 'Api\V1\Operation\TourController@formData')->name('form-data');
        Route::get('/tours', 'Api\V1\Operation\TourController@get')->name('get');
        Route::post('/tours', 'Api\V1\Operation\TourController@post')->name('post');
        Route::put('/tours/{id}', 'Api\V1\Operation\TourController@put')->name('put');
        Route::delete('/tours/{pid}', 'Api\V1\Operation\TourController@del')->name('del');
        Route::post('/tours/process', 'Api\V1\Operation\TourController@process')->name('process');
    });

    Route::group(['name' => 'transfer.'], function () {
        Route::get('/transfers/form-data', 'Api\V1\Operation\TransferController@formData')->name('form-data');
        Route::get('/transfers', 'Api\V1\Operation\TransferController@get')->name('get');
        Route::get('/department-wise-employee/{emp_name}/{department_id?}', 'Api\V1\Operation\TransferController@department_wise_employee')->name('department_wise_employee');
        Route::get('/department-wise-employees/{department_id?}', 'Api\V1\Operation\TransferController@departmentWiseEmployees')->name('departmentWiseEmployees');
        Route::get('/employee-wise-information/{emp_code?}', 'Api\V1\Operation\TransferController@employeeInformation')->name('employee-wise-information');
        Route::post('/transfers', 'Api\V1\Operation\TransferController@post')->name('post');
        Route::put('/transfers/{id}', 'Api\V1\Operation\TransferController@put')->name('put');
        Route::delete('/transfers/{pid}', 'Api\V1\Operation\TransferController@del')->name('del');
        Route::post('/transfers/process', 'Api\V1\Operation\TransferController@process')->name('process');
        Route::post('/transfers/bill-codes', 'Api\V1\Operation\TransferController@getBillCodes')->name('bill-codes');
    });

});

//Loan
Route::group(['prefix' => 'loan', 'name' => 'loan.'], function () {
    Route::get('/report-parameters', 'Api\V1\Report\LoanParameterController@index')->name('index');
    Route::get('/active_financial_year', 'Api\V1\Report\LoanParameterController@activeFinancialYear')->name('active_financial_year');
    Route::get('/year-months/{yr?}', 'Api\V1\Report\LoanParameterController@getMonthsLoan')->name('year-month');

    Route::group(['name' => 'loanapplication.'], function () {

        Route::get('/emp/{id}', 'Api\V1\Loan\LoanApplicationController@searchEmployees')->name('get-employee');
        Route::get('/exit-emp/{loan_type_id}/{id}', 'Api\V1\Loan\LoanApplicationController@searchExistingEmployees')->name('get-exit-employee');
        Route::get('/emp-loan/{loan_type_id}/{id}', 'Api\V1\Loan\LoanApplicationController@searchEmployeesByLoanType')->name('get-employee-loan-type');
        Route::get('/get-loanData/{id}', 'Api\V1\Loan\LoanApplicationController@getLoanData')->name('get-loanData');
        Route::get('/guarantor-employee/{id}', 'Api\V1\Loan\LoanApplicationController@guarantorEmployee')->name('guarantor-employee');

        Route::get('/loan-search', 'Api\V1\Loan\LoanApplicationController@getLoanSearch')->name('loan-Search');
        Route::post('/loan-summary-data', 'Api\V1\Loan\LoanApplicationController@getLoanSummaryData')->name('loan-summary-data');
        Route::post('/store-loan-disbursement', 'Api\V1\Loan\LoanApplicationController@storeLoanDisbursement')->name('storeLoanDisbursement');
        Route::get('/disbursements', 'Api\V1\Loan\LoanApplicationController@getDisbursements')->name('disbursements');

        Route::get('/loan-application', 'Api\V1\Loan\LoanApplicationController@get')->name('get-loan-application');
        Route::get('/loan-guarantor/{id}', 'Api\V1\Loan\LoanApplicationController@loanGuarantor')->name('loanGuarantor');
        Route::post('/loan-application', 'Api\V1\Loan\LoanApplicationController@post')->name('post-loan-application');
        Route::put('/loan-application/{id}', 'Api\V1\Loan\LoanApplicationController@put')->name('put-loan-application');
        Route::get('/get-documents/{id}', 'Api\V1\Loan\LoanApplicationController@getDocuments')->name('getDocuments');
        Route::get('/guarantor-attachment/{id}', 'Api\V1\Loan\LoanApplicationController@downloadGuarantorAttachment')->name('guarantor-download');
        Route::get('/attachment/{id}', 'Api\V1\Loan\LoanApplicationController@downloadAttachment')->name('doc-download');
        Route::get('/disbursements-attachment/{id}', 'Api\V1\Loan\LoanApplicationController@downloadDisbursementAttachment')->name('disbursements-attachment');
        Route::post('/exist-loan-edit', 'Api\V1\Loan\LoanApplicationController@existingLoanEdit')->name('existing-loan-edit');

        Route::get('/guarantor-delete/{id}', 'Api\V1\Loan\LoanApplicationController@guarantorDelete')->name('guarantor-delete');
        Route::get('/attachment-delete/{id}', 'Api\V1\Loan\LoanApplicationController@attachmentDelete')->name('attachment-delete');

        // Guarantor
        Route::get('/guarantor-search/{search}', 'Api\V1\Loan\LoanGuarantorController@getLoanGuarantorSearchByType')->name('guarantor-search');
        Route::post('/store-guarantor', 'Api\V1\Loan\LoanGuarantorController@store')->name('store-guarantor');
        Route::get('/get-guarantors', 'Api\V1\Loan\LoanGuarantorController@getLoanGuarantorSearch')->name('get-guarantors');
        Route::get('/get-loan-guarantors', 'Api\V1\Loan\LoanGuarantorController@getLoanGuarantor')->name('getLoanGuarantor');

        //Setup
        Route::get('/get-approvals', 'Api\V1\Loan\LoanSetupController@index')->name('get-approvals');
        Route::get('/loan-approval-types', 'Api\V1\Loan\LoanSetupController@approvalType')->name('loan-approval-types');
        Route::post('/approval-setup', 'Api\V1\Loan\LoanSetupController@store')->name('approval-setup');
        Route::get('/section-by-department/{id}', 'Api\V1\Loan\LoanSetupController@sectionByDepartment')->name('section-by-department');
        Route::get('/approve-for-department/{approval_for}/{id}', 'Api\V1\Loan\LoanSetupController@approveForDepartment')->name('approve-for-department');
        Route::get('/approval-emp/{department_id}/{section_id}/{id}', 'Api\V1\Loan\LoanSetupController@departmentByEmployee')->name('approval-emp');

        // Pay Instruction
        Route::get('/pay-instruction', 'Api\V1\Loan\LoanPayInstructionController@index')->name('pay-instruction');
        Route::post('/pay-instruction-store', 'Api\V1\Loan\LoanPayInstructionController@store')->name('pay-instruction-store');
        Route::post('/pay-instruction-data', 'Api\V1\Loan\LoanPayInstructionController@getPayInstructionLoans')->name('pay-instruction-data');

        //Loan Payment
        Route::get('/search-emp/{search}', 'Api\V1\Loan\LoanPaymentController@searchEmp')->name('search-emp');
        Route::get('/search-loan/{loan_type_id}/{search}', 'Api\V1\Loan\LoanPaymentController@searchLoan')->name('search-loan');
        Route::get('/search-loan-by-emp/{loan_type_id}/{search}', 'Api\V1\Loan\LoanPaymentController@searchLoanByEmpCode')->name('search-loan-emp');
        Route::get('/search-loan-disbursement/{loan_type_id}/{search}', 'Api\V1\Loan\LoanPaymentController@searchLoanDisbursement')->name('search-loan-disbursement');
        Route::get('/get-loan/{id}', 'Api\V1\Loan\LoanPaymentController@getLoan')->name('get-loan');
        Route::post('/payment-store', 'Api\V1\Loan\LoanPaymentController@paymentStore')->name('payment-store');
        Route::get('/payments', 'Api\V1\Loan\LoanPaymentController@index')->name('payments');

        Route::get('/loan-approvals', 'Api\V1\Loan\LoanApprovalController@index')->name('loan-approvals');
        Route::post('/loan-approved', 'Api\V1\Loan\LoanApprovalController@store')->name('loan-approved');
        Route::get('/loan-approvals-change-data/{id}', 'Api\V1\Loan\LoanApprovalController@applicationChangeData')->name('loan-approvals-change-data');

    });

});

// Workflow
Route::post('/workflow', 'Api\V1\Workflow\IndexController@workflow_store')->name('workflow_store');
Route::get('/workflow', 'Api\V1\Workflow\IndexController@workflow_data')->name('workflow_data');
Route::get('/workflow-for-all', 'Api\V1\Workflow\IndexController@workflow_data_for_all')->name('workflow_data_for_all');
Route::get('/workflow_for_module/{id}', 'Api\V1\Workflow\IndexController@workflow_data_for_module')->name('workflow_data_for_module');
Route::delete('/workflow/{id}', 'Api\V1\Workflow\IndexController@delete_workflow')->name('delete_workflow');
Route::get('/workflow-steps/{id}', 'Api\V1\Workflow\IndexController@getStepsById')->name('getStepsById');
Route::post('/store-workflow-steps', 'Api\V1\Workflow\IndexController@storeSteps')->name('storeSteps');
Route::delete('/delete-workflow-steps/{workflow_id}/{step_id}', 'Api\V1\Workflow\IndexController@deleteStep')->name('deleteStep');
Route::get('/workflow/status/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@status')->name('status');
Route::post('/workflow/status/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@store')->name('status-store');
Route::post('/gpf/final-approve/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@gpfFinalApprove')->name('gpf-final-approve');
Route::post('/gpf-loan/final-approve/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@gpfLoanFinalApprove')->name('gpf-loan-final-approve');
Route::post('/gpf-settlement/final-approve/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@gpfSettlementFinalApprove')->name('gpf-loan-settlement-final-approve');
Route::post('/arrear-bill/final-approve/{workflowId}/{objectId}', 'Api\V1\Payroll\ArrearBillController@disburse')->name('disburse');
//Route::post('/pension/', 'Api\V1\Workflow\IndexController@penesionRecontinueFinalApprove')->name('pension-recontinue-final-approve');
Route::post('/pension/recontinue-final-approval/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@penesionRecontinueFinalApprove')->name('pension-recontinue-final-approve');
Route::post('/pension/process-final-approval/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@pensionProcessFinalApprove')->name('pension-process-final-approve');
Route::post('/pension/process-cal-final-approval/{workflowId}/{objectId}', 'Api\V1\Workflow\IndexController@pensionProcessCalFinalApprove')->name('pension-process-cal-final-approve');
