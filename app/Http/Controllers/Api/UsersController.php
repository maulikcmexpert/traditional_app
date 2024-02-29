<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserValidate;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Country;
use App\Models\UserEducationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\Api\UserResource;

class UsersController extends BaseController
{

    public function addCountry(Request $request)
    {
        $country = $request->country;


        foreach ($country as $value) {

            $cont = new Country();
            $cont->country = $value['country'];
            $cont->iso = $value['iso'];
            $cont->country_code = $value['country_code'];
            $cont->save();
        }
    }
    public function user_signup(UserValidate $request)
    {
        $user = new User();
        $user->full_name = $request->full_name;
        $user->country_code = $request->country_code;
        $user->country = $request->country;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $randomNumber = mt_rand(100000, 999999);
        $user->otp = $randomNumber;
        $user->save();
        $userId = $user->id;
        if ($userId != "") {
            $user_detail = new UserDetail();
            $user_detail->user_id = $userId;
            $user_detail->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
            $user_detail->city = $request->city;
            $user_detail->state = $request->state;
            $user_detail->organization_id = $request->organization_id;
            $user_detail->save();
        }
        $response = [
            'message' => __('messages.registered'),
            'mobile_number' => $request->mobile_number,
            'otp' => $randomNumber,
        ];
        return response()->json($response);
    }

    public function otp_verify(Request $request)
    {
        $otp = $request->otp;
        $mobile_number = $request->mobile_number;
        $user = User::where('mobile_number', $mobile_number)
            ->where('otp', $otp)
            ->first();
        if ($user != "") {
            $user->is_verified = 1;
            $user->save();
            return $this->sendResponse(__('messages.otp_verify'));
        }
    }
}
