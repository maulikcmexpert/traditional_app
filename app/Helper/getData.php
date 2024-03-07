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