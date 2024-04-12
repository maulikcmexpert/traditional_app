<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{
    BlockReasonController,
    CurseWordController,
    DashboardController,
    FeedbackReviewListController,
    GeneralSettingController,
    UserController,
    InterestAndHobbiesController,
    LeaveReasonController,
    LifeStyleController,
    ReligionController,
    SizeOfOrganizationController,
    VerificationObjectController,
    ZodiacSignController,
    AnnouncementController,
    AppVersionSettingController,
    BodyTypeController,
    CultureController,
    DailyActivityController,
    EatingHabitController,
    ExerciseController,
    FaithController,
    UserReportController
};
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

Route::middleware(['admin', 'web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/change_password', [ProfileController::class, 'changePassword'])->name('changePassword');;
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('check_current_pass', [PasswordController::class, 'checkCurrentPass'])->name('checkCurrentPass.exist');
    Route::resources([
        'user' => UserController::class,
        'interest_and_hobby' => InterestAndHobbiesController::class,
        'lifestyle' => LifeStyleController::class,
        'zodiacsign' => ZodiacSignController::class,
        'curseword' => CurseWordController::class,
        'blockreason' => BlockReasonController::class,
        'verificationobject' => VerificationObjectController::class,
        'feedbackreviewlist' => FeedbackReviewListController::class,
        'leavereason' => LeaveReasonController::class,
        'religion' => ReligionController::class,
        'sizeoforganization' => SizeOfOrganizationController::class,
        'generalsetting' => GeneralSettingController::class,
        'announcement' => AnnouncementController::class,
        'version_setting' => AppVersionSettingController::class,
        'report_management' => UserReportController::class,
        'faith' => FaithController::class,
        'culture' => CultureController::class,
        'body_type' => BodyTypeController::class,
        'daily_activity' => DailyActivityController::class,
        'eating_habit' => EatingHabitController::class,
        'exercise' => ExerciseController::class,
    ]);
    Route::post('interest_and_hobby/interest_and_hobby_exist', [InterestAndHobbiesController::class, 'interestAndHobbyExist'])->name('interest_and_hobby.exist');
    Route::post('interest_and_hobby/selected_by_user', [InterestAndHobbiesController::class, 'selectedbyuser'])->name('interest_and_hobby.selectedbyuser');
    Route::post('lifestyle/lifestyle_exist', [LifeStyleController::class, 'lifestyleExist'])->name('lifestyle.exist');
    Route::post('lifestyle/selected_by_user', [LifeStyleController::class, 'selectedbyuser'])->name('lifestyle.selectedbyuser');

    Route::post('zodiacsign/zodiacsign_exist', [ZodiacSignController::class, 'zodiacsignExist'])->name('zodiacsign.exist');
    Route::post('zodiacsign/selected_by_user', [ZodiacSignController::class, 'selectedbyuser'])->name('zodiacsign.selectedbyuser');

    Route::post('faith/faith_exist', [FaithController::class, 'FaithExist'])->name('faith.exist');
    Route::post('faith/selected_by_user', [FaithController::class, 'selectedbyuser'])->name('faith.selectedbyuser');

    Route::post('culture/culture_exist', [CultureController::class, 'CultureExist'])->name('culture.exist');
    Route::post('culture/selected_by_user', [CultureController::class, 'selectedbyuser'])->name('culture.selectedbyuser');

    Route::post('body_type/body_type_exist', [BodyTypeController::class, 'BodyTypeExist'])->name('body_type.exist');
    Route::post('body_type/selected_by_user', [BodyTypeController::class, 'selectedbyuser'])->name('body_type.selectedbyuser');

    Route::post('daily_activity/daily_activity_exist', [DailyActivityController::class, 'DailyActivityExist'])->name('daily_activity.exist');
    Route::post('daily_activity/selected_by_user', [DailyActivityController::class, 'selectedbyuser'])->name('daily_activity.selectedbyuser');

    Route::post('eating_habit/eating_habit_exist', [EatingHabitController::class, 'EatingHabitExist'])->name('eating_habit.exist');
    Route::post('eating_habit/selected_by_user', [EatingHabitController::class, 'selectedbyuser'])->name('eating_habit.selectedbyuser');

    Route::post('exercise/exercise_exist', [ExerciseController::class, 'ExerciseExist'])->name('exercise.exist');
    Route::post('exercise/selected_by_user', [ExerciseController::class, 'selectedbyuser'])->name('exercise.selectedbyuser');

    Route::post('curseword/curseword_exist', [CurseWordController::class, 'CursewordExist'])->name('curseword.exist');
    Route::post('blockreason/blockreason_exist', [BlockReasonController::class, 'BlockReasonExist'])->name('blockreason.exist');
    Route::post('verificationobject/verificationobject_exist', [VerificationObjectController::class, 'VerificationObjectExist'])->name('verificationobject.exist');
    Route::post('feedbackreviewlist/feedbackreviewlist_exist', [FeedbackReviewListController::class, 'FeedbackReviewListExist'])->name('feedbackreviewlist.exist');
    Route::post('leavereason/leavereason_exist', [LeaveReasonController::class, 'LeaveReasonExist'])->name('leavereason.exist');
    Route::post('religion/religion_exist', [ReligionController::class, 'ReligionExist'])->name('religion.exist');
    Route::post('sizeoforganization/sizeoforganization_exist', [SizeOfOrganizationController::class, 'SizeOfOrganizationExist'])->name('sizeoforganization.exist');
});
