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

use App\Http\Controllers\SsTaxSlabController;

Route::get('/locked', function () {
    return view('locked');
})->name('locked');
Route::post('/unlock', 'LockedController@unlock')->name('unlock');
Route::get('/download/{name}','Controller@download')->name('download.file');
Route::get('/deviceinfo', 'ZkTecoController@deviceInfo')->name('deviceInfoo');

// Route::middleware(['locked'])->group(function () {
    Route::get('/','HomeController@welcome')->name('welcome');
    Route::get('district-by-province', 'Controller@districtByProvince')->name('get-district');
    Route::get('tempdistrict-by-province', 'Controller@tempdistrictByProvince')->name('get-tempdistrict');


    Route::get('/blank', function () {
        return view('blank');
    });
    Auth::routes();

    Route::get ( '/leave/request', 'LeaveController@request' )->name('leave.request');
    Route::post ( '/leave/get-form', 'LeaveController@getLeaveForm' )->name('leave.get.form');
    Route::post ( '/leave/get-form-guest', 'LeaveController@getLeaveFormGuest' )->name('leave.get.form.guest');
    Route::post ( '/leave/check-user', 'LeaveController@checkUser' )->name('leave.check.user');
    Route::post ( '/leave/store', 'LeaveController@store' )->name('leave.store');


Route::get ( '/today-attendance', 'AttendanceController@todayList' )->name('attendance.todayList');
    /*
    |--------------------------------------------------------------------------
    | Guest Attendance Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get ( '/guest-auto-default-clockout', 'GuestAttendanceController@autoDefaultClockout' )->name('guest.autoDefaultClockout');
    Route::get ( '/guest-get-clockin-form', 'GuestAttendanceController@getClockinForm' )->name('guest.get-change-clockin-form');
    Route::post ( '/guest-clockin', 'GuestAttendanceController@clockin' )->name('guest.clockin');
    Route::get ( '/guest-get-clockout-form', 'GuestAttendanceController@getClockoutForm' )->name('guest.get-change-clockout-form');
    Route::post ( '/guest-clockout', 'GuestAttendanceController@clockout' )->name('guest.clockout');
    Route::get ( '/guest-get-default-clokout-form', 'GuestAttendanceController@getDefaultClockoutForm' )->name('guest.get-default-clockout-form');
    Route::post ( '/guest-default-clockout', 'GuestAttendanceController@defaultClockout' )->name('guest.default-clockout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/get-verification-image/{name}', 'AttendanceController@getVerificationImage');
        /*
        |--------------------------------------------------------------------------
        | Task Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('task.')->prefix('task')->group(function () {
            Route::post ( '/store', 'TaskController@store' )->name('store');
            Route::post ( '/mark-complete', 'TaskController@markComplete' )->name('mask-complete');
            Route::post ( '/remove-task', 'TaskController@removeTask' )->name('remove-task');
            Route::get ( '/clear-completed', 'TaskController@clearCompleted' )->name('clear.completed');
            Route::get ( '/clear-all', 'TaskController@clearAll' )->name('clear.all');
        });

        /*
        |--------------------------------------------------------------------------
        | Department Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('department.')->prefix('department')->group(function () {
            Route::get ( '/', 'DepartmentController@index' )->name('index');
            Route::get ( '/create', 'DepartmentController@create' )->name('create' );
            Route::post ( '/store', 'DepartmentController@store' )->name('store' );
            Route::get ( '/{slug}/edit', 'DepartmentController@edit' )->name('edit');
            Route::post ( '/update', 'DepartmentController@update' )->name('update');
            Route::post ( '/get-change-holiday-form', 'DepartmentController@getChangeHolidayForm' )->name('get-change-holiday-form');
            Route::post ( '/update-holiday', 'DepartmentController@updateHoliday' )->name('update.holiday');
        });

        /*
        |--------------------------------------------------------------------------
        | Designation Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('designation.')->prefix('designation')->group(function () {
            Route::get ( '/', 'DesignationController@index' )->name('index');
            Route::get ( '/create', 'DesignationController@create' )->name('create' );
            Route::post ( '/store', 'DesignationController@store' )->name('store' );
            Route::get ( '/{id}/edit', 'DesignationController@edit' )->name('edit');
            Route::post ( '/update/{id}', 'DesignationController@update' )->name('update');
            Route::get ( 'change-status-field', 'DesignationController@statusChange' )->name('changeStatus');
        });


        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('user.')->prefix('user')->group(function () {
            Route::get ( '/', 'UserController@index' )->name('index');
            Route::get ( '/create', 'UserController@create' )->name('create');
            Route::post ( '/store', 'UserController@store' )->name('store');
            Route::get ( '/{slug}/edit', 'UserController@edit' )->name('edit');
            Route::post ( '/update', 'UserController@update' )->name('update');
            Route::get ( '/{id}/full-details', 'UserController@show' )->name('view');
            Route::get ( '/delete/{slug}', 'UserController@delete' )->name('delete');
            Route::get ( '/undo/delete/{slug}', 'UserController@undoDelete' )->name('undo.delete');
            Route::post ( '/get-change-holiday-form', 'UserController@getChangeHolidayForm' )->name('get-change-holiday-form');
            Route::post ( '/update-holiday', 'UserController@updateHoliday' )->name('update.holiday');
            Route::post ( '/get-leave-report', 'UserController@getLeaveReport' )->name('get.leave.report');
            Route::get ( '/change-password', 'UserController@changePassword' )->name('change.password');
            Route::post ( '/change-password', 'UserController@changePasswordUpdate' )->name('change.password');
            Route::get ( '/change-pin', 'UserController@changePin' )->name('change.pin');
            Route::post ( '/change-pin', 'UserController@changePinUpdate' )->name('change.pin');
            Route::post ( '/get-change-salary-form', 'UserController@getChangeSalaryForm' )->name('get-change-salary-form');
            Route::post ( '/update-salary', 'UserController@upgradeSalary' )->name('update.salary');
        });

        /*
        |--------------------------------------------------------------------------
        | Birthday Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('birthday.')->prefix('birthday')->group(function () {
            Route::get ( '/', 'BirthdayController@index' )->name('index');
        });

        /*
        |--------------------------------------------------------------------------
        | Attendance Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('attendance.')->prefix('attendance')->group(function () {
            Route::get ( '/auto-default-clockout', 'AttendanceController@autoDefaultClockout' )->name('autoDefaultClockout');
            Route::post ( '/get-clockin-form', 'AttendanceController@getClockinForm' )->name('get-change-clockin-form');
            Route::post ( '/clockin', 'AttendanceController@clockin' )->name('clockin');
            Route::post ( '/get-clockout-form', 'AttendanceController@getClockoutForm' )->name('get-change-clockout-form');
            Route::post ( '/clockout', 'AttendanceController@clockout' )->name('clockout');
            Route::post ( '/get-default-clokout-form', 'AttendanceController@getDefaultClockoutForm' )->name('get-default-clockout-form');
            Route::post ( '/default-clockout', 'AttendanceController@defaultClockout' )->name('default-clockout');
            Route::get ( '/monthly', 'AttendanceController@monthly' )->name('monthly');
            Route::get ( '/today', 'AttendanceController@today' )->name('today');
            Route::get ( '/export', 'AttendanceController@export' )->name('export');
            Route::post ( '/get-attendance-detail', 'AttendanceController@getAttendanceDetail' )->name('get-attendance-detail');
            Route::post ( '/mark-present', 'AttendanceController@markPresent' )->name('mark-present');
            Route::post('/mark/absent','AttendanceController@markAbsent')->name('mark-absent');
            Route::post('/cancelAbsent','AttendanceController@cancelAbsent')->name('cancelAbsent');
            Route::post('/cancelLeave','AttendanceController@cancelLeave')->name('cancelLeave');
            Route::post('/verifyAttendance', 'AttendanceController@verifyAttendance')->name('verifyAttendance');
            Route::post('/work-from-home','AttendanceController@workFromHome')->name('wfh.submit');
            Route::post('/cancelWFH','AttendanceController@cancelWFH')->name('cancelWFH');
        });

        /*
        |--------------------------------------------------------------------------
        | Project Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('project.')->prefix('project')->group(function () {
            Route::get ( '/', 'ProjectController@index' )->name('index');
            Route::get ( '/create', 'ProjectController@create' )->name('create');
            Route::post ( '/store', 'ProjectController@store' )->name('store');
            Route::get ( '/{slug}/edit', 'ProjectController@edit' )->name('edit');
            Route::post ( '/update', 'ProjectController@update' )->name('update');
            Route::get ( '/{slug}/mark-complete', 'ProjectController@markComplete' )->name('mark-complete');
        });

        /*
        |--------------------------------------------------------------------------
        | Company Calendar Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('company-calendar.')->prefix('company-calendar')->group(function () {
            Route::get ( '/', 'CompanyCalendarController@index' )->name('index');
            Route::get ( '/get-month-event', 'CompanyCalendarController@getMonthEvent' )->name('get-month-event');
        });

        /*
        |--------------------------------------------------------------------------
        | Holiday Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('holiday.')->prefix('holiday')->group(function () {
            Route::post ( '/store', 'HolidayController@store' )->name('store');
        });

        /*
        |--------------------------------------------------------------------------
        | Report Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('report.')->prefix('report')->group(function () {
            Route::get ( '/', 'ReportController@index' )->name('index');
            Route::get ( '/my-report', 'ReportController@myReport' )->name('my-report');
            Route::get ( '/create', 'ReportController@create' )->name('create');
            Route::post ( '/store', 'ReportController@store' )->name('store');

        });

        /*
        |--------------------------------------------------------------------------
        | Leave Type Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('leave-type.')->prefix('leave-type')->group(function () {
            Route::get ( '/', 'LeaveTypeController@index' )->name('index');
            Route::get ( '/create', 'LeaveTypeController@create' )->name('create');
            Route::post ( '/store', 'LeaveTypeController@store' )->name('store');
            Route::get ( '/{slug}/edit', 'LeaveTypeController@edit' )->name('edit');
            Route::post ( '/update', 'LeaveTypeController@update' )->name('update');
        });

        /*
        |--------------------------------------------------------------------------
        | Leave Type Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('leave.')->prefix('leave')->group(function () {
            Route::get ( '/', 'LeaveController@index' )->name('index');
            Route::get ( '/create', 'LeaveController@create' )->name('create');
            Route::post ( '/request/reject', 'LeaveController@rejectLeave' )->name('request.reject');
            Route::post ( '/request/accept-paid', 'LeaveController@paidAcceptLeave' )->name('request.accept.paid');
            Route::post ( '/request/accept-unpaid', 'LeaveController@unpaidAcceptLeave' )->name('request.accept.unpaid');
            Route::post('/get-grant-form','LeaveController@getPartialForm')->name('partial.grant');
            Route::post('/request/partial-accept','LeaveController@partialAcceptLeave')->name('partial.accept');
            Route::post ( '/request/review', 'LeaveController@reviewLeave' )->name('request.review');
        });

        /*
        |--------------------------------------------------------------------------
        | Setting Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('setting.')->prefix('setting')->group(function () {
            Route::get ( '/', 'SettingController@index' )->name('index');
            Route::post ( '/change-master-pin', 'SettingController@changeMasterPin' )->name('change-master-pin');
            Route::post ( '/change-company-details', 'SettingController@changeCompanyDetails' )->name('change-company-details');
            Route::post ( '/change-company-fiscal-year', 'SettingController@changeCompanyFiscalYear' )->name('change-company-fiscal-year');
        });

        /*
        |--------------------------------------------------------------------------
        | Tax Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('income-tax.')->prefix('income-tax')->group(function () {
            Route::get ( '/', 'IncomeTaxController@index' )->name('index');
            Route::get ( '/{id}/edit', 'IncomeTaxController@edit' )->name('edit');
            Route::name('tax-slab.')->prefix('tax-slab')->group(function () {
            Route::post ( '/create', 'TaxSlabController@create' )->name('create');
            Route::post ( '/order-update', 'TaxSlabController@updateOrder' )->name('update.order');
            });
            Route::post('/ssTax/update/{id}', 'TaxSlabController@updateSST')->name('ss.update');
        });


        /*
        |--------------------------------------------------------------------------
        | Reports Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('reports.')->prefix('reports')->group(function () {
            Route::name('staff-wise.')->prefix('staff-wise')->group(function () {
                Route::get ( '/', 'ReportsController@staffWiseIndex' )->name('index');
                Route::get ( '/{slug}', 'ReportsController@staffWiseReport' )->name('reports');
            });
            Route::name('project-wise.')->prefix('project-wise')->group(function () {
                Route::get ( '/', 'ReportsController@projectWiseIndex' )->name('index');
                Route::get ( '/{slug}', 'ReportsController@projectWiseReport' )->name('reports');
            });
            // Route::get ( '/salary-sheet', 'ReportsController@salarySheet' )->name('salary-sheet');
            Route::get ( '/salary-sheet', 'SalarySheetController@salarySheet' )->name('salary-sheet');
            Route::get('/export/salary-sheet', 'SalarySheetController@export')->name('export.salary-sheet');
            Route::get ( '/pay', 'SalarySheetController@paySalary' )->name('pay.salary');
        });
        /*
        |--------------------------------------------------------------------------
        | Project Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('profile.')->prefix('profile')->group(function () {
            Route::get ( '/', 'UserController@profile' )->name('profile');
            Route::post ( '/upload-image', 'UserController@uploadImage' )->name('image-upload');

        });
        /*
        |--------------------------------------------------------------------------
        | Salary Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('salary.')->prefix('salary')->group(function () {
            // Route::get ( '/pay', 'ReportsController@paySalary' )->name('pay.salary');
            Route::get('/sheet-history', 'SalarySheetController@sheetReports')->name('sheet.history');
            Route::get('/sheet/report/{id}', 'SalarySheetController@sheetReportDetails')->name('sheet.report');
            Route::post('/update', 'SalarySheetController@sheetGenerator')->name('generator');

        });

        /*
        |--------------------------------------------------------------------------
        | Contract Type Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('contract-type.')->prefix('contract-type')->group(function () {
            Route::get ( '/', 'ContractTypeController@index' )->name('index');
            Route::get ( '/create', 'ContractTypeController@create' )->name('create');
            Route::post ( '/store', 'ContractTypeController@store' )->name('store');
            Route::get ( '/{slug}/edit', 'ContractTypeController@edit' )->name('edit');
            Route::post ( '/update', 'ContractTypeController@update' )->name('update');
        });


        /*
        |--------------------------------------------------------------------------
        | Travel Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('travel.')->prefix('travel')->group(function () {
            Route::get ( '/', 'TravelController@index' )->name('index');
            Route::get ( '/review', 'TravelController@reviewRequest' )->name('review');
            Route::get ( '/create', 'TravelController@create' )->name('create');
            Route::post ( '/store', 'TravelController@store' )->name('store');
            Route::post ( '/request/reject', 'TravelController@rejectTravel' )->name('request.reject');
            Route::post ( '/request/recommend', 'TravelController@recommendTravel' )->name('request.recommend');
            Route::post ( '/request/approve', 'TravelController@approveTravel' )->name('request.approve');
        });
        /*
        |--------------------------------------------------------------------------
        | Company Setting Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('company-setting.')->prefix('company-setting')->group(function () {
            Route::get ( '/', 'CompanySettingController@index' )->name('index');
            Route::post ( '/update', 'CompanySettingController@update' )->name('update');
        });

        /*
        |--------------------------------------------------------------------------
        | Payroll Setting Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('payroll-setting.')->prefix('payroll-setting')->group(function () {
            Route::get ( 'income', 'PayrollSettingController@incomeIndex' )->name('income');
            Route::get ( '/create', 'PayrollSettingController@incomeCreate' )->name('income.create');
            Route::post ( '/store', 'PayrollSettingController@incomeStore' )->name('income.store');
            Route::get ( '/edit/{id}', 'PayrollSettingController@incomeEdit' )->name('income.edit');
            Route::post ( '/update', 'PayrollSettingController@incomeUpdate' )->name('income.update');
            Route::get ( '/income/assign/{id}', 'PayrollSettingController@incomeAssignForm' )->name('income.assign.form');
            Route::get ( '/edit/income/assign/{id}', 'PayrollSettingController@incomeAssignEditForm' )->name('income.assign.edit');
            Route::get ( '/select/staff', 'PayrollSettingController@showStaffwiseAllowance' )->name('staff.selection');
            Route::get ( '/deselect/staff', 'PayrollSettingController@hideStaffwiseAllowance' )->name('staff.deselection');
            Route::post ( '/income-assign', 'PayrollSettingController@incomeAssign' )->name('income.assign');
            Route::post ( '/edit/income-assign', 'PayrollSettingController@incomeAssignEdit' )->name('edit.income.assign');
            Route::get ( 'change-status-income', 'PayrollSettingController@statusChange' )->name('changeStatus');

        });
        /*
        |--------------------------------------------------------------------------
        | Notification Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::name('notification.')->prefix('notification')->group(function () {
            Route::get('/list', 'NotificationController@index')->name('all');
        });
    });
// });
