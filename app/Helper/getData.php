<?php

use App\Models\ApproachRequest;
use App\Models\{
    Religion,
    Setting,
    User,
    UserProfile,
    ProfileSeenUser
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

        if ($val->type == 'approach') {

            if ($type == 'pending') {

                if ($is_role == 'receiver') {
                    $userInfo['is_approach'] = "accept_reject";
                }
                $userInfo['message'] = __('messages.approach_request_msg');
            } else if ($type == 'cancelled') {
                $userInfo['message'] = __('messages.approach_cancel_msg');
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
            }
        }
        $userData[] = $userInfo;
    }

    return array('userData' => $userData, 'total_page' => $total_page);
}




// function getManageRequestByMale($search_name, $page, $id)
// {
//     $total_page = 0;
//     if ($search_name != "") {

//         $totalApprochRequest = ApproachRequest::with(['receiver_user' => function ($query) use ($search_name) {
//             $query->where('full_name', 'like', "%$search_name%");
//         }])
//             ->whereHas('receiver_user', function ($query) use ($search_name) {
//                 $query->where('full_name', 'like', "%$search_name%");
//             })
//             ->where(['sender_id' => $id, 'status' => 'pending'])
//             ->count();
//         $total_page = ceil($totalApprochRequest / 10);
//         $request = ApproachRequest::with(['receiver_user' => function ($query) use ($search_name) {
//             $query->where('full_name', 'like', "%$search_name%");
//         }])
//             ->whereHas('receiver_user', function ($query) use ($search_name) {
//                 $query->where('full_name', 'like', "%$search_name%");
//             })
//             ->where(['sender_id' => $id, 'status' => 'pending'])
//             ->paginate(10, ['*'], 'page', $page);
//     } else {

//         $totalApprochRequest =  ApproachRequest::with(['receiver_user'])->where(['sender_id' => $id, 'status' => 'pending'])->count();

//         $total_page = ceil($totalApprochRequest / 10);
//         $request =  ApproachRequest::with(['receiver_user', 'receiver_user.userdetail'])->where(['sender_id' => $id, 'status' => 'pending'])->paginate(10, ['*'], 'page', $page);
//     }


//     $userData = [];
//     if (count($request) != 0) {

//         foreach ($request as $val) {
//             $userInfo['id'] = $val->id;
//             $userInfo['user_id'] = $val->receiver_id;
//             $userInfo['name'] = $val->receiver_user->full_name;
//             $userInfo['city'] = ($val->receiver_user->userdetail->city != null) ? $val->receiver_user->userdetail->city : "";
//             $getProfile = UserProfile::where(['user_id' => $val->receiver_id, 'is_default' => '1'])->first();
//             $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
//             $userData[] = $userInfo;
//         }
//     }
//     return array('userData' => $userData, 'total_page' => $total_page);
// }

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

        $userInfo['status'] = $val->status;
        $userInfo['is_approach'] = "";
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
            }
        }
        $userData[] = $userInfo;
    }

    return array('userData' => $userData, 'total_page' => $total_page);
}

function getSearchUser($search_name, $city, $page, $organizationName, $user_id, $minAge, $maxAge)
{
    $userData = [];
    $total_page = 0;

    // Input validation
    if (empty($search_name)) {
        return array('userData' => $userData, 'total_page' => $total_page);
    }

    // Construct query for user search
    $query = User::query();


    // Apply filters based on search criteria
    $query->where('full_name', 'like', "%$search_name%");
    $query->where('user_type', 'user');
    $query->where('status', 'active');

    if (!empty($city)) {

        $query->whereHas('userdetail', function ($q) use ($city) {
            $q->Where('city', 'like', "%$city%");
        });
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
                now()->subYears($maxAge)->format('Y-m-d'),
                now()->subYears($minAge)->format('Y-m-d'),
            ]);
        });
    }

    // Exclude blocked users
    $query->whereNotIn('id', function ($q) use ($user_id) {
        $q->select('to_be_blocked_user_id')
            ->from('profile_blocks')
            ->where('to_be_blocked_user_id', $user_id)
            ->whereNull('deleted_at');
    });

    $query->whereNotIn('id', function ($q) use ($user_id) {
        $q->select('blocker_user_id')
            ->from('profile_blocks')
            ->where('blocker_user_id', $user_id)
            ->whereNull('deleted_at');
    });


    $query->where('id', '!=', $user_id);

    // Paginate the results
    $result = $query->paginate(10, ['*'], 'page', $page);

    // Format results
    foreach ($result as $val) {

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

    // Check if there's any element greater than 10
    $isBigDigitAvailable = $collection->contains(function ($value, $key) {
        return $value > 10;
    });

    if ($isBigDigitAvailable) {
        return true;
    } else {
        return false;
    }
}
