<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\UserValidate;
use App\Http\Requests\Api\OrgranizationValid;
use App\Models\OrganizationDetail;
use App\Models\UserProfile;
use App\Models\UserInterestAndHobby;
use App\Models\UserLifestyle;
use App\Models\UserShwstpprQue;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserLoveLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Laravel\Passport\Token;

class UsersController extends BaseController
{
    public function user_signup(UserValidate $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->full_name = $request->full_name;
            $user->country_code = $request->country_code;
            $user->mobile_number = $request->mobile_number;
            $user->email = $request->email;
            $user->user_type = "user";
            $randomNumber = rand(1000, 9999);
            $user->otp = $randomNumber;

            if ($user->save()) {
                $user_detail = new UserDetail();
                $user_detail->user_id = $user->id;
                $user_detail->gender = $request->gender;
                $user_detail->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
                $user_detail->city_id = $request->city;
                $user_detail->state_id = $request->state;
                $user_detail->organization_id = $request->organization_id;
                $user_detail->save();
            }

            DB::commit();

            $response = [
                'status' => true,
                'message' => __('messages.registered'),
                'mobile_number' => $user->mobile_number,
                'country_code' => $user->country_code,
                'otp' => strval($user->otp),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();

            $response = [
                'status' => false,
                'message' => 'db error',
            ];
            return response()->json($response);
        }
    }

    public function organization_signup(OrgranizationValid $request)
    {
        try {
            DB::beginTransaction();
            $fileName = $request->file('organization_profile')->getClientOriginalName();
            $imageData = file_get_contents($request->file('organization_profile'));
            $organization = new User();
            $organization->full_name = $request->organization_name;
            $organization->country_code = $request->country_code;
            $organization->country = $request->country_id;
            $organization->mobile_number = $request->mobile_number;
            $organization->email = $request->email;
            $organization->user_type = 'organization';
            $randomNumber = rand(1000, 9999);
            $organization->otp = $randomNumber;
            $organization->save();

            $organizationId = $organization->id;
            $organization_detail = new OrganizationDetail();
            $organization_detail->organization_id = $organizationId;
            $organization_detail->profile = $imageData;
            $organization_detail->profile_name = $fileName;
            $organization_detail->size_of_organization_id = $request->size_of_organization;
            $organization_detail->established_year = date('Y-m-d', strtotime($request->established_year));
            $organization_detail->city = $request->city_id;
            $organization_detail->state = $request->state_id;
            $organization_detail->address = $request->address;
            // $organization_detail->about_us = $request->about_us;
            $organization_detail->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => __('messages.registered'),
                'mobile_number' => $organization->mobile_number,
                'country_code' => $organization->country_code,
                'otp' => $organization->otp,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => "db error"]);
        }
    }



    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
            'country_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->first()], 400);
        }
        $mobile_number = $request->mobile_number;
        $country_id = $request->country_id;
        $country_code = $request->country_code;
        try {
            DB::beginTransaction();
            $user = User::where('mobile_number', $mobile_number)
                ->where('country_code', $country_code)
                ->first();

            if (!$user) {
                return response()->json(['status' => false, 'error' => 'Invalid Mobile number or Country code']);
            }
            $randomNumber = rand(1000, 9999);
            $user->otp = $randomNumber;
            $user->save();
            $response = [
                'status' => true,
                'message' => "Otp Send Successfully",
                'mobile_number' => $user->mobile_number,
                'country_code' => $user->country_code,
                'otp' => $user->otp,
            ];
            DB::commit();
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'db error']);
        }
    }

    public function otp_verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $otp = $request->otp;
        $mobile_number = $request->mobile_number;

        try {
            DB::beginTransaction();
            $user = User::with('userdetail')->where('mobile_number', $mobile_number)
                ->where('otp', $otp)
                ->first();

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Invalid OTP']);
            }
            $givenDatetime = $user->updated_at;

            // Parse the given datetime using Carbon
            $expirationDatetime = Carbon::parse($givenDatetime);

            // Add 30 seconds to the expiration datetime
            $expirationDatetime->addSeconds(30);

            $currentDatetime = Carbon::now();
            if ($currentDatetime->gt($expirationDatetime)) {
                return response()->json(["status" => false, 'message' => 'OTP has expired']);
            }
            $user->is_verified = '1';
            $token = Token::where('user_id', $user->id)->first();

            if ($token) {
                $token->delete();
            }
            $token = Auth::user()->createToken('API Token')->accessToken;
            $user->save();

            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $zodiac = UserDetail::where('user_id', $user->id)->select('zodiac_sign_id')->exists();
            $userLoveLangrate = UserLoveLang::where('user_id', $user->id)->exists();
            if ($user_profile  == null) {
                $step = "Profile";
            } else if ($zodiac == false) {
                $step = "Zodiac";
            } else if ($userLoveLangrate == false) {
                $step = "Rate";
            } else {
                $step = "Home";
            }

            $response = [
                'status' => true,
                'message' => __('messages.otp_verify'),
                'access_token' => $token,
                'gender' => $user->userdetail->gender,
                'user_type' => $user->user_type,
                'user_id' => $user->id,
                'step' => $step,
            ];
            DB::commit();
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'db error']);
        }
    }


    public function ShowsStoperQuesAdd(Request $request)
    {
        try {
            DB::beginTransaction();
            // \DB::enableQueryLog();
            foreach ($request->question as $questions) {
                $que = new UserShwstpprQue();
                $que->user_id = $request->user_id;
                $que->question = $questions['question'];
                $que->option_1 = $questions['option_1'];
                $que->option_2 = $questions['option_2'];
                $que->prefered_option = $questions['prefered_option'];
                $que->save();
            }
            // dd(\DB::getQueryLog());
            return response()->json(["status" => true, 'message' => 'Shows Stoppers Question Add Successfully'], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'db error']);
        }
    }
}
