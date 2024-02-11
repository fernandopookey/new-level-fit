<?php

use App\Http\Controllers\Admin\AppointmentStatusChangeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Member\MemberCheckInController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\MemberRegistrationController;
use App\Http\Controllers\Member\MemberRegistrationOverController;
use App\Http\Controllers\Member\MemberVisitController;
use App\Http\Controllers\MergeCreateDataController;
use App\Http\Controllers\Report\AppointmentListController;
use App\Http\Controllers\Report\MemberExpiredListController;
use App\Http\Controllers\Report\MemberListController;
use App\Http\Controllers\Report\TrainerGoListController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Trainer\TrainerSessionCheckInController;
use App\Http\Controllers\Trainer\TrainerSessionController;
use App\Http\Controllers\Trainer\TrainerSessionOverController;
use App\Models\Trainer\CheckInTrainerSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('/')->namespace('Admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/add-data', [MergeCreateDataController::class, 'index'])->name('add-data');

    Route::resource('member', '\App\Http\Controllers\Member\MemberController');
    Route::delete('members-bulk-delete', [MemberController::class, 'bulkDelete'])->name('members-bulk-delete');

    Route::resource('member-package', '\App\Http\Controllers\Member\MemberPackageController');
    Route::resource('member-package-type', '\App\Http\Controllers\Member\MemberPackageTypeController');
    Route::resource('member-package-category', '\App\Http\Controllers\Member\MemberPackageCategoryController');
    Route::resource('member-payment', '\App\Http\Controllers\Member\MemberPaymentController');
    Route::post('member-second-store', [MemberRegistrationController::class, 'memberSecondStore'])->name('member-second-store');
    // Route::get('print-member-card', [MemberController::class, 'print_member_card'])->name('print-member-card');
    Route::resource('print-member-card', '\App\Http\Controllers\Member\MemberPrintCardController');
    Route::resource('member-check-in', '\App\Http\Controllers\Member\MemberCheckInController');
    // Route::delete('/bulk-delete', '\App\Http\Controllers\Member\MemberCheckInController')->name('bulk-delete');
    Route::delete('bulk-delete-member-registration', [MemberCheckInController::class, 'bulkDelete'])->name('bulk-delete-member-registration');
    Route::delete('bulk-delete-trainer-session', [TrainerSessionCheckInController::class, 'bulkDelete'])->name('bulk-delete-trainer-session');

    Route::resource('trainer', '\App\Http\Controllers\Trainer\TrainerController');
    Route::resource('trainer-package', '\App\Http\Controllers\Trainer\TrainerPackageController');
    Route::resource('trainer-package-type', '\App\Http\Controllers\Trainer\TrainerPackageTypeController');
    Route::resource('trainer-transaction-type', '\App\Http\Controllers\Trainer\TrainerTransactionTypeController');

    Route::resource('source-code', '\App\Http\Controllers\Admin\SourceCodeController');
    Route::resource('payment-method', '\App\Http\Controllers\Admin\MethodPaymentController');
    Route::resource('sold-by', '\App\Http\Controllers\Admin\SoldByController');
    Route::resource('referral', '\App\Http\Controllers\Admin\RefferalController');

    Route::resource('staff', '\App\Http\Controllers\Staff\StaffController');
    Route::get('cetak-staff-pdf', [StaffController::class, 'cetak_pdf'])->name('cetak-staff-pdf');
    Route::resource('administrator', '\App\Http\Controllers\Staff\AdministratorController');
    Route::resource('class-instructor', '\App\Http\Controllers\Staff\ClassInstructorController');
    Route::resource('customer-service', '\App\Http\Controllers\Staff\CustomerServiceController');
    Route::resource('customer-service-pos', '\App\Http\Controllers\Staff\CustomerPosServiceController');
    Route::resource('fitness-consultant', '\App\Http\Controllers\Staff\FitnessConsultantController');
    Route::resource('personal-trainer', '\App\Http\Controllers\Staff\PersonalTrainerController');
    Route::resource('physiotherapy', '\App\Http\Controllers\Staff\PhysiotherapyController');
    Route::resource('pt-leader', '\App\Http\Controllers\Staff\PTLeaderController');

    Route::resource('locker-package', '\App\Http\Controllers\Admin\LockerPackageController');
    Route::resource('locker-transaction', '\App\Http\Controllers\Admin\LockerTransactionController');

    Route::resource('studio-booking', '\App\Http\Controllers\Admin\StudioBookingController');
    Route::resource('studio-package', '\App\Http\Controllers\Admin\StudioPackageController');
    Route::resource('studio-transactions', '\App\Http\Controllers\Admin\StudioTransactionController');

    Route::resource('trainer-session', '\App\Http\Controllers\Trainer\TrainerSessionController');
    Route::resource('trainer-session-over', '\App\Http\Controllers\Trainer\TrainerSessionOverController');
    Route::get('trainer-session-over-pdf', [TrainerSessionOverController::class, 'pdfReport'])->name('trainer-session-over-pdf');
    Route::resource('trainer-session-check-in', '\App\Http\Controllers\Trainer\TrainerSessionCheckInController');
    Route::put('trainer-session-freeze/{id}/freeze', [TrainerSessionController::class, 'freeze'])->name('trainer-session-freeze');
    Route::resource('running-session', '\App\Http\Controllers\Trainer\RunningSessionController');

    Route::resource('trainer-session-FO', '\App\Http\Controllers\Trainer\TrainerSessionFOController');
    Route::get('cetak-trainer-session-pdf', [TrainerSessionController::class, 'cetak_pdf'])->name('cetak-trainer-session-pdf');
    Route::get('print-trainer-session-detail-pdf', [TrainerSessionController::class, 'print_trainer_session_detail_pdf'])->name('print-trainer-session-detail-pdf');
    // Route::delete('trainer-session-bulk-delete', [TrainerSessionController::class, 'bulkDelete'])->name('trainer-session-bulk-delete');
    Route::post('/delete-selected-trainer-sessions', [TrainerSessionController::class, 'deleteSelectedTrainerSessions'])->name('delete-selected-trainer-sessions');
    Route::post('/delete-selected-trainer-sessions-over', [TrainerSessionOverController::class, 'deleteSelectedTrainerSessionsOver'])->name('delete-selected-trainer-sessions-over');
    Route::get('pt-agreement/{id}', [TrainerSessionController::class, 'agreement'])->name('pt-agreement');

    Route::resource('buddy-referral', '\App\Http\Controllers\Admin\BuddyReferralController');
    Route::resource('appointment', '\App\Http\Controllers\Admin\AppointmentController');
    Route::get('/appointment-status-show/{id}', [AppointmentStatusChangeController::class, 'appointment_status_show']);
    Route::get('/appointment-status-hide/{id}', [AppointmentStatusChangeController::class, 'appointment_status_hide']);
    Route::get('/appointment-status-missed-guest/{id}', [AppointmentStatusChangeController::class, 'appointment_status_missed_guest']);

    Route::resource('class', '\App\Http\Controllers\Admin\ClassRecapController');
    Route::resource('leads', '\App\Http\Controllers\Admin\LeadController');

    Route::resource('transfer-package', '\App\Http\Controllers\Admin\TransferPackageController');

    Route::resource('studio', '\App\Http\Controllers\Admin\StudioController');

    Route::resource('report-gym', '\App\Http\Controllers\Report\ReportFitnessController');

    Route::resource('appointment-list', '\App\Http\Controllers\Report\AppointmentListController');
    Route::get('all-appointment', [AppointmentListController::class, 'allData'])->name('all-appointment');
    Route::get('appointment-filter', [AppointmentListController::class, 'filter'])->name('appointment-filter');

    Route::resource('member-list', '\App\Http\Controllers\Report\MemberListController');
    Route::resource('member-active', '\App\Http\Controllers\Member\MemberRegistrationController');
    Route::resource('member-expired', '\App\Http\Controllers\Member\MemberRegistrationOverController');
    Route::resource('members', '\App\Http\Controllers\Member\MemberController');
    Route::get('all-member', [MemberListController::class, 'allData'])->name('all-member');
    Route::get('member-filter', [MemberListController::class, 'filter'])->name('member-filter');
    Route::get('print-member-registration-over-pdf', [MemberRegistrationOverController::class, 'pdfReport'])->name('print-member-registration-over-pdf');
    Route::get('membership-agreement/{id}', [MemberRegistrationController::class, 'agreement'])->name('membership-agreement');
    Route::put('member-registration-freeze/{id}/freeze', [MemberRegistrationController::class, 'freeze'])->name('member-registration-freeze');
    Route::get('member-report', [MemberController::class, 'cetak_pdf'])->name('member-report');
    // Route::post('/delete-selected-members', 'MemberRegistrationController@deleteSelectedMembers')->name('delete-selected-members');
    // Route::post('/delete-selected-members', [MemberRegistrationController::class, 'deleteSelectedMembers'])->name('delete-selected-members');
    // Route::post('/delete-selected-members-over', [MemberRegistrationOverController::class, 'deleteSelectedMembersOver'])->name('delete-selected-members-over');
    Route::delete('member-active-bulk-delete', [MemberRegistrationController::class, 'bulkDelete'])->name('member-active-bulk-delete');
    Route::get('cuti/{id}', [MemberRegistrationController::class, 'cuti'])->name('cuti');

    Route::resource('missed-guest', '\App\Http\Controllers\Member\MissedGuestController');

    Route::resource('member-expired-list', '\App\Http\Controllers\Report\MemberListController');
    Route::get('all-member-expired', [MemberListController::class, 'allData'])->name('all-member-expired');
    Route::get('member-expired-filter', [MemberExpiredListController::class, 'filter'])->name('member-expired-filter');

    Route::resource('personal-trainer-list', '\App\Http\Controllers\Report\MemberListController');
    Route::get('all-personal-trainer', [MemberListController::class, 'allData'])->name('all-personal-trainer');
    Route::get('personal-trainer-filter', [MemberExpiredListController::class, 'filter'])->name('personal-trainer-filter');

    Route::get('personal-trainer-filter', [CheckInTrainerSession::class, 'checkMemberExistence'])->name('checkMemberExistence');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');