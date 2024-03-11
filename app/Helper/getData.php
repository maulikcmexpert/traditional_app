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

    // $total_request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->count();
    // $total_page  = ceil($total_request / 10);
    // $request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->paginate(10, ['*'], 'page', $page);

    if ($type == 'rejected') {

        $total_request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->count();
        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->paginate(10, ['*'], 'page', $page);
        // dd($request);
    }
    if ($type = "cancelled") {

        $total_request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->count();
        $total_page  = ceil($total_request / 10);
        $request = ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->onlyTrashed()->paginate(10, ['*'], 'page', $page);
    }
    $userData = [];
    dd(count($request));
    foreach ($request as $val) {
        $userInfo['id'] = $val->id;
        $userInfo['user_id'] = $val->sender_id;
        $userInfo['name'] = $val->sender_user->full_name;
        $getProfile = UserProfile::where(['user_id' => $val->sender_id, 'is_default' => '1'])->first();
        $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
        $userInfo['request_time'] =  ($val->status == 'rejected') ? setpostTime($val->deleted_at) : setpostTime($val->created_at);
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


function getSearchUser($search_name, $page, $user_id)
{

    $total_page = 0;

    $userData = [];
    if ($search_name != "") {

        $totalData = User::with(['userdetail'])->where('id', '!=', $user_id)->where('full_name', 'like', "%$search_name%")->count();
        $total_page = ceil($totalData / 10);

        $users = User::with(['userdetail'])->where('id', '!=', $user_id)->where('full_name', 'like', "%$search_name%")->paginate(10, ['*'], 'page', $page);
        if (count($users) != 0) {

            foreach ($users as $val) {


                $userInfo['id'] = $val->id;
                $userInfo['name'] = $val->full_name;
                $userInfo['city'] = ($val->userdetail->city != null) ? $val->userdetail->city : "";
                $getProfile = UserProfile::where(['user_id' => $val->id, 'is_default' => '1'])->first();
                $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
                $userData[] = $userInfo;
            }
        }
    }
    return array('userData' => $userData, 'total_page' => $total_page);
}


function getProfile($user_id)
{

    $singleProfile = "";
    $profile = UserProfile::where(['user_id' => $user_id, 'is_default' => '1'])->first();
    if ($profile != null) {
        $singleProfile = asset('public/storage/profile' . $profile->profile);
    }
    return $singleProfile;
}
