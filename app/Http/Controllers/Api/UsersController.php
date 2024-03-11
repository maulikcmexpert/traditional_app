<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\{
    UserValidate,
    StoreProfileRequest,
    OrgranizationValid,
    UserPersonalityRequest
};
use App\Models\City;

use App\Models\InterestAndHobby;
use App\Models\ProfileSeenUser;
use App\Models\Lifestyle;
use App\Models\Religion;
use App\Models\State;
use App\Models\ZodiacSign;

use App\Models\ApproachRequest;
use App\Models\Country;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\OrganizationDetail;
use App\Models\SizeOfOrganization;
use App\Models\UserProfile;
use App\Models\UserInterestAndHobby;
use App\Models\UserLifestyle;
use App\Models\UserShwstpprQue;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Device;


use App\Models\UserLoveLang;
use App\Models\UserShwstpperAnswr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use FireStore\ApiMethods\Commit;
use Laravel\Passport\Token;
use Illuminate\Database\QueryException;

class UsersController extends BaseController
{

    protected $perPage;
    protected $user;

    public function __construct()
    {

        $this->perPage = 5;
        $this->user = Auth::guard('api')->user();
    }


    public function userSignup(UserValidate $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->full_name = $request->full_name;

            $getCountry = Country::where('iso', $request->country_code)->first();

            $user->country_id = $getCountry->id;
            $user->country_code = $request->country_dial;
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
                $user_detail->city = $request->city;
                $user_detail->state_id = $request->state_id;
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
        }
        //  catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
    }

    public function organizationSignup(OrgranizationValid $request)
    {
        try {
            DB::beginTransaction();


            $organization = new User();
            $organization->full_name = $request->organization_name;
            $getCountry = Country::where('iso', $request->country_code)->first();

            $organization->country_id = $getCountry->id;
            $organization->country_code = $request->country_dial;
            $organization->mobile_number = $request->mobile_number;
            $organization->email = $request->email;
            $organization->user_type = 'organization';
            $randomNumber = rand(1000, 9999);
            $organization->otp = $randomNumber;
            if ($organization->save()) {
                $organizationId = $organization->id;
                if (!empty($request->organization_profile)) {


                    $image = $request->organization_profile;

                    $imageName = $organizationId . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('storage/profile'), $imageName);

                    $storeorganizationImage = new userProfile();
                    $storeorganizationImage->user_id = $organizationId;
                    $storeorganizationImage->profile = $imageName;
                    $storeorganizationImage->is_default = '1';
                    $storeorganizationImage->save();
                }


                $organization_detail = new OrganizationDetail();
                $organization_detail->organization_id = $organizationId;
                $organization_detail->size_of_organization_id = $request->size_of_organization;
                $organization_detail->established_year = date('Y-m-d', strtotime($request->established_year));
                $organization_detail->city = $request->city;
                $organization_detail->state = $request->state_id;
                $organization_detail->address = $request->address;
                // $organization_detail->about_us = $request->about_us;
                $organization_detail->save();
            }

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
            $user = User::with('user_profile')->where('mobile_number', $mobile_number)
                ->where('otp', $otp)
                ->first();

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Invalid OTP']);
            }
            $givenDatetime = $user->updated_at;

            $expirationDatetime = Carbon::parse($givenDatetime);


            $expirationDatetime->addSeconds(30);

            $currentDatetime = Carbon::now();
            if ($currentDatetime->gt($expirationDatetime)) {
                $user->otp = '';
                $user->save();
                return response()->json(["status" => false, 'message' => 'OTP has expired']);
            }
            $user->is_verified = '1';
            $user->save();
            $this->userDevice($user->id, $request);
            $token = Token::where('user_id', $user->id)->first();

            if ($token) {
                $token->delete();
            }

            Auth::login($user);

            $token = Auth::user()->createToken('API Token')->accessToken;
            $step = "Home";

            if ($user->user_type == 'user') {
                $user_profile = UserProfile::where(['user_id' => $user->id, 'is_default' => '1'])->first();
                $user_lifeStyle = UserLifestyle::where('user_id', $user->id)->exists();
                $userLoveLangrate = UserLoveLang::where('user_id', $user->id)->exists();

                if ($user_profile == null) {
                    $step = "Profile";
                }

                if ($user_lifeStyle == false && $user_profile != null) {
                    $step = "Zodiac";
                }

                if ($userLoveLangrate == false && $user_lifeStyle == true && $user_profile != null) {
                    $step = "Rate";
                }

                $response = [
                    'status' => true,
                    'message' => __('messages.otp_verify'),
                    'access_token' => $token,
                    'name' => $user->full_name,
                    'profile' => ($user_profile != null) ? asset('public/storage/profile/' . $user_profile->profile) : "",
                    'gender' => $user->userdetail->gender,
                    'user_type' => $user->user_type,
                    'user_id' => $user->id,
                    'step' => $step,
                ];
            } elseif ($user->user_type == 'organization') {
                $user_profile = UserProfile::where(['user_id' => $user->id, 'is_default' => '1'])->first();
                $response = [
                    'status' => true,
                    'message' => __('messages.otp_verify'),
                    'access_token' => $token,
                    'name' => $user->full_name,
                    'profile' => ($user_profile != null) ? asset('public/storage/profile/' . $user_profile->profile) : "",
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
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function storeProfile(StoreProfileRequest $request)
    {
        try {




            if (!empty($request->profile)) {



                $images = $request->profile;



                $profileOldImages = UserProfile::where('user_id', $this->user->id)->get();
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

                    $imageName = $this->user->id . '_' . $key . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('storage/profile'), $imageName);

                    UserProfile::create([

                        'user_id' => $this->user->id,

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

    public function userPersonalities(UserPersonalityRequest $request)
    {
        try {
            DB::beginTransaction();



            $lifeStyles = $request->life_styles;
            $interest_and_hobby = $request->interest_and_hobby;
            $zodiac_sign_id = $request->zodiac_sign_id;

            if (isset($lifeStyles) && is_array($lifeStyles)) {
                // if exists then delete prev data //

                UserLifestyle::where('user_id', $this->user->id)->delete();

                foreach ($lifeStyles as $val) {
                    $life_style = new UserLifestyle();
                    $life_style->user_id = $this->user->id;
                    $life_style->lifestyle_id = $val;
                    $life_style->save();
                }
            }

            if (isset($interest_and_hobby) && is_array($interest_and_hobby)) {
                // if exists then delete prev data //
                UserInterestAndHobby::where('user_id', $this->user->id)->delete();
                foreach ($interest_and_hobby as $val) {
                    $interest_and_hobby = new UserInterestAndHobby();
                    $interest_and_hobby->user_id = $this->user->id;
                    $interest_and_hobby->interest_and_hobby_id = $val;
                    $interest_and_hobby->save();
                }
            }

            if (isset($zodiac_sign_id) && !empty($zodiac_sign_id)) {
                $user_zodiac = UserDetail::where('user_id', $this->user->id)->first();
                $user_zodiac->zodiac_sign_id = $zodiac_sign_id;
                $user_zodiac->save();
            }
            DB::commit();

            return response()->json(["status" => true, 'message' => 'Personality are updated']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function userLoveLangRate(Request $request)
    {
        try {
            DB::beginTransaction();


            $params = $request->json()->all();

            $lang_keys = array_keys($params);

            $checkExist = UserLoveLang::where('user_id', $this->user->id)->delete();


            foreach ($lang_keys as $val) {

                $user_love_lang = new UserLoveLang();
                $user_love_lang->love_lang = $val;
                $user_love_lang->user_id = $this->user->id;
                $user_love_lang->rate = $request[$val];
                $user_love_lang->save();
            }


            DB::commit();


            return response()->json(["status" => true, 'message' => 'Love language rates are updated', 'profile' => getProfile($this->user->id)]);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function addShowsStoperQues(Request $request)
    {
        try {
            DB::beginTransaction();

            $checkCount = UserShwstpprQue::where('user_id', $this->user->id)->count();
            if ($checkCount <= 3) {
                foreach ($request->question as $questions) {
                    $que = new UserShwstpprQue();
                    $que->user_id = $this->user->id;
                    $que->question = $questions['question'];
                    $que->option_1 = $questions['option_1'];
                    $que->option_2 = $questions['option_2'];
                    $que->prefered_option = $questions['prefered_option'];
                    $que->save();
                }
                DB::commit();
                return response()->json(["status" => true, 'message' => 'Shows stoppers question created successfully']);
            }
            return response()->json(["status" => false, 'message' => 'Shows stoppers question not create more then 3 questions']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function organizationProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            $user_id = $this->user->id;
            $full_name = ($this->user->full_name != "") ? $this->user->full_name : "";
            $mobile_number = ($this->user->mobile_number != "") ? $this->user->mobile_number : "";
            $email = ($this->user->email != "") ? $this->user->email : "";
            // dd($this->user);
            $data = [];
            $data = [
                'name' => $full_name,
                'mobile_number' => $mobile_number,
                'email' => $email,
            ];

            if ($user_id) {

                $country = Country::where('id', $this->user->country_id)->first();
                dd($country);
                $count = UserDetail::where('organization_id', $user_id)->get();
                $data['member_count'] = (count($count) != "") ? count($count) : "";
                $organization_detail = OrganizationDetail::where('organization_id', $user_id)->get();
                $data['established_year'] = (date('d-m-Y', strtotime($organization_detail[0]->established_year)) != "") ? date('d-m-Y', strtotime($organization_detail[0]->established_year)) : "";
                $data['address'] = ($organization_detail[0]->address != "") ? $organization_detail[0]->address : "";
                $data['about_us'] = ($organization_detail[0]->about_us != "") ? $organization_detail[0]->about_us : " ";
                $data['state'] = ($organization_detail[0]->state != "") ? $organization_detail[0]->state : "";
                $data['country_code'] = ($this->user->country_code != "") ? $this->user->country_code : "";
                $stateVal = State::where('id', $organization_detail[0]->state)->select('state')->get();
                $data['state_name'] = "";
                if (count($stateVal)) {
                    $data['state_name'] = $stateVal[0]->state;
                }
                $data['city'] = ($organization_detail[0]->city != "") ? $organization_detail[0]->city : "";
                $cityVal = City::where('id', $organization_detail[0]->city)->select('city')->get();
                $data['city_name'] = "";
                if (count($cityVal)) {
                    $data['city_name'] = $cityVal[0]->city;
                }
                $sizeofchurch = SizeOfOrganization::where('id', $organization_detail[0]->size_of_organization_id)->get();
                $data['size_of_church'] = "";
                $data['size_of_church_id'] = "";
                if (count($sizeofchurch)) {
                    $data['size_of_church'] = $sizeofchurch[0]->size_range;
                    $data['size_of_church_id'] = $sizeofchurch[0]->id;
                }

                $user_profile = UserProfile::where('user_id', $user_id)->get();

                $data['profile_image'] = [];
                if (!empty($user_profile[0])) {
                    foreach ($user_profile as $key => $val) {

                        $image['profile_id'] = $val->id;
                        $image['profile'] = asset('storage/profile/' . $val->profile);
                        $image['is_default'] = $val->is_default;
                        $data['profile_image'][] = $image;
                    }
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => "Suceess", 'data' => $data]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function userProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            $user_id = $this->user->id;
            $full_name = ($this->user->full_name != "") ? $this->user->full_name : "";
            $mobile_number = ($this->user->mobile_number != "") ? $this->user->mobile_number : "";
            $email = ($this->user->email != "") ? $this->user->email : "";
            $data = [];
            $data = [
                'name' => $full_name,
                'mobile_number' => $mobile_number,
                'email' => $email,
            ];
            $user = User::with('userdetail', 'userdetail.religon', 'userdetail.zodiac_sign', 'userdetail.state', 'userdetail.organization')->where('id', $user_id)->first();
            if ($user_id) {
                $data['country_code'] = ($user->country_code != "") ? $user->country_code : "";
                $data['height_type'] = ($user['userdetail']->height_type != "") ? $user['userdetail']->height_type : "";
                $data['about_me'] = ($user['userdetail']->about_me != "") ? $user['userdetail']->about_me : "";
                $data['state_id'] = ($user['userdetail']->state_id != "") ? $user['userdetail']->state_id : "";
                $data['date_of_birth'] = (date('d-m-Y', strtotime($user['userdetail']->date_of_birth)) != "") ? date('d-m-Y', strtotime($user['userdetail']->date_of_birth)) : "";
                $data['height'] = ($user['userdetail']->height != "") ? $user['userdetail']->height : "";
                $data['weight'] = ($user['userdetail']->weight != "") ? $user['userdetail']->weight : "";
                $data['education'] = ($user['userdetail']->education != "") ? $user['userdetail']->education : "";
                $data['religion_id'] = ($user['userdetail']->religion_id != "") ? $user['userdetail']->religion_id : "";
                $data['religion_name'] = ($user['userdetail']['religon'] != "") ? $user['userdetail']['religon']->religion : "";
                $data['zodiac_sign_id'] = ($user['userdetail']->zodiac_sign_id != "") ? $user['userdetail']->zodiac_sign_id : "";
                $data['zodiac_signs_name'] = ($user['userdetail']['zodiac_sign']->zodiac_sign != "") ? $user['userdetail']['zodiac_sign']->zodiac_sign : "";
                $data['state_name'] = ($user['userdetail']['state']->state != "") ? $user['userdetail']['state']->state : "";
                $data['city_id'] = ($user['userdetail']->city_id != "") ? $user['userdetail']->city_id : "";
                $data['city_name'] = ($user['userdetail']['city']->city != "") ? $user['userdetail']['city']->city : "";
                $data['organization_id'] = ($user['userdetail']->organization_id != "") ? $user['userdetail']->organization_id : "";
                $data['organization_name'] = ($user['userdetail']['organization']->full_name != "") ? $user['userdetail']['organization']->full_name : "";
                $user_lifestyle = UserLifestyle::where('user_id', $user_id)->get();
                $data['life_style'] = [];
                if (count($user_lifestyle)) {
                    foreach ($user_lifestyle as $key => $val) {

                        $lifestyle['id'] = $val->id;
                        $lifestyleVal = Lifestyle::where('id', $val->lifestyle_id)->select('life_style')->get();

                        $lifestyle['name'] = $lifestyleVal[0]->life_style;
                        $data['life_style'][] = $lifestyle;
                    }
                }
                $user_intrest_hobby = UserInterestAndHobby::where('user_id', $user_id)->get();
                $data['intrest_and_hobby'] = [];
                if (count($user_intrest_hobby)) {

                    foreach ($user_intrest_hobby as $key => $val) {
                        $intrest_hobby['id'] = $val->id;
                        $lifestyleVal = InterestAndHobby::where('id', $val->interest_and_hobby_id)->select('interest_and_hobby')->get();

                        $intrest_hobby['name'] = $lifestyleVal[0]->interest_and_hobby;
                        $data['intrest_and_hobby'][] = $intrest_hobby;
                    }
                }
                $user_profile = UserProfile::where('user_id', $user_id)->get();
                $data['profile_image'] = [];
                if (count($user_profile)) {
                    foreach ($user_profile as $key => $val) {
                        $image['profile_id'] = $val->id;
                        $image['profile'] = asset('storage/profile/' . $val->profile);
                        $image['is_default'] = $val->is_default;
                        $data['profile_image'][] = $image;
                    }
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => "Success", 'data' => $data]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function showUserProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            $user_id = $request->user_id;
            if ($user_id) {
                $addshowprofile = new ProfileSeenUser();
                $addshowprofile->profile_id = $user_id;
                $addshowprofile->profile_viewer_id = $this->user->id;
                $addshowprofile->save();

                $user = User::with('userdetail', 'userdetail.religon', 'userdetail.zodiac_sign', 'userdetail.state', 'country', 'userdetail.organization')->where('id', $user_id)->first();

                $full_name = ($user->full_name != "") ? $user->full_name : "";
                $mobile_number = ($user->mobile_number != "") ? $user->mobile_number : "";
                $email = ($user->email != "") ? $user->email : "";
                $data = [];
                $data = [
                    'name' => $full_name,
                    'mobile_number' => $mobile_number,
                    'email' => $email,
                ];
                if ($user != null) {

                    $data['country_code'] = ($user->country_code != "") ? $user->country_code : "";
                    $data['height_type'] = ($user->userdetail->height_type != "") ? $user->userdetail->height_type : "";
                    $data['about_me'] = ($user->userdetail->about_me != "") ? $user->userdetail->about_me : "";
                    $data['state_id'] = ($user->userdetail->state_id != "") ? $user->userdetail->state_id : "";
                    $data['date_of_birth'] = (date('d-m-Y', strtotime($user->userdetail->date_of_birth)) != "") ? date('d-m-Y', strtotime($user->userdetail->date_of_birth)) : "";
                    $data['height'] = ($user->userdetail->height != "") ? $user->userdetail->height : "";
                    $data['weight'] = ($user->userdetail->weight != "") ? $user->userdetail->weight : "";
                    $data['education'] = ($user->userdetail->education != "") ? $user->userdetail->education : "";
                    $data['religion'] = ($user->userdetail->religon != "") ? $user->userdetail->religon->religion : "";
                    $data['zodiac_sign'] = ($user->userdetail->zodiac_sign->zodiac_sign != "") ? $user->userdetail->zodiac_sign->zodiac_sign : "";
                    $data['state'] = ($user->userdetail->state->state != "") ? $user->userdetail->state->state : "";
                    $data['city'] = ($user->userdetail->city != null) ? $user->userdetail->city : "";
                    $data['country'] = ($user->country->country != null) ? $user->country->country : "";
                    $data['organization_id'] = ($user->userdetail->organization_id != null) ? $user->userdetail->organization_id : "";
                    $data['organization_name'] = ($user->userdetail->organization_id != null)  ? $user->userdetail->organization->full_name : "";
                    $user_lifestyle = UserLifestyle::where('user_id', $user_id)->get();
                    $data['life_style'] = [];
                    if (count($user_lifestyle)) {
                        foreach ($user_lifestyle as $key => $val) {
                            $lifestyle['id'] = $val->id;
                            $lifestyleVal = Lifestyle::where('id', $val->lifestyle_id)->select('life_style')->get();

                            $lifestyle['name'] = $lifestyleVal[0]->life_style;
                            $data['life_style'][] = $lifestyle;
                        }
                    }
                    $user_intrest_hobby = UserInterestAndHobby::where('user_id', $user_id)->get();
                    $data['intrest_and_hobby'] = [];
                    if (count($user_intrest_hobby)) {

                        foreach ($user_intrest_hobby as $key => $val) {
                            $intrest_hobby['id'] = $val->id;
                            $lifestyleVal = InterestAndHobby::where('id', $val->interest_and_hobby_id)->select('interest_and_hobby')->get();

                            $intrest_hobby['name'] = $lifestyleVal[0]->interest_and_hobby;
                            $data['intrest_and_hobby'][] = $intrest_hobby;
                        }
                    }
                    $user_profile = UserProfile::where('user_id', $user_id)->get();

                    $data['profile_image'] = [];
                    if (count($user_profile)) {
                        foreach ($user_profile as $key => $val) {
                            $image['profile_id'] = $val->id;
                            $image['profile'] = asset('storage/profile/' . $val->profile);
                            $image['is_default'] = $val->is_default;
                            $data['profile_image'][] = $image;
                        }
                    }

                    if ($user->userdetail->gender == 'male') {
                        $approch_check = ApproachRequest::where(' ', $this->user->id)->where('type', "approch")->where('status', 'accepted')->first();
                        $check_pending = ApproachRequest::where('sender_id', $this->user->id)->where('receiver_id', $user_id)->where('type', "approch")->select('sender_id', 'receiver_id', 'status')->first();

                        if ($approch_check != null && $approch_check->status == 'accepted') {
                            $data['is_approach'] = "not approachable";
                        } else if ($check_pending != null && $check_pending->status == "accepted") {
                            $data['is_approach'] = "message";
                        } else if ($check_pending != null && $check_pending->status == 'pending') {

                            $data['is_approach'] = "withdrawn";
                        } else {
                            $data['is_approach'] = "approachable";
                        }
                    } else if ($user->userdetail->gender == 'female') {

                        $approch_check = ApproachRequest::where('sender_id', $this->user->id)->withTrashed()->ordeBy('id', 'DESC')->first();
                        // $check_pending = ApproachRequest::where('sender_id', $this->user->id)->where('receiver_id', $user_id)->where('type', "approch")->select('sender_id', 'receiver_id', 'status')->first();
                        if ($approch_check != null) {

                            if ($approch_check->status == 'accepted') {
                                $data['is_approach'] = "message";
                            } else if ($approch_check->status == 'pending') {
                                $data['is_approach'] = "cancel";
                            } else if ($approch_check->status == 'cancel') {


                                $loginUserLatlong = $this->getLoginUserLatlog($this->user->id);
                                $seenProfileUser = $this->getLoginUserLatlog($user_id);

                                $distance = distanceCalculation($loginUserLatlong['latitude'], $loginUserLatlong['longitude'], $seenProfileUser['latitude'], $seenProfileUser['longitude']);

                                $data['is_approach'] = "friend";
                                if ($distance <= 5) {
                                    $data['is_approach'] = "approach";
                                }
                            }
                        } else {
                            if ($this->user->userdetail->gender == 'male') {

                                $status = $this->checkRelationStatus($user_id);
                                if ($status == 'pending') {
                                    $data['is_approach'] = "cancel";
                                } elseif ($status == 'accepted') {
                                    $data['is_approach'] = "message";
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => "Success", 'data' => $data]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function checkRelationStatus($user_id)
    {
        $checkShwStopperQues = UserShwstpprQue::where('user_id', $user_id)->pluck('id');

        if (count($checkShwStopperQues) != 0) {
            $checkUserAns = UserShwstpperAnswr::where('user_id', $this->user->id)->whereIn('question_id', $checkShwStopperQues)->pluck('answer_status');


            if (count($checkUserAns) != 0) {

                if (in_array('0', $checkUserAns->toArray())) {
                    return "question_wrong";
                }
            }
        }
        $checkIsApproched = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' => $user_id])->withTrashed()->first();
        if ($checkIsApproched != null) {
            if ($checkIsApproched->status == 'pending') {

                return $checkIsApproched->status;
            }
            if ($checkIsApproched->status == 'rejected') {
                return $checkIsApproched->status;
                if ($checkIsApproched->status == 'accepted') {
                    return $checkIsApproched->status;
                }
            }



            return response()->json(["status" => true, 'message' => 'you are elegible']);
        }
    }

    public function getLoginUserLatlog($user_id)
    {
        $serviceAccount = base_path('app/Http/Controllers/Api/firebase-credentials.json');
        $factory = (new Factory())->withServiceAccount($serviceAccount);
        $database = $factory->createDatabase();
        // Retrieve data
        $data = $database->getReference('/user_locations')->getValue();

        $loginUserGender = UserDetail::select('gender')->where('user_id', $user_id)->first();
        $latitude = "0";
        $longitude = "0";
        if ($loginUserGender->gender == 'male') {

            $maleIds = array_keys($data['male']);
            if (in_array($user_id, $maleIds)) {
                $loginUserData = $data['male'][$user_id];
                $latitude = $loginUserData['latitude'];
                $longitude = $loginUserData['longitude'];
            }
        } elseif ($loginUserGender->gender == 'female') {
            $femaleIds = array_keys($data['female']);
            if (in_array($user_id, $femaleIds)) {
                $loginUserData = $data['female'][$user_id];
                $latitude = $loginUserData['latitude'];
                $longitude = $loginUserData['longitude'];
            }
        }
        return array("latitude" => $latitude, 'longitude' => $longitude);
    }

    public function updateUserprofile(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string',
                'state_id' => 'required|integer',
                'city_id' => 'required|integer',
                'organization_id' => 'required|integer',
                'zodiac_sign_id' => 'required|integer',
                'religion_id' => 'required|integer',
                'about_me' => 'required|string',
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
                'education' => 'required|string',
                'life_styles' => ['required', 'array'],
                'life_styles.*' => ['integer'],
                'interest_and_hobby' => ['required', 'array'],
                'interest_and_hobby.*' => ['integer'],
            ]);

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }
            $user_id = $this->user->id;
            $user = User::where('id', $user_id)->first();
            $user->full_name = $request->full_name;
            $user->save();
            $user_detail = UserDetail::where('user_id', $user_id)->first();
            $user_detail->state_id = $request->state_id;
            $user_detail->city_id = $request->city_id;
            $user_detail->height = $request->height;
            $user_detail->weight = $request->weight;
            $user_detail->education = $request->education;
            $user_detail->zodiac_sign_id = $request->zodiac_sign_id;
            $user_detail->organization_id = $request->organization_id;
            $user_detail->religion_id = $request->religion_id;
            $user_detail->about_me = $request->about_me;
            $user_detail->height_type = $request->height_type;
            // dd($user_detail)
            $user_detail->save();
            // UserLifestyle::where('user_id', $user_id)->delete();
            $lifeStyles = $request->life_styles;
            $interest_and_hobby = $request->interest_and_hobby;
            if (isset($lifeStyles) && is_array($lifeStyles)) {
                // if exists then delete prev data //
                UserLifestyle::where('user_id', $this->user->id)->delete();
                foreach ($lifeStyles as $val) {
                    $life_style = new UserLifestyle();
                    $life_style->user_id = $this->user->id;
                    $life_style->lifestyle_id = $val;
                    $life_style->save();
                }
            }
            if (isset($interest_and_hobby) && is_array($interest_and_hobby)) {
                // if exists then delete prev data //
                UserInterestAndHobby::where('user_id', $this->user->id)->delete();
                foreach ($interest_and_hobby as $val) {
                    $interest_and_hobby = new UserInterestAndHobby();
                    $interest_and_hobby->user_id = $this->user->id;
                    $interest_and_hobby->interest_and_hobby_id = $val;
                    $interest_and_hobby->save();
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => "Profile update successfully"]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function updateOrganizationprofile(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string',
                'state_id' => 'required|integer',
                // 'city_id' => 'required|integer',
                // 'organization_id' => 'required|integer',
                'about_us' => 'required|string',
                'size_of_organization_id' => 'required|integer',
                'established_year' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }
            $user_id = $this->user->id;
            $organization = User::where('id', $user_id)->first();
            $organization->full_name = $request->full_name;
            $organization->save();

            $organization_detail = OrganizationDetail::where('organization_id', $user_id)->first();
            $organization_detail->state = $request->state_id;
            $organization_detail->city = $request->city_id;
            $organization_detail->about_us = $request->about_us;
            $organization_detail->size_of_organization_id = $request->size_of_organization_id;
            $organization_detail->established_year = date('Y-m-d', strtotime($request->established_year));;
            $organization_detail->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Organization update successfully"]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function updateProfilePhoto(Request $request)
    {
        try {
            DB::beginTransaction();
            $checkImageExist = UserProfile::where('user_id', $this->user->id)->count();
            if ($request->type == "add_img") {

                if (!empty($request->profile_image)) {
                    $image = $request->profile_image;
                    $imageName = $this->user->id . '.' . $image->getClientOriginalExtension();
                    if ($checkImageExist != 0) {
                        $giveNum = $checkImageExist + 1;
                        $imageName = $this->user->id . '_' . $giveNum . '.' . $image->getClientOriginalExtension();
                    }

                    $image->move(public_path('storage/profile'), $imageName);
                }
                $profile_add = new UserProfile();
                $profile_add->user_id = $this->user->id;
                $profile_add->profile = $imageName;
                $profile_add->save();
                $user_profile = UserProfile::where('id', $profile_add->id)->select('is_default')->first();

                $profile_img = asset('storage/profile/' . $profile_add->profile);
                DB::commit();
                return response()->json(['status' => true, 'message' => "Profile add", 'profile_id' => $profile_add->id, 'profile' => $profile_img, 'is_default' => $user_profile->is_default]);
            } else if ($request->type == "delete_img") {
                $profile_name = UserProfile::where('id', $request->profile_id)->select('profile')->get()->first();
                $filePath = public_path('storage/profile/' . $profile_name->profile);
                unlink($filePath);
                $profile_delete = UserProfile::where('id', $request->profile_id)->delete();
                DB::commit();
                return response()->json(['status' => true, 'message' => "Profile delete"]);
            } else if ($request->type == "edit_img") {
                $profile = UserProfile::where('id', $request->profile_id)->select('profile')->get()->first();
                $filePath = public_path('storage/profile/' . $profile->profile);
                unlink($filePath);
                if (!empty($request->profile_image)) {
                    $image = $request->profile_image;

                    $imageName = $this->user->id . '.' . $image->getClientOriginalExtension();
                    if ($checkImageExist != 0) {
                        $giveNum = $checkImageExist + 1;
                        $imageName = $this->user->id . '_' . $giveNum . '.' . $image->getClientOriginalExtension();
                    }

                    $image->move(public_path('storage/profile'), $imageName);
                };
                $profile_img = UserProfile::where('id', $request->profile_id)->first();
                $profile_img->profile = $imageName;
                $profile_img->save();
                $profile_photo = asset('storage/profile/' . $profile_img->profile);
                DB::commit();
                return response()->json(['status' => true, 'message' => "Profile  update", 'profile_id' => $profile_img->id, 'profile' => $profile_photo, 'is_default' => $profile_img->is_default]);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function home(Request $request)
    {

        try {
            // Initialize Firebase
            $serviceAccount = base_path('app/Http/Controllers/Api/firebase-credentials.json');
            $factory = (new Factory())->withServiceAccount($serviceAccount);
            $database = $factory->createDatabase();
            // Retrieve data
            $data = $database->getReference('/user_locations')->getValue();
            $user_id = $this->user->id;
            $maleIds = array_keys($data['male']);
            $latitude = "0";
            $longitude = "0";
            if (in_array($user_id, $maleIds)) {
                $loginUserData = $data['male'][$user_id];
                $latitude = $loginUserData['latitude'];
                $longitude = $loginUserData['longitude'];
            }
            $femaleDataArray = [];
            foreach ($data['female'] as $keyId => $val) {

                $distance = distanceCalculation($latitude, $longitude, $val['latitude'], $val['longitude']);

                if ($distance <= 5) {
                    $femaleDataArray[] = $keyId;
                }
            }


            $users = User::query();
            $users->with([
                'userdetail',
                'country',
                'userdetail.state'
            ])->whereIn('id', $femaleDataArray);

            if (isset($request->organization_id) && $request->organization_id != 0) {
                $organizationId = $request->organization_id;

                $users->whereHas('userdetail', function ($query) use ($organizationId) {
                    $query->where('organization_id', $organizationId);
                });
            }
            if (isset($request->religion_id) && $request->religion_id != 0) {
                $religionId = $request->religion_id;

                $users->whereHas('userdetail', function ($query) use ($religionId) {
                    $query->where('religion_id', $religionId);
                });
            }

            if (isset($request->min) && isset($request->max)) {
                $minAge = $request->min;
                $maxAge = $request->max;

                $users->whereHas('userdetail', function ($query) use ($minAge, $maxAge) {
                    $query->whereBetween('date_of_birth', [
                        now()->subYears($maxAge)->format('Y-m-d'),
                        now()->subYears($minAge)->format('Y-m-d'),
                    ]);
                });
            }
            $result = $users->get();


            $userData = [];

            foreach ($result as $val) {

                $userInfo['id'] = $val->id;
                $profile = UserProfile::select('profile')->where(['user_id' => $val->id, 'is_default' => '1'])->first();
                $userInfo['name'] = $val->full_name;
                $userInfo['profile'] = ($profile != null && !empty($profile->profile)) ? asset('storage/profile/' . $profile->profile) : "";
                $userInfo['age'] = calculateAge($val->userdetail->date_of_birth, date('Y-m-d'));
                $userInfo['city'] = ($val->userdetail->city != null) ? $val->userdetail->city : "";
                $userInfo['state'] = $val->userdetail->state->state;
                $userInfo['country'] = $val->country->country;
                $userInfo['latitude'] = $data['female'][$val->id]['latitude'];
                $userInfo['longitude'] = $data['female'][$val->id]['longitude'];

                $userData[] = $userInfo;
            }
            return response()->json(["status" => true, 'message' => 'User data', 'data' => $userData]);
        } catch (QueryException $e) {
            return response()->json(['status' => false, 'message' => "Database error"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Something went wrong"]);
        }
    }



    public function getShowStopperQues(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer', 'exists:users,id'],
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 400);
            }

            $getQuestions = UserShwstpprQue::select('id', 'user_id', 'question', 'option_1', 'option_2', 'prefered_option')->where('user_id', $request->user_id)->get();

            return response()->json(["status" => true, 'message' => 'showstopper ', 'data' => $getQuestions]);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function checkQuesAnswer(Request $request)
    {
        $user = Auth::guard('api')->user();
        $questioner_user_id = $request->user_id;
        $answers = $request->answers;

        $trueAns = 0;
        $wrongQue = [];
        foreach ($answers as $val) {

            $checkAns = UserShwstpprQue::where('id', $val['question_id'])->first();
            if ($checkAns->prefered_option == $val['prefered_answer']) {
                $trueAns++;
            } else {
                $wrongQue[] = $checkAns->question;
            }
            $checAlreadyAnswer = UserShwstpperAnswr::where(['user_id' => $user->id, 'question_id' => $val['question_id']])->first();
            if ($checAlreadyAnswer == null) {

                $user_shwstpper_answrs = new UserShwstpperAnswr();
                $user_shwstpper_answrs->user_id = $user->id;
                $user_shwstpper_answrs->question_id = $val['question_id'];
                $user_shwstpper_answrs->prefered_answer = $val['prefered_answer'];
                $user_shwstpper_answrs->answer_status = '0';
                if ($checkAns->prefered_option == $val['prefered_answer']) {

                    $user_shwstpper_answrs->answer_status = '1';
                }
                $user_shwstpper_answrs->save();
            } else {
                $checAlreadyAnswer->prefered_answer = $val['prefered_answer'];
                $checAlreadyAnswer->answer_status = '0';
                if ($checkAns->prefered_option == $val['prefered_answer']) {
                    $checAlreadyAnswer->answer_status = '1';
                };
                $checAlreadyAnswer->save();
            }
        }
        $checkTotalQue = UserShwstpprQue::where('user_id', $questioner_user_id)->count();

        if ($checkTotalQue == $trueAns) {
            return response()->json(["status" => true, 'message' => 'you are eligible for relationship', 'data' => $wrongQue]);
        } else {
            return response()->json(["status" => false, 'message' => 'She is not open for reletionship', 'data' => $wrongQue]);
        }
    }


    public function approachRequest(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer', 'exists:users,id'],
                'type' => ['required', 'string'],

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            $user = Auth::guard('api')->user();
            $receiver_id = $request->user_id;

            DB::beginTransaction();

            $approch_request = new ApproachRequest();
            $approch_request->sender_id = $user->id;
            $approch_request->receiver_id = $receiver_id;
            $approch_request->status = 'pending';
            $approch_request->type = 'approch';
            $approch_request->save();
            DB::commit();

            return response()->json(["status" => true, 'message' => 'Your approach request has been sent successfully!']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }
    public function checkUserApproachStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer', 'exists:users,id'],
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $checkShwStopperQues = UserShwstpprQue::where('user_id', $request->user_id)->pluck('id');

            if (count($checkShwStopperQues) != 0) {
                $checkUserAns = UserShwstpperAnswr::where('user_id', $this->user->id)->whereIn('question_id', $checkShwStopperQues)->pluck('answer_status');


                if (count($checkUserAns) != 0) {

                    if (in_array('0', $checkUserAns->toArray())) {
                        return response()->json(["status" => false, 'message' => 'She is not open for reletionship']);
                    }
                }
            }
            $checkIsApproched = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' => $request->user_id])->first();
            if ($checkIsApproched != null) {
                if ($checkIsApproched->status == 'pending') {

                    return response()->json(["status" => false, 'message' => 'You have already approach request to this person']);
                }
                if ($checkIsApproched->status == 'rejected') {
                    return response()->json(["status" => false, 'message' => 'You have rejected']);
                }
                if ($checkIsApproched->status == 'accepted') {
                    return response()->json(["status" => false, 'message' => 'commited']);
                }
            }



            return response()->json(["status" => true, 'message' => 'you are elegible']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function manageRequestByMale(Request $request)
    {
        try {

            $page = 1;
            if (isset($request->page) && $request->page != "") {
                $page = $request->page;
            }
            $search_name = "";
            if (isset($request->search_name) && $request->search_name != "") {
                $search_name = $request->search_name;
            }

            $requests = getManageRequestByMale($search_name, $page, $this->user->id);
            $userData = $requests['userData'];
            $total_page = $requests['total_page'];

            return response()->json(["status" => true, 'message' => 'All Requests', 'total_page' => $total_page, 'data' => $userData]);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function manageRequestByFemale(Request $request)
    {
        try {

            $page = 1;
            if (isset($request->page) && $request->page != "") {
                $page = $request->page;
            }

            $type = "pending";
            if (isset($request->type) && $request->type != "") {
                $type = $request->type;
            }

            $requests = getManageRequest($type, $page, $this->user->id);
            $userData = $requests['userData'];
            $total_page = $requests['total_page'];
            $msg = "";
            if ($type == 'pending') {
                $msg = "Pending";
            } elseif ($type == 'rejected') {
                $msg = "Rejected";
            } elseif ($type == 'accepted') {
                $msg = "Accepted";
            }
            // add notification //
            return response()->json(["status" => true, 'message' => $msg . ' Requests', 'total_page' => $total_page, 'data' => $userData]);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function searchUser(Request $request)
    {
        try {

            $page = 1;
            if (isset($request->page) && $request->page != "") {
                $page = $request->page;
            }
            $search_name = "";
            if (isset($request->search_name) && $request->search_name != "") {
                $search_name = $request->search_name;
            }

            $requests = getSearchUser($search_name, $page, $this->user->id);
            $userData = $requests['userData'];
            $total_page = $requests['total_page'];

            return response()->json(["status" => true, 'message' => 'Users', 'total_page' => $total_page, 'data' => $userData]);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }


    public function cancelRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer', 'exists:users,id'],
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $cancelRequest = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' => $request->user_id])->first();

            if ($cancelRequest != null) {
                $cancelRequest->status = 'cancel';
                $cancelRequest->save();
                // Soft delete
                // soft delete //
                $cancelRequest->delete();
                // soft delete //

                return response()->json(["status" => true, 'message' => 'Request canceled successfully']);
            } else {
                return response()->json(["status" => false, 'message' => 'Request not found']);
            }
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function acceptRejectByFemale(Request $request)
    {
        try {
            if ($request->type == 'rejected') {
                $validator = Validator::make($request->all(), [
                    'user_id' => ['required', 'integer', 'exists:users,id'],
                    'type' => ['required', 'string', 'in:accepted,rejected'],
                    'message' => ['required', 'string']
                ]);
            } else {

                $validator = Validator::make($request->all(), [
                    'user_id' => ['required', 'integer', 'exists:users,id'],
                    'type' => ['required', 'string', 'in:accepted,rejected'],

                ]);
            }

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $cancelRequest = ApproachRequest::where(['sender_id' => $request->user_id, 'receiver_id' => $this->user->id])->first();

            if ($cancelRequest != null) {
                if ($request->type == 'rejected') {
                    $cancelRequest->message = $request->message;
                }
                $cancelRequest->status = $request->type;
                $cancelRequest->save();
                // Soft delete
                // soft delete //
                if ($request->type == 'rejected') {

                    $cancelRequest->delete();
                }

                // soft delete //

                // add notification //

                return response()->json(["status" => true, 'message' => 'Request Rejected successfully']);
            } else {
                return response()->json(["status" => false, 'message' => 'Request not found']);
            }
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function logout()

    {

        if (Auth::guard('api')->check()) {


            $check = Device::where('user_id', $this->user->id)->first();

            if ($check != null) {
                $check->delete();
                Token::where('user_id', $this->user->id)->delete();
            }
            return response()->json(['status' => true, 'message' => "Logout successfully"]);
        }
    }


    public function userDevice($id, $requestData)
    {


        if (Device::where('user_id', $id)->exists()) {
            Device::where('user_id', $id)->delete();
        }

        if (
            isset($requestData->device_id) &&
            isset($requestData->device_token) &&
            isset($requestData->model)
        ) {

            $device = new Device;
            $device->user_id = $id;
            $device->device_id = $requestData->device_id;
            $device->device_token = $requestData->device_token;
            $device->model = $requestData->model;
            $device->save();
        }
    }



    public function memberOfOrganization(Request $request)
    {
        try {
            DB::beginTransaction();
            $organization_id = $this->user->id;
            $get_member = UserDetail::with(['user', 'user.user_profile' => function ($query) {
                $query->where('is_default', '1');
            }])->where('organization_id', $organization_id)->select('user_id')->get();


            $data = [];
            foreach ($get_member as $val) {

                $profile['user_id'] = $val->user_id;
                $profile['full_name'] = ($val->user->full_name != "") ? $val->user->full_name  : "";
                $profile['image']  = "";

                if ($val->user->user_profile->isNotEmpty()) {
                    $profile['image'] = asset('storage/profile/' . $val->user->user_profile->first()->profile);
                }
                $data[] = $profile;
            }

            DB::commit();
            return response()->json(["status" => true, 'message' => 'Success', 'data' => $data]);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }
}
