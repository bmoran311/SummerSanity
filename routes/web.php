<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CalendarController as FrontEndCalendarController;
use App\Http\Controllers\Guardian\AuthController;
use App\Http\Controllers\Site\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::middleware('auth')->group(function () {
  require __DIR__.'/admin.php';
});

Route::get('/blog_category/order/{direction}/{id}/{currPos}', 'App\Http\Controllers\Admin\BlogCategoryController@sort')->name('orderBlogCategory');
Route::get('/faq_category/order/{direction}/{id}/{currPos}', 'App\Http\Controllers\Admin\FaqCategoryController@sort')->name('orderFaqCategory');
Route::get('/resource_category/order/{direction}/{id}/{currPos}', 'App\Http\Controllers\Admin\ResourceCategoryController@sort')->name('orderResourceCategory');

Route::get('/faqs', [PageController::class, 'faqs'])->name('site.faqs');

require __DIR__.'/auth.php';
