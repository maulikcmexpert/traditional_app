<?php

use App\Models\ApproachRequest;
use App\Models\{
    Religion,
    User,
    UserProfile
};



function getReligions()
{
    return Religion::select('id', 'religion as name')->get();
}


function getManageRequest($type, $page, $receiver_id)
{

    $total_request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->count();
    $total_page  = ceil($total_request / 10);
    $request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    if ($type == 'rejected') {
        $total_request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->orderBy('updated_at', 'desc')->onlyTrashed()->count();
        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    }

    if ($type == "cancelled") {
        $total_request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->count();
        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
    }
    $userData = [];

    foreach ($request as $val) {
        $userInfo['id'] = $val->id;
        $userInfo['user_id'] = $val->sender_id;
        $userInfo['name'] = $val->sender_user->full_name;
        $getProfile = UserProfile::where(['user_id' => $val->sender_id, 'is_default' => '1'])->first();
        $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
        $userInfo['request_time'] =  ($val->status == 'rejected') ? setpostTime($val->deleted_at) : setpostTime($val->updated_at);
        $userInfo['message'] =  ($val->status == 'rejected') ? $val->message : "";
        $userData[] = $userInfo;
    }

    return array('userData' => $userData, 'total_page' => $total_page);
}



function getManageRequestByMale($search_name, $page, $id)
{
    $total_page = 0;
    if ($search_name != "") {

        $totalApprochRequest = ApproachRequest::with(['receiver_user' => function ($query) use ($search_name) {
            $query->where('full_name', 'like', "%$search_name%");
        }])
            ->whereHas('receiver_user', function ($query) use ($search_name) {
                $query->where('full_name', 'like', "%$search_name%");
            })
            ->where(['sender_id' => $id, 'status' => 'pending'])
            ->count();
        $total_page = ceil($totalApprochRequest / 10);
        $request = ApproachRequest::with(['receiver_user' => function ($query) use ($search_name) {
            $query->where('full_name', 'like', "%$search_name%");
        }])
            ->whereHas('receiver_user', function ($query) use ($search_name) {
                $query->where('full_name', 'like', "%$search_name%");
            })
            ->where(['sender_id' => $id, 'status' => 'pending'])
            ->paginate(10, ['*'], 'page', $page);
    } else {

        $totalApprochRequest =  ApproachRequest::with(['receiver_user'])->where(['sender_id' => $id, 'status' => 'pending'])->count();

        $total_page = ceil($totalApprochRequest / 10);
        $request =  ApproachRequest::with(['receiver_user', 'receiver_user.userdetail'])->where(['sender_id' => $id, 'status' => 'pending'])->paginate(10, ['*'], 'page', $page);
    }


    $userData = [];
    if (count($request) != 0) {

        foreach ($request as $val) {
            $userInfo['id'] = $val->id;
            $userInfo['user_id'] = $val->receiver_id;
            $userInfo['name'] = $val->receiver_user->full_name;
            $userInfo['city'] = ($val->receiver_user->userdetail->city != null) ? $val->receiver_user->userdetail->city : "";
            $getProfile = UserProfile::where(['user_id' => $val->receiver_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userData[] = $userInfo;
        }
    }
    return array('userData' => $userData, 'total_page' => $total_page);
}


function getSearchUser($search_name, $city, $organization_name, $page, $user_id)
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

    if (!empty($city)) {

        $query->whereHas('userdetail', function ($q) use ($city) {
            $q->Where('city', 'like', "%$city%");
        });
    }
    if ($organization_name != "") {
        echo "organization";
        exit;
        $query->whereHas('userdetail', function ($q) use ($organization_name) {
            $q->where('organization_id', function ($subq) use ($organization_name) {
                $subq->select('id')->from('users')->where('full_name', 'like', "%$organization_name%")->limit(1);
            });
        });
    }


    // Exclude blocked users
    $query->whereNotIn('id', function ($q) use ($user_id) {
        $q->select('to_be_blocked_user_id')
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
