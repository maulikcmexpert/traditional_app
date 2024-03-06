<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\{
    UserValidate,
    StoreProfileRequest,
    OrgranizationValid,
    UserPersonalityRequest
};
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


use Illuminate\Support\Facades\Storage;
use App\Models\OrganizationDetail;
use App\Models\SizeOfOrganization;
use App\Models\UserProfile;
use App\Models\UserInterestAndHobby;
use App\Models\UserLifestyle;
use App\Models\UserShwstpprQue;
use App\Models\User;
use App\Models\UserDetail;

use App\Models\UserLoveLang;
use App\Models\UserShwstpperAnswr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
                $user_detail->city_id = $request->city_id;
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
            $token = Token::where('user_id', $user->id)->first();

            if ($token) {
                $token->delete();
            }

            Auth::login($user);

            $token = Auth::user()->createToken('API Token')->accessToken;
            $step = "Home";

            if ($user->user_type == 'user') {
                $user_profile = UserProfile::where('user_id', $user->id)->first();
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

        // catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
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

            return response()->json(["status" => true, 'message' => 'Love language rates are updated']);
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
            $full_name = $this->user->full_name;
            $mobile_number = $this->user->mobile_number;
            $email = $this->user->email;
            $data = [];
            $data = [
                'name' => $full_name,
                'mobile_number' => $mobile_number,
                'email' => $email,
            ];
            if ($user_id) {
                $organization_detail = OrganizationDetail::where('organization_id', $user_id)->get();
                $data['established_year'] = $organization_detail[0]->established_year;
                $data['address'] = $organization_detail[0]->address;
                $data['about_us'] = $organization_detail[0]->about_us;
                $sizeofchurch = SizeOfOrganization::where('id', $organization_detail[0]->size_of_organization_id)->get();
                $data['size_of_church'] = $sizeofchurch[0]->size_range;
                $user_profile = UserProfile::where('user_id', $user_id)->get();
                $image = [];
                foreach ($user_profile as $key => $val) {
                    $image['profile'] = asset('public/storage/profile/' . $val->profile);
                    $image['is_default'] = $val->is_default;
                    $data['profile_image'][] = $image;
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'data' => $data]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function updateUserprofile(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string',
                'state_id' => 'required|integer',
                'city_id' => 'required|integer',
                'organization_id' => 'required|string',
                'zodiac_sign_id' => 'required|integer',
                'religion_id' => 'required|integer',
                'about_me' => 'required|string',
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
                'education' => 'required|string',
                'life_style.*' => 'required|array',
                'insert_hobby.*' => 'required|array',
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
            $user_detail->save();
            UserLifestyle::where('user_id', $user_id)->delete();
            foreach ($request->life_style as $key => $lifeval) {

                $updatelifestyle = new UserLifestyle();
                $updatelifestyle->user_id = $user_id;
                $updatelifestyle->lifestyle_id = $lifeval['id'];
                $updatelifestyle->save();
            }
            UserInterestAndHobby::where('user_id', $user_id)->delete();
            foreach ($request->instert_hobby as $key => $instert_hobby) {
                $updatelifestyle = new UserInterestAndHobby();
                $updatelifestyle->user_id = $user_id;
                $updatelifestyle->interest_and_hobby_id = $instert_hobby['id'];
                $updatelifestyle->save();
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
                'city_id' => 'required|integer',
                'organization_id' => 'required|string',
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
            if ($request->type == "add_img") {
                if (!empty($request->profile_image)) {
                    $image = $request->profile_image;

                    $imageName = time() . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('storage/profile'), $imageName);
                }
                $profile_add = new UserProfile();
                $profile_add->user_id = $this->user->id;
                $profile_add->profile = $imageName;
                $profile_add->save();
                DB::commit();
                return response()->json(['status' => true, 'message' => "Profile add"]);
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

                    $imageName = time() . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('storage/profile'), $imageName);
                };
                $profile_img = UserProfile::where('id', $request->profile_id)->first();
                $profile_img->profile = $imageName;
                $profile_img->save();
                DB::commit();
                return response()->json(['status' => true, 'message' => "Profile  update"]);
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
                'userdetail', 'userdetail.city',
                'userdetail.state'
            ])->whereIn('id', $femaleDataArray);
            $result =  $users->get();

            $userData = [];

            foreach ($result as $val) {
                $userInfo['id'] = $val->id;
                $profile = UserProfile::select('profile')->where('is_default', '1')->first();
                $userInfo['name'] = $val->full_name;
                $userInfo['profile'] = ($profile != null && !empty($profile->profile)) ? asset('public/storage/profile/' . $profile->profile) : "";
                $userInfo['age'] = calculateAge($val->userdetail->date_of_birth, date('Y-m-d'));
                $userInfo['city'] = $val->userdetail->city->city;
                $userInfo['state'] = $val->userdetail->state->state;
                $userInfo['latitude'] = $data['female'][$val->id]['latitude'];
                $userInfo['longitude'] = $data['female'][$val->id]['longitude'];

                $userData[] = $userInfo;
            }
            return response()->json(["status" => true, 'message' => 'User data', 'data' => $userData]);
        } catch (QueryException $e) {
            return response()->json(['status' => false, 'message' => "Database error"]);
        }
        // catch (\Exception $e) {
        //     return response()->json(['status' => false, 'message' => "Something went wrong"]);
        // }
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
            dd($val['question_id']);
            $checkAns = UserShwstpprQue::where('id', $val->question_id)->first();
            if ($checkAns->prefered_option == $val->prefered_answer) {
                $trueAns++;
            } else {
                $wrongQue[] = $checkAns->question;
            }

            $user_shwstpper_answrs = new UserShwstpperAnswr();
            $user_shwstpper_answrs->user_id = $user->id;
            $user_shwstpper_answrs->question_id = $val->question_id;
            $user_shwstpper_answrs->user_id = $val->prefered_answer;
            $user_shwstpper_answrs->save();
        }
        $checkTotalQue = UserShwstpprQue::where('user_id', $questioner_user_id)->count();

        if ($checkTotalQue == $trueAns) {
            return response()->json(["status" => true, 'message' => 'you are eligible for relationship', 'data' => $wrongQue]);
        } else {
            return response()->json(["status" => false, 'message' => 'She is not open for reletionship', 'data' => $wrongQue]);
        }
    }
}
