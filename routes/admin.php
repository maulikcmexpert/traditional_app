<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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
    AppVersionSettingController
};

Route::middleware(['admin', 'web', 'auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
        'version_setting' => AppVersionSettingController::class
    ]);
    Route::post('interest_and_hobby/interest_and_hobby_exist', [InterestAndHobbiesController::class, 'interestAndHobbyExist'])->name('interest_and_hobby.exist');
    Route::post('lifestyle/lifestyle_exist', [LifeStyleController::class, 'lifestyleExist'])->name('lifestyle.exist');
    Route::post('zodiacsign/zodiacsign_exist', [ZodiacSignController::class, 'zodiacsignExist'])->name('zodiacsign.exist');
    Route::post('curseword/curseword_exist', [CurseWordController::class, 'CursewordExist'])->name('curseword.exist');
    Route::post('blockreason/blockreason_exist', [BlockReasonController::class, 'BlockReasonExist'])->name('blockreason.exist');
    Route::post('verificationobject/verificationobject_exist', [VerificationObjectController::class, 'VerificationObjectExist'])->name('verificationobject.exist');
    Route::post('feedbackreviewlist/feedbackreviewlist_exist', [FeedbackReviewListController::class, 'FeedbackReviewListExist'])->name('feedbackreviewlist.exist');
    Route::post('leavereason/leavereason_exist', [LeaveReasonController::class, 'LeaveReasonExist'])->name('leavereason.exist');
    Route::post('religion/religion_exist', [ReligionController::class, 'ReligionExist'])->name('religion.exist');
    Route::post('sizeoforganization/sizeoforganization_exist', [SizeOfOrganizationController::class, 'SizeOfOrganizationExist'])->name('sizeoforganization.exist');
});
