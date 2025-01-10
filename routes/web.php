<?php

use App\Http\Controllers\IpApplicationFormController;
use App\Http\Controllers\CmotParticipantsController;
use App\Http\Controllers\DirectorDebuteController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\OttformController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmotController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;

Route::group(['middleware' => 'guest'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login',     'index')->name('login');
        Route::post('login',    'login')->name('login'); //->middleware('throttle:2,1')
    });
});

Route::get('resetPassword',       [AuthController::class, 'resetPwdView'])->name('resetPassword');
Route::post('resetPassword',      [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('sendOtp',             [AuthController::class, 'sendOtpView'])->name('sendOtp');
Route::post('sendOtp',            [AuthController::class, 'sendOtp'])->name('sendOtp');
Route::get('verifyOtp',           [AuthController::class, 'verifyOtpView'])->name('verifyOtp');
Route::post('verifyOtp',          [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::get('changePassword',      [AuthController::class, 'changePasswordView'])->name('changePassword');
Route::post('changePassword',     [AuthController::class, 'changePassword'])->name('changePassword');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/',                 [WelcomeController::class, 'index']);
    Route::get('cmot-dashboard',    [CmotController::class, 'dashboard']);
    Route::get('level-dashboard',   [CmotController::class, 'lavelDashboard']);
    Route::get('home',              [AuthController::class, 'home'])->name('home');
    Route::get('logout',            [AuthController::class, 'logout'])->name('logout');

    Route::resources([
        'roles'             =>  RoleController::class,
        'users'             =>  UserController::class,
        'permissions'       =>  PermissionController::class,
        'ips'               =>  IpApplicationFormController::class,
        'cmots'             =>  CmotController::class,
        'otts'              =>  OttformController::class,
        'dds'               =>  DirectorDebuteController::class,
        'alumnis'           =>  AlumniController::class,
        'cmot-participants' =>  CmotParticipantsController::class,
    ]);

    Route::controller(UserController::class)->group(function () {
        Route::get('user-search',       'search')->name('user.search');
    });

    Route::controller(AlumniController::class)->group(function () {
        Route::get('cmot-edition',                  'cmotEdition')->name('cmot-edition');
        Route::get('cmot-edition-search',           'cmotEditionSearch')->name('cmot-edition-search');
        Route::get('alumni-search',                 'search')->name('alumni.search');
        Route::get('alumni-interested-by',          'interestedBy')->name('interestedBy');
        Route::get('company-search',                'companySearch')->name('company.search');
        Route::get('select/{id}',                   'selectByRecruiter')->name('alumni.select');
        Route::get('reject/{id}',                   'rejectByRecruiter')->name('alumni.reject');
        Route::get('selected-by-recruiter-list',    'selectedList')->name('selected-list');
        Route::get('rejected-by-recruiter-list',    'rejectedList')->name('rejected-list');
        Route::get('selected-undo/{id}',            'selectedUndo')->name('selected-undo');
        Route::get('rejected-undo/{id}',            'rejectedUndo')->name('rejected-undo');
    });

    Route::controller(CmotParticipantsController::class)->group(function () {
        Route::get('cmot-participant/{id}/select',              'selectByRecruiter')->name('cmot-participant.select');
        Route::get('cmot-participant/{id}/reject',              'rejectByRecruiter')->name('cmot-participant.reject');
        Route::get('cmot-participant-selected',                 'selectedList')->name('cmot-participant-selected-list');
        Route::get('cmot-participant-rejected',                 'rejectedList')->name('cmot-participant-rejected-list');
        Route::get('cmot-participant-selected-undo/{id}',       'selectedUndo')->name('cmot-participant-selected-undo');
        Route::get('cmot-participant-undo-rejected-undo/{id}',  'rejectedUndo')->name('cmot-participant-rejected-undo');
        Route::get('interested-in-cmot-participant',            'interestedBy')->name('cmot-participant-interested-By');
        Route::get('company-search-cmot-participant',           'companySearch')->name('cmot-participant-company.search');
        Route::get('cmot-participant-search',                   'search')->name('cmot-participant.search');
    });

    Route::controller(CmotController::class)->group(function () {
        Route::get('film_craft_search',             'search')->name('film_creaft.search');
        Route::any('assign_role/{id}',              'assign');
        Route::get('auto_asign',                    'autoAsign');
        Route::post('assign_to/{id}',               'assignTo');
        Route::get('review_by/{id}',                'review');
        Route::post('review_by/{id}',               'feedback');
        Route::any('delete_assigned/{xid}',         'deleteAssignJury');
        Route::get('export_cmot',                   'export')->name('cmot.export');
        Route::get('export-by-jury',                'exportByJury')->name('export-by-jury');
        Route::get('export-by-grand-jury',          'exportByGrandJury')->name('export-by-grand-jury');
    });

    Route::controller(IpApplicationFormController::class)->group(function () {
        Route::get('films_title/{id}',              'filmsTitle');
        Route::get('ip_search',                     'search')->name('ip.search');
        Route::get('ip_featured_excel_export',      'featureExport')->name('ip.feature');
        Route::get('ip_non_featured_excel_export',  'nonFeatureExport')->name('ip.non_feature');
        Route::get('ip_all_excel_export',           'allReport')->name('ip.all_record');
        Route::get('export_by_search',              'exportBySearch')->name('export.search');
        Route::get('ip/zip/{id}',                   'downloadDocumentsAsZip')->name('ip.zip');
        Route::get('ip/pdf/{id}',                   'ippdf')->name('ip.pdf');
        Route::get('ip-pdf-generator',              'pdfGenerator')->name('ip-pdf-generator');
    });

    Route::controller(OttformController::class)->group(function () {
        Route::get('ott_search',            'search')->name('ott.search');
        Route::get('ott/list',              'list')->name('ott.list');
        Route::get('ott/list',              'list')->name('ott.list');
        Route::get('ott/export',            'export')->name('ott.export');
        Route::get('ott_export_by_search',  'exportBySearch')->name('export_by.search');
        Route::get('ott/exportCoproducer',  'exportCoproducer')->name('ott.exportCoproducer');

        Route::get('ott/view/{id}',         'ottview')->name('ott.view');
        Route::get('ott/pdf/{id}',          'ottpdf')->name('ott.pdf');
        Route::get('ott/zip/{id}',          'downloadDocumentsAsZip')->name('ott.zip');
        Route::get('ott-pdf-generator',      'ottPdfGenerator')->name('ott-pdf-generator');
    });

    Route::controller(DirectorDebuteController::class)->group(function () {
        Route::get('dd-search',                     'search')->name('dd-search');
        Route::get('dd-all-excel-export',           'excellReport')->name('dd-all-excel-export');
        Route::get('dd-export-by-search',           'exportBySearch')->name('dd-export-by-search');
        Route::get('dd/zip/{id}',                   'downloadDocumentsAsZip')->name('dd-zip');
        Route::get('dd/pdf/{id}',                   'ddPdf')->name('dd-pdf');
        Route::get('dd-pdf-generator',              'pdfGenerator')->name('dd-pdf-generator');
    });

    Route::get('permission_search',     [PermissionController::class, 'search'])->name('permissions.search');
});

Route::get('social-media', function () {
    return view('social-media');
});

Route::fallback(function () {
    return abort(401, "User can't perform this action.");
});

// Livewire

Route::get('/counter', Counter::class);