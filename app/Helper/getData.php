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
        $userInfo['id'] = $val->sender_id;
        $userInfo['name'] = $val->sender_user->full_name;
        $getProfile = UserProfile::where(['user_id' => $val->sender_id, 'is_default' => '1'])->first();
        $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
        $userData[] = $userInfo;
    }
    return $userData;
}



function getManageRequestByMale($search_name, $id)
{

    if ($search_name != "") {
        $request =  ApproachRequest::with(['receiver_user' => function ($query) use ($search_name) {
            $query->where('full_name', 'like', "%$search_name%");
        }])->where(['sender_id' => $id, 'status' => 'pending'])->get();
    } else {

        $request =  ApproachRequest::with(['receiver_user'])->where(['sender_id' => $id, 'status' => 'pending'])->get();
    }
    $userData = [];
    if (count($request) != 0) {

        foreach ($request as $val) {
            $userInfo['id'] = $val->receiver_id;
            $userInfo['name'] = $val->receiver_user->full_name;
            $getProfile = UserProfile::where(['user_id' => $val->receiver_id, 'is_default' => '1'])->first();
            $userInfo['profile'] = ($getProfile != null) ? asset('public/storage/profile/' . $getProfile->profile) : "";
            $userData[] = $userInfo;
        }
    }
    return $userData;
}
