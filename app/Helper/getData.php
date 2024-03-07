<?php

use App\Models\ApproachRequest;
use App\Models\{
    Religion,
    UserProfile
};



function getReligions()
{
    return Religion::select('id', 'religion')->get();
}


function getManageRequest($type, $receiver_id)
{


    $request =  ApproachRequest::with(['sender_user'])->where(['status' => $type, 'receiver_id' => $receiver_id])->get();
    $userData = [];

    foreach ($request as $val) {
        $userInfo['id'] = $val->id;
        $userInfo['user_id'] = $val->sender_id;
        $userInfo['name'] = $val->sender_user->full_name;
        $getProfile = UserProfile::where(['user_id' => $val->sender_id, 'is_default' => '1'])->first();
        $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
        $userData[] = $userInfo;
    }
    return $userData;
}



function getManageRequestByMale($page, $id)
{

    $totalApprochRequest =  ApproachRequest::with(['receiver_user'])->where(['sender_id' => $id, 'status' => 'pending'])->count();

    $total_page = ceil($totalApprochRequest / 10);
    $request =  ApproachRequest::with(['receiver_user', 'receiver_user.userdetail.city'])->where(['sender_id' => $id, 'status' => 'pending'])->paginate(10, ['*'], 'page', $page);

    $userData = [];
    if (count($request) != 0) {

        foreach ($request as $val) {
            $userInfo['id'] = $val->receiver_id;
            $userInfo['name'] = $val->receiver_user->full_name;
            $userInfo['city'] = ($val->receiver_user->userdetail->city != null) ? $val->receiver_user->userdetail->city->city : "";
            $getProfile = UserProfile::where(['user_id' => $val->receiver_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userData[] = $userInfo;
        }
    }
    return array('userData' => $userData, 'total_page' => $total_page);
}
