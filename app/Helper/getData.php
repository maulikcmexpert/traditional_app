<?php

use App\Models\ApproachRequest;
use App\Models\{
    ApproachPreference,
    Religion,
    Setting,
    User,
    UserProfile,
    ProfileSeenUser,
    ProfileBlock,
    ProfileVerify
};
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


function getReligions()
{
    return Religion::select('id', 'religion as name')->get();
}



function getManageRequestByFemale($type, $page, $receiver_id)
{

    $total_request = ApproachRequest::with(['sender_user', 'receiver_user'])
        ->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['sender_id' => $receiver_id, 'receiver_id' => $receiver_id]);
        })->where(['status' => $type])
        ->orderBy('updated_at', 'desc')
        ->count();
    $total_page  = ceil($total_request / 10);

    $request = ApproachRequest::with(['sender_user', 'receiver_user'])
        ->where(function ($query) use ($receiver_id) {
            $query->orWhere(['sender_id' => $receiver_id, 'receiver_id' => $receiver_id]);
        })->where(['status' => $type])
        ->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);

    if ($type == 'rejected') {
        $total_request =  ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->orderBy('updated_at', 'desc')->onlyTrashed()->count();


        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    }

    if ($type == "cancelled") {
        $total_request =  ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->onlyTrashed()->count();
        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    }

    $userData = [];

    foreach ($request as $val) {
        $is_role = "";
        if ($val->sender_id == $receiver_id) {
            $is_role = "sender";
        } else if ($val->receiver_id == $receiver_id) {
            $is_role = "receiver";
        }

        if ($is_role == 'sender') {
            $userInfo['id'] = $val->id;
            $userInfo['is_role'] = $is_role;
            $userInfo['user_id'] = $val->receiver_id;
            $userInfo['name'] = $val->receiver_user->full_name;
            $getProfile = UserProfile::where(['user_id' => $val->receiver_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userInfo['request_time'] =  ($val->status == 'rejected') ? setpostTime($val->deleted_at) : setpostTime($val->updated_at);
        } else if ($is_role == 'receiver') {

            $userInfo['id'] = $val->id;
            $userInfo['is_role'] = $is_role;
            $userInfo['user_id'] = $val->sender_id;
            $userInfo['name'] = $val->sender_user->full_name;
            $getProfile = UserProfile::where(['user_id' => $val->sender_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userInfo['request_time'] =  ($val->status == 'rejected') ? setpostTime($val->deleted_at) : setpostTime($val->updated_at);
        }
        $userInfo['user_message'] = "";
        $userInfo['relation_type'] =  $val->type;

        $userInfo['is_approach'] = "cancel";
        $userInfo['conversation_id'] = "";
        if ($val->type == 'approach') {

            if ($type == 'pending') {

                if ($is_role == 'receiver') {
                    $userInfo['is_approach'] = "accept_reject";
                }
                $userInfo['message'] = __('messages.approach_request_msg');
            } else if ($type == 'cancelled') {
                $userInfo['message'] = __('messages.approach_cancel_msg');
            } else if ($type == 'accepted') {

                $userInfo['conversation_id'] = $val->conversation_id;
            }
            $userInfo['user_message'] =  $val->message;
        } else if ($val->type == 'friend') {

            if ($type == 'pending') {
                if ($is_role == 'receiver') {
                    $userInfo['is_approach'] = "accept_reject";
                    $userInfo['message'] = __('messages.friend_request_msg');
                } elseif ($is_role == 'sender') {
                    $userInfo['message'] = '$NAME';
                }
            } else if ($type == 'rejected') {


                if ($is_role == 'receiver') {
                    $userInfo['message'] = __('messages.self_friend_request_rejected_msg');
                } elseif ($is_role == 'sender') {
                    $userInfo['message'] = __('messages.friend_request_rejected_msg');
                }
            } else if ($type == 'cancelled') {

                if ($is_role == 'receiver') {
                    $userInfo['message'] = __('messages.friend_cancel_msg');
                }
            } else if ($type == 'accepted') {

                $userInfo['conversation_id'] = $val->conversation_id;
            }
        }
        $userData[] = $userInfo;
    }

    return array('userData' => $userData, 'total_page' => $total_page);
}





function getManageRequestByMale($type, $page, $receiver_id)
{

    $total_request = ApproachRequest::with(['sender_user', 'receiver_user'])
        ->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['sender_id' => $receiver_id, 'receiver_id' => $receiver_id]);
        })->where(['status' => $type])
        ->orderBy('updated_at', 'desc')
        ->count();
    $total_page  = ceil($total_request / 10);

    $request = ApproachRequest::with(['sender_user', 'receiver_user'])
        ->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['sender_id' => $receiver_id, 'receiver_id' => $receiver_id]);
        })->where(['status' => $type])
        ->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);


    if ($type == 'rejected') {

        $total_request =  ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->orderBy('updated_at', 'desc')->onlyTrashed()->count();


        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    } else if ($type == "cancelled") {

        $total_request =  ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->onlyTrashed()->count();
        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(function ($query) use ($receiver_id, $type) {
            $query->orWhere(['receiver_id' => $receiver_id]);
        })->where(['status' => $type])->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    }
    $userData = [];

    foreach ($request as $val) {
        $is_role = "";
        if ($val->sender_id == $receiver_id) {
            $is_role = "sender";
        } else if ($val->receiver_id == $receiver_id) {
            $is_role = "receiver";
        }

        if ($is_role == 'sender') {
            $userInfo['id'] = $val->id;
            $userInfo['is_role'] = $is_role;
            $userInfo['user_id'] = $val->receiver_id;
            $userInfo['name'] = $val->receiver_user->full_name;
            $getProfile = UserProfile::where(['user_id' => $val->receiver_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userInfo['request_time'] =  ($val->status == 'rejected') ? setpostTime($val->deleted_at) : setpostTime($val->updated_at);
        } else if ($is_role == 'receiver') {

            $userInfo['id'] = $val->id;
            $userInfo['is_role'] = $is_role;
            $userInfo['user_id'] = $val->sender_id;
            $userInfo['name'] = $val->sender_user->full_name;
            $getProfile = UserProfile::where(['user_id' => $val->sender_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userInfo['request_time'] =  ($val->status == 'rejected') ? setpostTime($val->deleted_at) : setpostTime($val->updated_at);
        }
        $userInfo['user_message'] = "";
        $userInfo['relation_type'] =  $val->type;
        $data['conversation_id'] = "";
        $userInfo['status'] = $val->status;
        $userInfo['is_approach'] = "";
        $userInfo['conversation_id'] = "";
        if ($val->type == 'approach') {

            if ($type == 'pending') {

                if ($is_role == 'sender') {
                    $userInfo['is_approach'] = "withdrawn";
                }
            }
            $userInfo['user_message'] =  $val->message;
            $userInfo['message'] = '$NAME';
        }
        if ($val->type == 'friend') {

            if ($type == 'pending') {
                if ($is_role == 'receiver') {
                    $userInfo['is_approach'] = "accept_reject";
                    $userInfo['message'] = __('messages.friend_request_msg');
                } elseif ($is_role == 'sender') {
                    $userInfo['message'] = '$NAME';
                    $userInfo['is_approach'] = "cancel";
                }
            } else if ($type == 'rejected') {


                if ($is_role == 'receiver') {
                    $userInfo['message'] = __('messages.self_friend_request_rejected_msg');
                } elseif ($is_role == 'sender') {
                    $userInfo['message'] = __('messages.friend_request_rejected_msg');
                }
            } else if ($type == 'cancelled') {

                if ($is_role == 'receiver') {
                    $userInfo['message'] = __('messages.friend_cancel_msg');
                }
            } else if ($type == 'accepted') {

                $userInfo['conversation_id'] = $val->conversation_id;
            }
        }
        $userData[] = $userInfo;
    }

    return array('userData' => $userData, 'total_page' => $total_page);
}

// function getSearchUser($filter, $page, $user_id)
function getSearchUser($filter, $page, $user_id, $isSearchByUser = true, $lat = null, $long = null)
{
    // dd($isSearchByUser);
    $userData = [];
    $total_page = 0;

    $search_name = $filter['search_name'];
    $organizationName = $filter['organization_name'];
    $city = $filter['city'];
    $minAge = $filter['minAge'];
    $maxAge = $filter['maxAge'];
    $words_of_affirmation_min = $filter['words_of_affirmation_min'];
    $words_of_affirmation_max = $filter['words_of_affirmation_max'];
    $act_of_services_min = $filter['act_of_services_min'];
    $act_of_services_max = $filter['act_of_services_max'];
    $gifts_min = $filter['gifts_min'];
    $gifts_max = $filter['gifts_max'];
    $quality_time_min = $filter['quality_time_min'];
    $quality_time_max = $filter['quality_time_max'];
    $physical_touch_min = $filter['physical_touch_min'];
    $physical_touch_max = $filter['physical_touch_max'];

    if ($isSearchByUser == true) {
        // Input validation
        if (empty($search_name)) {
            return array('userData' => $userData, 'total_page' => $total_page);
        }

        // Construct query for user search
        $query = User::query();

        // Apply filters based on search criteria
        $query->with('userdetail');
        // $query->where('full_name', 'like', "%$search_name%");
        $query->where('user_type', 'user');
        $query->where('status', 'active');

        if (!empty($city)) {

            $query->whereHas('userdetail', function ($q) use ($city, $search_name) {
                $q->where('city', 'like', "%$city%")
                    ->where(function ($qq) use ($search_name) {
                        $qq->orWhere('zip_code', 'like', "%$search_name%")
                            ->orWhere('full_name', 'like', "%$search_name%");
                    });
            });

            // $query->whereHas('userdetail', function ($q) use ($city,$search_name) {
            //     $q->where('city', 'like', "%$city%");
            // })->where('full_name', 'like', "%$search_name%");

        } else {
            $query->whereHas('userdetail', function ($q) use ($search_name) {
                if (isset($minAge) && isset($maxAge)) {
                    $q->whereBetween('date_of_birth', [
                        now()->subYears($maxAge + 1)->format('Y-m-d'),
                        now()->subYears($minAge - 1)->format('Y-m-d'),
                    ])
                        ->where('city', 'like', "%$search_name%")
                        ->orWhere('zip_code', 'like', "%$search_name%");
                } else {
                    $q->where('city', 'like', "%$search_name%")
                        ->orWhere('zip_code', 'like', "%$search_name%");
                }
            })->orWhere('full_name', 'like', "%$search_name%");
        }

        if ($organizationName != "") {
            $organizationIds = User::where('full_name', 'like', "%$organizationName%")->pluck('id');
            $query->whereHas('userdetail', function ($q) use ($organizationIds) {
                $q->whereIn('organization_id', $organizationIds);
            });
        }


        if (isset($minAge) && isset($maxAge)) {
            $query->whereHas('userdetail', function ($q) use ($minAge, $maxAge) {
                $q->whereBetween('date_of_birth', [
                    now()->subYears($maxAge + 1)->format('Y-m-d'),
                    now()->subYears($minAge - 1)->format('Y-m-d'),
                ]);
            });
        }

        $query->whereHas('user_love_lang', function ($q) use ($words_of_affirmation_min, $words_of_affirmation_max, $act_of_services_min, $act_of_services_max, $gifts_min, $gifts_max, $quality_time_min, $quality_time_max, $physical_touch_min, $physical_touch_max) {
            $loveLanguages = [
                'words_of_affirmation' => [$words_of_affirmation_min, $words_of_affirmation_max],
                'act_of_services' => [$act_of_services_min, $act_of_services_max],
                'gifts' => [$gifts_min, $gifts_max],
                'quality_time' => [$quality_time_min, $quality_time_max],
                'physical_touch' => [$physical_touch_min, $physical_touch_max],
            ];
            $i = 0;
            foreach ($loveLanguages as $loveLang => $range) {
                [$min, $max] = $range;
                if ($i == 0) {
                    if ($min !== null && $max !== null) {
                        $q->whereBetween('rate', [$min, $max])->where('love_lang', $loveLang);
                    }
                } else {

                    if ($min !== null && $max !== null) {

                        $q->orWhereBetween('rate', [$min, $max])->where('love_lang', $loveLang);
                    }
                }
                $i++;
            }
        });

        // // Exclude blocked users
        // $query->whereNotIn('id', function ($q) use ($user_id) {
        //     $q->select('to_be_blocked_user_id')
        //         ->from('profile_blocks')
        //         ->where('to_be_blocked_user_id', $user_id)
        //         ->whereNull('deleted_at');
        // });

        // $query->whereNotIn('id', function ($q) use ($user_id) {
        //     $q->select('blocker_user_id')
        //         ->from('profile_blocks')
        //         ->where('blocker_user_id', $user_id)
        //         ->whereNull('deleted_at');
        // });


        $query->where('id', '!=', $user_id);

        // Paginate the results
        $result = $query->paginate(10, ['*'], 'page', $page);
    } else {
        $latitude = $lat;
        $longitude = $long;

        $database = Firebase::database();
        $data = $database->getReference('/user_locations')->getValue();

        $femaleDataArray = [];
        if (isset($data['female'])) {

            foreach ($data['female'] as $keyId => $val) {

                $distance = distanceCalculation($latitude, $longitude, $val['latitude'], $val['longitude']);

                if ($distance <= 5) {

                    $femaleDataArray[] = $keyId;
                }
            }
        }
        if (isset($data['male'])) {

            foreach ($data['male'] as $keyId => $val) {

                $distance = distanceCalculation($latitude, $longitude, $val['latitude'], $val['longitude']);

                if ($distance <= 5) {

                    $femaleDataArray[] = $keyId;
                }
            }
        }

        $users = User::query();
        $users->with([
            'userdetail',
        ])->whereIn('id', $femaleDataArray)
            ->where('status', 'active')
            ->where('user_type', 'user')
            ->where('id', '!=', $user_id);
        $result = $users->paginate(10, ['*'], 'page', $page);
    }
    // Format results
    foreach ($result as $val) {

        $approch_check_is_block = ProfileBlock::where(function ($query) use ($val, $user_id) {
            $query->where('blocker_user_id', $val->id)
                ->where('to_be_blocked_user_id', $user_id);
        })->orderBy('id', 'DESC')->count();
        if ($approch_check_is_block != 0) {
            continue;
        }
        if ($val->userdetail->gender == 'female') {

            $approachPreferences = ApproachPreference::where('user_id', $val->id)->first();
            if ($approachPreferences != null) {

                if ($approachPreferences->preference_apply_in_search == '1') {

                    $getLoginUser = User::with('userdetail')->where('id', $user_id)->first();
                    $LoginUserAge = calculateAge($getLoginUser->userdetail->date_of_birth, date('Y-m-d'));
                    $LoginUserHeight = $getLoginUser->userdetail->height;
                    if ($getLoginUser->userdetail->height_type == 'feet') {
                        $LoginUserHeight = $LoginUserHeight * 30.48;
                    }

                    $LoginUserWeight = $getLoginUser->userdetail->weight;
                    $LoginUser_religion_id = (isNotNullOrBlank($getLoginUser->userdetail->religion_id)) ? $getLoginUser->userdetail->religion_id : 0;

                    if (
                        ($approachPreferences->min_age <= $LoginUserAge && $approachPreferences->max_age >= $LoginUserAge) &&
                        ($approachPreferences->min_weight <= $LoginUserWeight && $approachPreferences->max_weight >= $LoginUserWeight) &&
                        ($approachPreferences->min_height <= $LoginUserHeight && $approachPreferences->max_height >= $LoginUserHeight)

                    ) {

                        if (isNotNullOrBlank($approachPreferences->religious_preference)) {
                            $religious_preference = json_decode($approachPreferences->religious_preference);
                            if (!in_array($LoginUser_religion_id, $religious_preference)) {
                                continue;
                            }
                        }

                        $userProfile = UserProfile::where(['user_id' => $val->id, 'is_default' => '1'])->first();
                        $userInfo = [
                            'id' => $val->id,
                            'name' => $val->full_name,
                            'city' => $val->userdetail->city ?? "",
                            'is_ghost' => is_ghost($val->id),
                            'profile' => ($userProfile != null) ? asset('public/storage/profile/' . $userProfile->profile) : ""
                        ];
                        $userData[] = $userInfo;
                    } else {

                        if (
                            ($LoginUserHeight == NULL || $LoginUserHeight == "") || ($LoginUserWeight == NULL || $LoginUserWeight == "")
                        ) {

                            $userProfile = UserProfile::where(['user_id' => $val->id, 'is_default' => '1'])->first();
                            $userInfo = [
                                'id' => $val->id,
                                'name' => $val->full_name,
                                'city' => $val->userdetail->city ?? "",
                                'is_ghost' => is_ghost($val->id),
                                'profile' => ($userProfile != null) ? asset('public/storage/profile/' . $userProfile->profile) : ""
                            ];
                            $userData[] = $userInfo;
                        }
                    }
                } else {
                    $userProfile = UserProfile::where(['user_id' => $val->id, 'is_default' => '1'])->first();
                    $userInfo = [
                        'id' => $val->id,
                        'name' => $val->full_name,
                        'city' => $val->userdetail->city ?? "",
                        'is_ghost' => is_ghost($val->id),
                        'profile' => ($userProfile != null) ? asset('public/storage/profile/' . $userProfile->profile) : ""
                    ];
                    $userData[] = $userInfo;
                }
            } else {
                $userProfile = UserProfile::where(['user_id' => $val->id, 'is_default' => '1'])->first();
                $userInfo = [
                    'id' => $val->id,
                    'name' => $val->full_name,
                    'city' => $val->userdetail->city ?? "",
                    'is_ghost' => is_ghost($val->id),
                    'profile' => ($userProfile != null) ? asset('public/storage/profile/' . $userProfile->profile) : ""
                ];
                $userData[] = $userInfo;
            }
        } else if ($val->userdetail->gender == 'male') {


            $userProfile = UserProfile::where(['user_id' => $val->id, 'is_default' => '1'])->first();
            $userInfo = [
                'id' => $val->id,
                'name' => $val->full_name,
                'city' => $val->userdetail->city ?? "",
                'is_ghost' => is_ghost($val->id),
                'profile' => ($userProfile != null) ? asset('public/storage/profile/' . $userProfile->profile) : ""
            ];
            $userData[] = $userInfo;
        }
    }

    $total_page = $result->lastPage();

    return compact('userData', 'total_page');
}



function getProfile($user_id)
{

    $singleProfile = "";
    $profile = UserProfile::where(['user_id' => $user_id, 'is_default' => '1'])->first();
    if ($profile != null) {
        $singleProfile = asset('public/storage/profile/' . $profile->profile);
    }
    return $singleProfile;
}


function is_ghost($userId)
{
    $ghostSetting = Setting::select('ghost_count', 'ghost_day')->first();
    $currentDate = Carbon::now();

    // Subtract 5 days from the current date
    $targetDate = $currentDate->subDays($ghostSetting->ghost_day);

    $getData = ProfileSeenUser::select('profile_id', DB::raw('count(*) as view_count'))->where('profile_viewer_id', $userId)->whereDate('created_at', '>=', $targetDate)->groupBy('profile_id')->pluck('view_count');
    $collection = collect($getData);
    $ghost_count = $ghostSetting->ghost_count;
    // Check if there's any element greater than 10

    $isBigDigitAvailable = $collection->contains(function ($value, $key) use ($ghost_count) {
        return $value > $ghost_count;
    });

    if ($isBigDigitAvailable) {
        return true;
    } else {
        return false;
    }
}

function isVerify($userId)
{

    return ProfileVerify::where('user_id', $userId)->exists();
}

function showProfile($user_id, $login_user)
{
    $checkIsalreadyInRelation = ApproachRequest::where(function ($query) use ($user_id, $login_user) {
        $query->where(function ($query) use ($user_id, $login_user) {
            $query->where('sender_id', $login_user)
                ->where('receiver_id', $user_id);
        })->orWhere(function ($query) use ($user_id, $login_user) {
            $query->where('sender_id', $user_id)
                ->where('receiver_id', $login_user);
        });
    })
        ->where('status', 'accepted')
        ->orderBy('id', 'DESC')
        ->count();
    if ($checkIsalreadyInRelation == 0) {

        $addshowprofile = new ProfileSeenUser();
        $addshowprofile->profile_id = $user_id;
        $addshowprofile->profile_viewer_id = $login_user;
        $addshowprofile->save();
    }
}
