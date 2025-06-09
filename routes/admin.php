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
use App\Http\Controllers\Admin\InvitationController;


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


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
