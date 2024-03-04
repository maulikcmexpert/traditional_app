<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\{
    UserValidate,
    StoreProfileRequest,
    OrgranizationValid,
    UserPersonalityRequest
};


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
use Illuminate\Database\QueryException;

class UsersController extends BaseController
{
    public function userSignup(UserValidate $request)
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
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function organizationSignup(OrgranizationValid $request)
    {
        try {
            DB::beginTransaction();


            $organization = new User();
            $organization->full_name = $request->organization_name;
            $organization->country_code = $request->country_code;
            $organization->mobile_number = $request->mobile_number;
            $organization->email = $request->email;
            $organization->user_type = 'organization';
            $randomNumber = rand(1000, 9999);
            $organization->otp = $randomNumber;
            $organization->save();

            $organizationId = $organization->id;
            $organization_detail = new OrganizationDetail();
            $organization_detail->organization_id = $organizationId;

            if (!empty($request->organization_profile)) {



                $image = $request->organization_profile;

                $imageName = $organizationId . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('storage/profile'), $imageName);
                $organization_detail->profile = $imageName;
            }

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
                'otp' => strval($organization->otp),
            ];

            return response()->json($response);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }



    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
            'country_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 400);
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
                return response()->json(['status' => false, 'message' => 'Invalid Mobile number or Country code']);
            }
            $randomNumber = rand(1000, 9999);
            $user->otp = $randomNumber;
            $user->save();
            $response = [
                'status' => true,
                'message' => "Otp Send Successfully",
                'mobile_number' => $user->mobile_number,
                'country_code' => $user->country_code,
                'otp' => strval($user->otp),
            ];
            DB::commit();
            return response()->json($response);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }



    public function otpVerify(Request $request)
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
            $user = User::where('mobile_number', $mobile_number)
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
            $user->save();
            $token = Token::where('user_id', $user->id)->first();

            if ($token) {
                $token->delete();
            }

            Auth::login($user);

            $token = Auth::user()->createToken('API Token')->accessToken;
            $step = "";

            if ($user->user_type == 'user') {
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
            } elseif ($user->user_type == 'organization') {
                $response = [
                    'status' => true,
                    'message' => __('messages.otp_verify'),
                    'access_token' => $token,
                    'user_type' => $user->user_type,
                    'user_id' => $user->id,
                    'step' => $step,
                ];
            }
            DB::commit();
            return response()->json($response);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        }
        //  catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
    }

    public function storeProfile(StoreProfileRequest $request)
    {
        try {



            $user  = Auth::guard('api')->user();

            if (!empty($request->profile)) {



                $images = $request->profile;



                $profileOldImages = UserProfile::where('user_id', $user->id)->get();
                if (!empty($profileOldImages)) {


                    foreach ($profileOldImages as $oldImages) {
                        if (file_exists(public_path('public/storage/profile/') . $oldImages->profile)) {

                            $imagePath = public_path('public/storage/profile/') . $oldImages->profile;
                            unlink($imagePath);
                        }
                        UserProfile::where('id', $oldImages->id)->delete();
                    }
                }

                DB::beginTransaction();

                foreach ($images as $key => $value) {
                    $is_default = "0";
                    if ($key == 0) {
                        $is_default = "1";
                    }
                    $image = $value;

                    $imageName = $user->id . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('storage/profile'), $imageName);

                    UserProfile::create([

                        'user_id' => $user->id,

                        'profile' => $imageName,

                        'is_default' => $is_default
                    ]);
                }

                DB::commit();


                return response()->json(['status' => true, 'message' => "Profile images stored successfully"]);
            }
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function userPersonality(UserPersonalityRequest $request)
    {
        try {
            DB::beginTransaction();
            // \DB::enableQueryLog();

            $user = Auth::guard('api')->user();
            $lifeStyles = $request->life_styles;
            $interest_and_hobby = $request->interest_and_hobby;
            $zodiac_id = $request->zodiac_id;

            if (isset($lifeStyles) && is_array($lifeStyles)) {
                foreach ($lifeStyles as $val) {
                    $life_style = new UserLifestyle();
                    $life_style->user_id = $request->user_id;
                    $life_style->lifestyle_id = $val;
                    $life_style->save();
                }
            }

            if (isset($interest_and_hobby) && is_array($interest_and_hobby)) {
                foreach ($interest_and_hobby as $val) {
                    $interest_and_hobby = new UserInterestAndHobby();
                    $interest_and_hobby->user_id = $request->user_id;
                    $interest_and_hobby->interest_and_hobby_id = $val;
                    $interest_and_hobby->save();
                }
            }

            if (isset($zodiac_id) && !empty($zodiac_id)) {
                $user_zodiac = UserDetail::where('user_id', $user->id)->first();
                $user_zodiac->userdetail->zodiac_id = $zodiac_id;
                $user_zodiac->userdetail->save();
            }
            DB::commit();

            return response()->json(["status" => true, 'message' => 'Personality are updated']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        }
        // catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
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
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }
}
