<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User,
    City,
    State,
    ZodiacSign,
    Faith
};

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'address',
        'city_id',
        'state_id',
        'gender',
        'lattitude',
        'longitude',
        'height',
        'weight',
        'education',
        'about_me',
        'zodiac_sign_id',
        'organization_id',
        'age'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function zodiac_sign()
    {
        return $this->belongsTo(ZodiacSign::class);
    }

    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    public function religon()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }


    public function faith()
    {
        return $this->belongsTo(Faith::class, 'faith_id');
    }

    public function bodytype()
    {
        return $this->belongsTo(BodyType::class, 'body_type_id');
    }

    public function culture()
    {
        return $this->belongsTo(Culture::class, 'culture_id');
    }
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
    public function daily_activity()
    {
        return $this->belongsTo(DailyActivity::class, 'daily_activity_id');
    }

    public function eating_habit()
    {
        return $this->belongsTo(EatingHabit::class, 'eating_habit_id');
    }
}
