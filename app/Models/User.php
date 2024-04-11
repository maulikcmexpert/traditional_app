<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Passport;
use Laravel\Passport\HasApiTokens;
use App\Models\{
    UserDetail,
    UserProfile,
    UserLifestyle,
    UserInterestAndHobby,
    UserLoveLang,
    UserShwstpprQue,
    UserShwstpperAnswr,
    UserSubscription,
    Notification,
    Device,
    ApproachPreference,
    UserReportChat
};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userdetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }
    public function organizationdetail()
    {
        return $this->hasOne(OrganizationDetail::class, 'organization_id', 'id');
    }

    public function device()
    {
        return $this->hasOne(Device::class, 'user_id', 'id');
    }

    public function user_profile()
    {
        return $this->hasMany(UserProfile::class, 'user_id', 'id');
    }

    public function user_lifestyle()
    {
        return $this->hasMany(UserLifestyle::class, 'user_id', 'id');
    }

    public function user_interest_and_hobby()
    {
        return $this->hasMany(UserInterestAndHobby::class, 'user_id', 'id');
    }

    public function user_love_lang()
    {
        return $this->hasMany(UserLoveLang::class, 'user_id', 'id');
    }

    public function sender_approach_request()
    {
        return $this->hasMany(ApproachRequest::class, 'sender_id', 'id');
    }


    public function user_shwstppr_que()
    {
        return $this->hasMany(UserShwstpprQue::class, 'user_id', 'id');
    }

    public function user_shwstpper_answr()
    {
        return $this->hasMany(UserShwstpperAnswr::class, 'user_id', 'id');
    }

    public function user_subscription()
    {
        return $this->hasMany(UserSubscription::class, 'user_id', 'id');
    }


    public function feedback_review()
    {
        return $this->hasMany(FeedbackReview::class);
    }

    public function notification()
    {
        return $this->hasMany(notification::class, 'user_id', 'id');
    }

    public function contact_us()
    {
        return $this->hasMany(ContactUs::class, 'user_id', 'id');
    }
    public function profile_seen_user()
    {
        return $this->hasMany(ProfileSeenUser::class);
    }
    public function profile_block()
    {
        return $this->hasMany(ProfileBlock::class);
    }

    public function  profile_verify()
    {
        return $this->hasOne(ProfileVerify::class, 'user_id', 'id');
    }
    public function  country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function  user_report_chat()
    {
        return $this->hasMany(UserReportChat::class, 'sender_id', 'id');
    }
    public function  approach_preference()
    {
        return $this->hasOne(ApproachPreference::class);
    }

    public function  reports()
    {
        return $this->hasOne(Report::class);
    }




    // public function user_showstoppers_answers()
    // {
    //     return $this->hasMany(UserShowstoppersAnswer::class, 'user_id', 'id');
    // }
}
