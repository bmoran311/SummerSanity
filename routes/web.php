<?php

use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\BioController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CareersController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\EngagementController;
use App\Http\Controllers\Admin\FirmController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\MultimediaController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PracticeAreaController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\ResourceCategoryController;
use App\Http\Controllers\Admin\CampController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\CamperController;
use App\Http\Controllers\Admin\CampEnrollmentController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\CalendarController as FrontEndCalendarController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Guardian\AuthController;
use App\Http\Controllers\Guardian\ForgotPasswordController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Admin\DashboardController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Spatie\Honeypot\ProtectAgainstSpam;

//require_once app_path('Support/BugsnagBootstrap.php');

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware('auth:guardian')->group(function () 
{
	Route::get('/my-dashboard/', 'App\Http\Controllers\CalendarController@dashboard')->name('dashboard.index');
	Route::get('/campers/', 'App\Http\Controllers\CalendarController@campers')->name('dashboard.campers');
	Route::match(['get', 'post'], '/friends', [FrontEndCalendarController::class, 'friends'])->name('dashboard.friends');
	Route::post('/create_camper/', 'App\Http\Controllers\CalendarController@create_camper')->name('camper_front_end.create');
	Route::delete('/delete_camper/{camper}', [App\Http\Controllers\CalendarController::class, 'destroy'])->name('camper_front_end.destroy');
	Route::delete('/delete_friend/{friend}', [App\Http\Controllers\CalendarController::class, 'destroy_friendship'])->name('friend_front_end.destroy');
	Route::get('/edit_camper/{camper}', 'App\Http\Controllers\CalendarController@edit_camper')->name('camper_front_end.edit');
	Route::post('/update_camper/{camper}', [\App\Http\Controllers\CalendarController::class, 'update_camper'])->name('camper_front_end.update');
	Route::post('/invite/friends', 'App\Http\Controllers\CalendarController@sendInvites')->name('invite.friends');
	Route::post('/friendship/request', 'App\Http\Controllers\CalendarController@requestFriendship')->name('friendship.request');
	Route::get('/enrollment/{id}/edit', 'App\Http\Controllers\CalendarController@edit_enrollment')->name('enrollment_front_end.edit');
	Route::put('/calendar/enrollment/{id}', [FrontEndCalendarController::class, 'update_enrollment'])->name('calendar.update_enrollment');
	Route::delete('/camp_enrollment/{group_id}', [FrontEndCalendarController::class, 'delete_enrollment'])->name('camp_enrollment_fe.destroy');
    Route::get('/edit_profile/', 'App\Http\Controllers\CalendarController@profile')->name('profile.index');
	Route::put('/profile', [AuthController::class, 'editProfile'])->name('guardian.profile.update');
    Route::post('/send-invites', [FrontEndCalendarController::class, 'sendInvites'])->name('send-invites');    
});

Route::post('/guardian/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('guardian.password.email');
Route::get('/guardian/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('guardian.password.reset');
Route::post('/guardian/password/reset', [AuthController::class, 'resetPassword'])->name('guardian.password.update');


Route::get('/impersonate/guardian/{id}', function ($id) {
    if (!Auth::guard('web')->check() ) {
        abort(403, 'Only admins can impersonate');
    }

    session()->put('impersonator_user_id', Auth::guard('web')->id());

    Auth::guard('guardian')->loginUsingId($id);

    return redirect('/my-dashboard'); // or wherever your guardian dashboard lives
})->name('admin.impersonate_guardian');


Route::get('/friends/accept', [FrontEndCalendarController::class, 'accept'])->name('friends.accept')->middleware('signed');
Route::post('/friends/accept', [FrontEndCalendarController::class, 'accept'])->name('friends.accept');
Route::post('/friends/reject', [FrontEndCalendarController::class, 'reject'])->name('friends.reject');


Route::get('/confirm/{guardian}', [AuthController::class, 'confirmEmail'])->name('guardian.confirm')->middleware('signed');

Route::post('/guardian/login', [AuthController::class, 'loginWithEmail'])->name('guardian.login');
Route::post('/guardian/register', [AuthController::class, 'registerWithEmail'])
     ->middleware(ProtectAgainstSpam::class)
     ->name('guardian.register');

Route::post('/guardian/logout', function (Request $request) {
    Auth::guard('guardian')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/#login');
})->name('guardian.logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/dashboard/form-elements', function () {
    return view('form-elements');
})->middleware(['auth', 'verified'])->name('form-elements');

Route::get('/dashboard/form-layout', function () {
    return view('form-layout');
})->middleware(['auth', 'verified'])->name('form-layout');

Route::get('/dashboard/tables', function () {
    return view('tables');
})->middleware(['auth', 'verified'])->name('tables');

//Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('admin_user', AdminUserController::class);
    Route::resource('career', CareersController::class);
    Route::resource('firm', FirmController::class);
    Route::resource('bio', BioController::class);
    Route::resource('practice_area', PracticeAreaController::class);
    Route::resource('language', LanguageController::class);
    Route::resource('award', AwardController::class);
    Route::resource('level', LevelController::class);
    Route::resource('license', LicenseController::class);
    Route::resource('membership', MembershipController::class);
    Route::resource('admission', AdmissionController::class);
    Route::resource('education', EducationController::class);
    Route::resource('news', NewsController::class);
    Route::resource('engagement', EngagementController::class);
    Route::resource('multimedia', MultimediaController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('faq_category', FaqCategoryController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('blog_post', BlogPostController::class);
    Route::resource('blog_category', BlogCategoryController::class);
    Route::resource('resource', ResourceController::class);
    Route::resource('resource_category', ResourceCategoryController::class);
    Route::resource('camp', CampController::class);
    Route::resource('guardian', GuardianController::class);
    Route::resource('camper', CamperController::class);
    Route::resource('camp_enrollment', CampEnrollmentController::class);
    Route::resource('invitation', InvitationController::class);

    Route::get('/calendar/index/{guardian_id}', 'App\Http\Controllers\Admin\CalendarController@index')->name('calendar.index');
    Route::get('/calendar_only/index/{guardian_id}', 'App\Http\Controllers\Admin\CalendarController@index_only')->name('calendar.index_only');

    Route::post('/upload-screenshot', [CalendarController::class, 'uploadScreenshot']);
    Route::get('/invite-friends', [CalendarController::class, 'showInvitePage']);    

    Route::get('/guardian/friends/{guardian_id}', 'App\Http\Controllers\Admin\GuardianController@friends')->name('guardian.friends');
    Route::post('/guardian/friends/{guardian_id}', 'App\Http\Controllers\Admin\GuardianController@assign_friends')->name('guardian.assign_friends');
    Route::get('/admin/guardians/export', [GuardianController::class, 'exportCsv'])->name('admin.guardians.export');

    
//});

Route::get('/blog_category/order/{direction}/{id}/{currPos}', 'App\Http\Controllers\Admin\BlogCategoryController@sort')->name('orderBlogCategory');
Route::get('/faq_category/order/{direction}/{id}/{currPos}', 'App\Http\Controllers\Admin\FaqCategoryController@sort')->name('orderFaqCategory');
Route::get('/resource_category/order/{direction}/{id}/{currPos}', 'App\Http\Controllers\Admin\ResourceCategoryController@sort')->name('orderResourceCategory');

Route::get('/faqs', [PageController::class, 'faqs'])->name('site.faqs');

require __DIR__.'/auth.php';