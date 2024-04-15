<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\{
    UserValidate,
    StoreProfileRequest,
    OrgranizationValid,
    UserPersonalityRequest
};
use App\Models\ApproachPreference;
use App\Models\City;

use App\Models\InterestAndHobby;
use App\Models\ProfileSeenUser;
use App\Models\Lifestyle;
use App\Models\Religion;
use App\Models\State;
use App\Models\ZodiacSign;

use App\Models\ApproachRequest;
use App\Models\BadWord;
use App\Models\BlockReason;
use App\Models\BodyType;
use App\Models\Country;
use App\Models\Culture;
use App\Models\DailyActivity;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\OrganizationDetail;
use App\Models\UserProfile;
use App\Models\SizeOfOrganization;
use App\Models\ProfileBlock;
use App\Models\UserInterestAndHobby;
use App\Models\UserLifestyle;
use App\Models\FileSizeMaster;
use App\Models\UserShwstpprQue;

use App\Models\User;
use App\Models\Report;
use App\Models\UserReportChat;

use App\Models\UserDetail;
use App\Models\Device;
use App\Models\EatingHabit;
use App\Models\Exercise;
use App\Models\Faith;
use App\Models\FeedbackReview;
use App\Models\FeedbackReviewList;
use App\Models\Notification;
use App\Models\ProfileVerify;
use App\Models\Setting;
use App\Rules\FullNameValidation;
use App\Rules\OrganizationNameValidation;
use App\Rules\AddressValidation;
use App\Rules\AlphaNumericCity;
use App\Rules\CustomEmailValidation;

use Illuminate\Validation\Rule;

use App\Models\UserLoveLang;
use App\Models\UserShwstpperAnswr;
use App\Models\VerificationObject;
use App\Models\VersionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use FireStore\ApiMethods\Commit;
use Laravel\Passport\Token;
use Illuminate\Database\QueryException;

class UsersController_v2 extends BaseController
{

    protected $perPage;
    protected $user;

    public function __construct()
    {

        $this->perPage = 5;
        $this->user = Auth::guard('api')->user();
    }

    public function deleteMessage()
    {
        $currentTimestamp = Carbon::now();

        $database = Firebase::database();
        $data = $database->getReference('/Overview')->getValue();
        $allUsers = User::select('id')->where('id', '!=', 1)->get()->pluck('id');


        foreach ($allUsers as $value) {
            if (isset($data[$value])) {

                foreach ($data[$value] as $val) {
                    dd($currentTimestamp, ' ' . $val['timeStamp']);
                    $messageTimestamp = Carbon::createFromTimestampMs($val['timeStamp'] / 1000);
                    $daysDifference = $currentTimestamp->diffInDays($messageTimestamp);
                    dd($daysDifference);
                }
            }
        }

        dd($data);
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
            $getCountry = Country::where('iso', $request->country_code)->first();

            $organization->country_id = $getCountry->id;
            $organization->country_code = $request->country_dial;
            $organization->mobile_number = $request->mobile_number;
            $organization->email = $request->email;
            $organization->status = 'active';
            $organization->user_type = 'organization';
            $randomNumber = rand(1000, 9999);
            $organization->otp = $randomNumber;
            if ($organization->save()) {
                $organizationId = $organization->id;
                if (!empty($request->organization_profile) || $request->organization_profile != null) {


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
                $organization_detail->established_year = $request->established_year;
                $organization_detail->city = $request->city;
                $organization_detail->state = $request->state_id;
                $organization_detail->address = $request->address;

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
                'message' => "OTP send successfully",
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
                $profileVerify = ProfileVerify::where('user_id', $user->id)->exists();
                // dd($user_profile);
                if ($user_profile == null) {
                    $step = "Profile";
                }

                // if ($profileVerify == false && $user_profile != null) {
                //     $step = "verify_user";
                // }
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
                    'is_verify' => isVerify($user->id),
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

                    $imageName = $this->user->id . '_' . time() . $key . '.' . $image->getClientOriginalExtension();
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
        // try {
        DB::beginTransaction();



        $lifeStyles = $request->life_styles;
        $interest_and_hobby = $request->interest_and_hobby;
        $faith_id = $request->faith_id;

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

        if (isset($faith_id) && !empty($faith_id)) {
            $faithId = UserDetail::where('user_id', $this->user->id)->first();

            $faithId->faith_id = $faith_id;
            $faithId->save();
        }
        DB::commit();

        return response()->json(["status" => true, 'message' => 'Personality are updated']);
        // } catch (QueryException $e) {

        //     DB::rollBack();

        //     return response()->json(['status' => false, 'message' => "db error"]);
        // } catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
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

            $statusChange = User::where('id', $this->user->id)->first();
            if ($statusChange != null) {
                $statusChange->status = 'active';
                $statusChange->save();
            }

            DB::commit();


            return response()->json(["status" => true, 'message' => 'Love language rates are updated', 'profile' => getProfile($this->user->id), 'is_verify' => isVerify($this->user->id)]);
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

            UserShwstpprQue::where('user_id', $this->user->id)->delete();
            DB::beginTransaction();

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
                // dd($country);
                $count = UserDetail::where('organization_id', $user_id)->get();
                $data['member_count'] = (count($count) != "") ? count($count) : "";
                $organization_detail = OrganizationDetail::where('organization_id', $user_id)->get();
                $data['established_year'] = $organization_detail[0]->established_year;
                $data['address'] = ($organization_detail[0]->address != "") ? $organization_detail[0]->address : "";
                $data['about_us'] = ($organization_detail[0]->about_us != "") ? $organization_detail[0]->about_us : " ";
                $data['state'] = ($organization_detail[0]->state != "") ? $organization_detail[0]->state : "";
                $data['country_code'] = ($country->iso != "") ? $country->iso : "";
                $data['country_dial_code'] = ($this->user->country_code != "") ? $this->user->country_code : "";
                $stateVal = State::where('id', $organization_detail[0]->state)->select('state')->get();
                $data['state_name'] = "";
                if (count($stateVal)) {
                    $data['state_name'] = $stateVal[0]->state;
                }
                $data['city'] = ($organization_detail[0]->city != "") ? $organization_detail[0]->city : "";
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
        // try {
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

        $relationArray = [
            'userdetail',
            'user_profile',
            'user_lifestyle',
            'user_lifestyle.lifestyle',
            'user_interest_and_hobby',
            'user_interest_and_hobby.interest_and_hobby',
            'userdetail.religon',
            'userdetail.faith',
            'userdetail.culture',
            'userdetail.bodytype',
            'userdetail.exercise',
            'userdetail.eating_habit',
            'userdetail.daily_activity',
            'userdetail.state',
            'country',
            'userdetail.organization',
            'user_love_lang'
        ];
        $user = User::with($relationArray)->where(['id' => $user_id, 'status' => 'active'])->first();

        if ($user_id) {
            $data['country_code'] = ($user->country->iso != "") ? $user->country->iso : "";
            $data['country_dial_code'] = ($user->country_code != "") ? $user->country_code : "";
            $data['height_type'] = ($user->userdetail->height_type != "") ? $user->userdetail->height_type : "";
            $data['about_me'] = ($user->userdetail->about_me != "") ? $user->userdetail->about_me : "";
            $data['vaccination_status'] = ($user->userdetail->vaccination_status != "") ? $user->userdetail->vaccination_status : "";
            $data['smoke_status'] = ($user->userdetail->smoke_status != "") ? $user->userdetail->smoke_status : "";
            $data['alcohol_status'] = ($user->userdetail->alcohol_status != "") ? $user->userdetail->alcohol_status : "";
            $data['state_id'] = ($user->userdetail->state_id != "") ? $user->userdetail->state_id : "";
            $data['date_of_birth'] = (date('d-m-Y', strtotime($user->userdetail->date_of_birth)) != "") ? date('d-m-Y', strtotime($user->userdetail->date_of_birth)) : "";
            $data['height'] = ($user->userdetail->height != "") ? $user->userdetail->height : "";
            $data['weight'] = ($user->userdetail->weight != "") ? $user->userdetail->weight : "";
            $data['education'] = ($user->userdetail->education != "") ? $user->userdetail->education : "";
            $data['religion_id'] = ($user->userdetail->religion_id != "") ? $user->userdetail->religion_id : 0;
            $data['religion_name'] = ($user->userdetail['religon'] != "") ? $user->userdetail['religon']->religion : "";
            $data['faith_id'] = ($user->userdetail->faith_id != "") ? $user->userdetail->faith_id : 0;
            $data['faith_name'] = ($user->userdetail->faith_id != "") ? $user->userdetail->faith->faith : "";
            $data['daily_activity_id'] = ($user->userdetail->daily_activity_id != "") ? $user->userdetail->daily_activity_id : 0;
            $data['daily_activity_name'] = ($user->userdetail->daily_activity_id != "") ? $user->userdetail->daily_activity->daily_activity : "";
            $data['body_type_id'] = ($user->userdetail->body_type_id != "") ? $user->userdetail->body_type_id : 0;
            $data['body_type_name'] = ($user->userdetail->body_type_id != "") ? $user->userdetail->bodytype->body_type : "";
            $data['culture_id'] = ($user->userdetail->culture_id != "") ? $user->userdetail->culture_id : 0;
            $data['culture_name'] = ($user->userdetail->culture_id != "") ? $user->userdetail->culture->culture : "";
            $data['exercise_id'] = ($user->userdetail->exercise_id != "") ? $user->userdetail->exercise_id : 0;
            $data['exercise_name'] = ($user->userdetail->exercise_id != "") ? $user->userdetail->exercise->exercise : "";
            $data['eating_habit_id'] = ($user->userdetail->eating_habit_id != "") ? $user->userdetail->eating_habit_id : 0;
            $data['eating_habit_name'] = ($user->userdetail->eating_habit_id != "") ? $user->userdetail->eating_habit->eating_habit : "";
            $data['state_name'] = ($user->userdetail['state']->state != "") ? $user->userdetail['state']->state : "";
            $data['city_name'] = ($user->userdetail->city != "") ? $user->userdetail->city : "";
            $data['organization_id'] = ($user->userdetail->organization_id != "") ? $user->userdetail->organization_id : 0;
            $data['organization_name'] = ($user->userdetail->organization_id != NULL) ? $user->userdetail['organization']->full_name : "";

            $data['life_style'] = [];
            if (!empty($user->user_lifestyle)) {
                foreach ($user->user_lifestyle as $key => $val) {
                    $lifestyle['id'] = $val->lifestyle_id;

                    $lifestyle['name'] = $val->lifestyle->life_style;
                    $data['life_style'][] = $lifestyle;
                }
            }

            $data['intrest_and_hobby'] = [];
            if (!empty($user->user_interest_and_hobby)) {

                foreach ($user->user_interest_and_hobby as $key => $val) {
                    $intrest_hobby['id'] = $val->interest_and_hobby_id;

                    $intrest_hobby['name'] = $val->interest_and_hobby->interest_and_hobby;
                    $data['intrest_and_hobby'][] = $intrest_hobby;
                }
            }

            $data['profile_image'] = [];
            if (!empty($user->user_profile)) {
                foreach ($user->user_profile as $key => $val) {
                    $image['profile_id'] = $val->id;
                    $image['profile'] = asset('storage/profile/' . $val->profile);
                    $image['is_default'] = $val->is_default;
                    $data['profile_image'][] = $image;
                }
            }

            $data['user_love_lang'] = [];
            if (!empty($user->user_love_lang)) {
                foreach ($user->user_love_lang as $key => $val) {
                    $loveLang['id'] = $val->id;
                    $loveLang['love_lang'] = $val->love_lang;
                    $loveLang['rate'] = $val->rate;
                    $data['user_love_lang'][] = $loveLang;
                }
            }


            $data['show_stopper_ques'] = [];
            if ($user->userdetail->gender == 'female') {
                $getQuestions = UserShwstpprQue::select('id', 'user_id', 'question', 'option_1', 'option_2', 'prefered_option')->where('user_id', $user->id)->get();
                $data['show_stopper_ques']  = $getQuestions;
            }
        }
        DB::commit();
        return response()->json(['status' => true, 'message' => "Success", 'data' => $data]);
        // } catch (QueryException $e) {
        //     DB::rollBack();

        //     return response()->json(['status' => false, 'message' => "db error"]);
        // } catch (\Exception $e) {

        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
    }

    public function showUserProfile(Request $request)
    {
        // try {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $is_block = false;
        $user_id = $request->user_id;
        // check user blocked //
        $approch_check_is_block = ProfileBlock::where(['blocker_user_id' => $user_id, 'to_be_blocked_user_id' => $this->user->id])->count();
        if ($approch_check_is_block == 1) {
            return response()->json(['status' => false, 'message' => "User not found"]);
        } else {
            $approch_check_is_block = ProfileBlock::where(['blocker_user_id' => $this->user->id, 'to_be_blocked_user_id' => $user_id])->count();
            if ($approch_check_is_block != null) {
                $is_block = true;
            }
        }
        // check user blocked //
        $isRefresh = (!isset($request->refresh)) ? false : $request->refresh;
        if ($isRefresh == false) {
            $Id1 = $this->user->id;
            $Id2 = $user_id;
            $already_friend = ApproachRequest::where(function ($query) use ($Id1, $Id2) {
                $query->where(function ($query) use ($Id1, $Id2) {
                    $query->where('sender_id', $Id1)
                        ->where('receiver_id', $Id2);
                })->orWhere(function ($query) use ($Id1, $Id2) {
                    $query->where('sender_id', $Id2)
                        ->where('receiver_id', $Id1);
                });
            })
                ->where('status', 'accepted')
                ->orderBy('id', 'DESC')
                ->first();

            if ($already_friend == null) {

                $ProfileSeenUser = new ProfileSeenUser();
                $ProfileSeenUser->profile_id = $user_id;
                $ProfileSeenUser->profile_viewer_id = $this->user->id;
                $ProfileSeenUser->save();
            }
        }


        $user = User::with(['userdetail', 'user_profile', 'user_lifestyle', 'user_lifestyle.lifestyle', 'user_interest_and_hobby', 'user_interest_and_hobby.interest_and_hobby', 'userdetail.religon', 'userdetail.zodiac_sign', 'userdetail.state', 'country', 'userdetail.organization', 'user_love_lang'])->where(['id' => $user_id, 'status' => 'active'])->first();

        $full_name = ($user->full_name != "") ? $user->full_name : "";

        $data = [];
        $data = [
            'name' => $full_name,
        ];

        if ($user != null) {

            $data['gender'] = ($user->userdetail->gender != "") ? $user->userdetail->gender : "";
            $data['country_code'] = ($user->country_code != "") ? $user->country_code : "";
            $data['height_type'] = ($user->userdetail->height_type != "") ? $user->userdetail->height_type : "";
            $data['about_me'] = ($user->userdetail->about_me != "") ? $user->userdetail->about_me : "";
            $data['state_id'] = ($user->userdetail->state_id != "") ? $user->userdetail->state_id : "";
            $data['date_of_birth'] = (date('d-m-Y', strtotime($user->userdetail->date_of_birth)) != "") ? date('d-m-Y', strtotime($user->userdetail->date_of_birth)) : "";
            $data['height'] = ($user->userdetail->height != "") ? $user->userdetail->height : "";
            $data['weight'] = ($user->userdetail->weight != "") ? $user->userdetail->weight : "";
            $data['education'] = ($user->userdetail->education != "") ? $user->userdetail->education : "";
            $data['religion'] = ($user->userdetail->religon != "") ? $user->userdetail->religon->religion : "";
            // $data['zodiac_sign'] = ($user->userdetail->zodiac_sign->zodiac_sign != "") ? $user->userdetail->zodiac_sign->zodiac_sign : "";
            $data['state'] = ($user->userdetail->state->state != "") ? $user->userdetail->state->state : "";
            $data['city'] = ($user->userdetail->city != null) ? $user->userdetail->city : "";
            $data['country'] = ($user->country->country != null) ? $user->country->country : "";
            $data['organization_id'] = ($user->userdetail->organization_id != null) ? $user->userdetail->organization_id : "";
            $data['organization_name'] = ($user->userdetail->organization_id != null)  ? $user->userdetail->organization->full_name : "";
            $data['is_ghost'] = is_ghost($request->user_id);
            $data['is_verify'] = isVerify($request->user_id);

            $data['is_block'] = false;
            $userIsBlock = ProfileBlock::where(['blocker_user_id' => $this->user->id, 'to_be_blocked_user_id' => $user_id])->first();
            if ($userIsBlock != null) {
                $data['is_block'] = true;
            }
            $data['life_style'] = [];
            if (!empty($user->user_lifestyle)) {
                foreach ($user->user_lifestyle as $key => $val) {
                    $lifestyle['id'] = $val->id;
                    $lifestyle['name'] = $val->lifestyle->life_style;
                    $data['life_style'][] = $lifestyle;
                }
            }

            $data['intrest_and_hobby'] = [];
            if (!empty($user->user_interest_and_hobby)) {

                foreach ($user->user_interest_and_hobby  as $key => $val) {
                    $intrest_hobby['id'] = $val->id;
                    $intrest_hobby['name'] = $val->interest_and_hobby->interest_and_hobby;
                    $data['intrest_and_hobby'][] = $intrest_hobby;
                }
            }


            $data['profile_image'] = [];
            if (!empty($user->user_profile)) {
                foreach ($user->user_profile as $key => $val) {
                    $image['profile_id'] = $val->id;
                    $image['profile'] = asset('storage/profile/' . $val->profile);
                    $image['is_default'] = $val->is_default;
                    $data['profile_image'][] = $image;
                }
            }

            $data['user_love_lang'] = [];
            if (!empty($user->user_love_lang)) {
                foreach ($user->user_love_lang as $key => $val) {
                    $loveLang['id'] = $val->id;
                    $loveLang['love_lang'] = $val->love_lang;
                    $loveLang['rate'] = $val->rate;
                    $data['user_love_lang'][] = $loveLang;
                }
            }
            $seenProfileUser = $this->getLoginUserLatlog($user_id);
            $data['latitude'] = $seenProfileUser['latitude'];
            $data['longitude'] = $seenProfileUser['longitude'];
            $data['is_approach'] = "no_button";
            $data['conversation_id'] = "";

            if (!$is_block) {
                if ($this->user->userdetail->gender == 'male' && $user->userdetail->gender == 'female') {

                    $approch_check = null;
                    $from_male_approch_check = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' => $user_id])->withTrashed()->orderBy('id', 'DESC')->first();
                    $from_female_approch_check = ApproachRequest::where(['sender_id' => $user_id, 'receiver_id' => $this->user->id])->withTrashed()->orderBy('id', 'DESC')->first();


                    $loginUserLatlong = $this->getLoginUserLatlog($this->user->id);


                    $distance = distanceCalculation($loginUserLatlong['latitude'], $loginUserLatlong['longitude'], $seenProfileUser['latitude'], $seenProfileUser['longitude']);

                    if ($from_male_approch_check != null && $from_female_approch_check != null) {

                        if ($from_male_approch_check->id < $from_female_approch_check->id) {
                            $approch_check = $from_female_approch_check;
                        } else {
                            $approch_check = $from_male_approch_check;
                        }
                    } else if ($from_male_approch_check != null) {
                        $approch_check = $from_male_approch_check;
                    } else if ($from_female_approch_check != null) {
                        $approch_check = $from_female_approch_check;
                    }

                    if ($approch_check != null) {
                        $data['relation_type'] = $approch_check->type;

                        if ($approch_check->status == 'accepted') {
                            $data['conversation_id'] = $approch_check->conversation_id;
                            $data['is_approach'] = "message";
                        } else if ($approch_check->status == 'pending') {

                            if ($approch_check->sender_id == $this->user->id) {

                                $data['is_approach'] = "cancel";
                            } else {
                                $data['is_approach'] = "accept_reject";
                            }

                            if ($approch_check->type == 'approach') {
                                $data['is_approach'] = "withdrawn";
                            }
                        } else if (($approch_check->status == 'cancelled') || ($approch_check->status == 'leave') || ($approch_check->status == 'unblock') || ($approch_check->status == 'rejected' &&  ($approch_check->type == 'approach' || $approch_check->type == 'friend'))) {


                            $data['is_approach'] = "friend";
                            $approchOwncheck = ApproachRequest::where(['sender_id' => $this->user->id, 'type' => 'approach', 'status' => 'accepted',])->withTrashed()->orderBy('id', 'DESC')->first();
                            $female_approch_check = ApproachRequest::where(['receiver_id' => $user_id, 'type' => 'approach', 'status' => 'accepted'])->withTrashed()->orderBy('id', 'DESC')->first();

                            if ($approchOwncheck == null && $female_approch_check == null) {

                                if ($distance <= 5) {
                                    $data['is_approach'] = "approach";
                                }
                            }
                        }
                    } else {

                        $approchOwncheck = ApproachRequest::where(['sender_id' => $this->user->id, 'type' => 'approach', 'status' => 'accepted',])->withTrashed()->orderBy('id', 'DESC')->first();
                        $female_approch_check = ApproachRequest::where(['receiver_id' => $user_id, 'type' => 'approach', 'status' => 'accepted'])->withTrashed()->orderBy('id', 'DESC')->first();

                        if ($approchOwncheck == null && $female_approch_check == null) {


                            $data['is_approach'] = "friend";
                            if ($distance <= 5) {
                                $data['is_approach'] = "approach";
                            }
                        }

                        if ($approchOwncheck != null) {

                            $data['is_approach'] = "friend";
                        }


                        if ($female_approch_check != null) {

                            $data['is_approach'] = "friend";
                        }
                    }
                } elseif ($this->user->userdetail->gender == 'female' && $user->userdetail->gender == 'male') {


                    $approch_check = null;
                    $from_male_approch_check = ApproachRequest::where(['sender_id' => $user_id, 'receiver_id' => $this->user->id])->withTrashed()->orderBy('id', 'DESC')->first();
                    $from_female_approch_check = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' =>  $user_id])->withTrashed()->orderBy('id', 'DESC')->first();


                    if ($from_male_approch_check != null && $from_female_approch_check != null) {

                        if ($from_male_approch_check->id < $from_female_approch_check->id) {
                            $approch_check = $from_female_approch_check;
                        } else {
                            $approch_check = $from_male_approch_check;
                        }
                    } else if ($from_male_approch_check != null) {
                        $approch_check = $from_male_approch_check;
                    } else if ($from_female_approch_check != null) {
                        $approch_check = $from_female_approch_check;
                    }


                    $loginUserLatlong = $this->getLoginUserLatlog($this->user->id);
                    $seenProfileUser = $this->getLoginUserLatlog($user_id);

                    $distance = distanceCalculation($loginUserLatlong['latitude'], $loginUserLatlong['longitude'], $seenProfileUser['latitude'], $seenProfileUser['longitude']);
                    $data['is_approach'] = "friend";

                    if ($approch_check != null) {
                        $data['relation_type'] = $approch_check->type;
                        if ($approch_check->status == 'accepted') {
                            $data['conversation_id'] = $approch_check->conversation_id;
                            $data['is_approach'] = "message";
                        } else if ($approch_check->status == 'pending') {
                            if ($approch_check->sender_id == $this->user->id) {

                                $data['is_approach'] = "cancel";
                            } else {
                                $data['is_approach'] = "accept_reject";
                            }


                            if ($approch_check->type == 'approach') {

                                $data['is_approach'] = "accept_reject";
                            }
                            // } else if (($approch_check->status == 'rejected' && $approch_check->type == 'approach') || $approch_check->status == 'block') {
                        } else if ($approch_check->status == 'block') {

                            $data['is_approach'] = "no_button";
                        }
                    }
                } else if ($this->user->userdetail->gender == 'male' && $user->userdetail->gender == 'male') {


                    $approch_check = null;
                    $male1_approch_check = ApproachRequest::where(['sender_id' => $user_id, 'receiver_id' => $this->user->id])->withTrashed()->orderBy('id', 'DESC')->first();
                    $male2_approch_check = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' =>  $user_id])->withTrashed()->orderBy('id', 'DESC')->first();


                    if ($male1_approch_check != null && $male2_approch_check != null) {

                        if ($male1_approch_check->id < $male2_approch_check->id) {
                            $approch_check = $male2_approch_check;
                        } else {
                            $approch_check = $male1_approch_check;
                        }
                    } else if ($male1_approch_check != null) {
                        $approch_check = $male1_approch_check;
                    } else if ($male2_approch_check != null) {
                        $approch_check = $male2_approch_check;
                    }

                    $data['is_approach'] = "friend";

                    if ($approch_check != null) {

                        $data['relation_type'] = $approch_check->type;
                        if ($approch_check->status == 'accepted') {
                            $data['conversation_id'] = $approch_check->conversation_id;
                            $data['is_approach'] = "message";
                        } else if ($approch_check->status == 'pending') {
                            if ($this->user->id == $approch_check->sender_id) {

                                $data['is_approach'] = "cancel";
                            } else if ($this->user->id  == $approch_check->receiver_id) {
                                $data['is_approach'] = "accept_reject";
                            }
                        }
                    }
                } else if ($this->user->userdetail->gender == 'female' && $user->userdetail->gender == 'female') {


                    $approch_check = null;
                    $female1_approch_check = ApproachRequest::where(['sender_id' => $user_id, 'receiver_id' => $this->user->id])->withTrashed()->orderBy('id', 'DESC')->first();
                    $female2_approch_check = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' =>  $user_id])->withTrashed()->orderBy('id', 'DESC')->first();


                    if ($female1_approch_check != null && $female2_approch_check != null) {

                        if ($female1_approch_check->id < $female2_approch_check->id) {
                            $approch_check = $female2_approch_check;
                        } else {
                            $approch_check = $female1_approch_check;
                        }
                    } else if ($female1_approch_check != null) {
                        $approch_check = $female1_approch_check;
                    } else if ($female2_approch_check != null) {
                        $approch_check = $female2_approch_check;
                    }


                    $data['is_approach'] = "friend";

                    if ($approch_check != null) {
                        $data['relation_type'] = $approch_check->type;
                        if ($approch_check->status == 'accepted') {
                            $data['conversation_id'] = $approch_check->conversation_id;
                            $data['is_approach'] = "message";
                        } else if ($approch_check->status == 'pending') {
                            if ($this->user->id == $approch_check->sender_id) {

                                $data['is_approach'] = "cancel";
                            } else if ($this->user->id  == $approch_check->receiver_id) {
                                $data['is_approach'] = "accept_reject";
                            }
                        }
                    }
                }
            }
        }


        return response()->json(['status' => true, 'message' => "Success", 'data' => $data]);
        // } catch (QueryException $e) {
        //     DB::rollBack();

        //     return response()->json(['status' => false, 'message' => "db error"]);
        // } catch (\Exception $e) {

        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
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
            return "true";
        }
        return "false";
    }

    public function getLoginUserLatlog($user_id)
    {
        $database = Firebase::database();
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

            $validator = Validator::make(
                $request->all(),
                [
                    'full_name' => ['required', new FullNameValidation],
                    'state_id' => 'required',
                    'city' => ['required', new AlphaNumericCity],
                    'date_of_birth' => ['required'],
                    // 'zodiac_sign_id' => 'required',
                    // 'about_me' => 'required',
                    // 'height' => 'numeric',
                    'email' => ['required', new CustomEmailValidation, Rule::unique('users')->ignore($this->user->id)],
                    // 'weight' => 'numeric',
                    // 'education' => 'max:100',
                    'life_styles' => ['required', 'array'],
                    'interest_and_hobby' => ['required', 'array'],
                    // 'religion_id' => ['required']
                ],
                [
                    'full_name.required' => 'Please Enter your Full Name',
                    'email.required' => 'Please Enter Email',
                    'email.unique' => 'Email is already taken',
                    'state_id.required' => 'Please select your State',

                    'city.required' => 'Please Enter city',
                    'date_of_birth.required' => 'Please select Date Of Birth',
                    // 'zodiac_sign_id.required' => 'Please select Zodiac Sign',
                    //'religion_id.required' => 'Please select Religion',
                    // 'about_me.required' => 'Please enter some information about yourself',
                    // 'height.required' => 'Please enter your Height',
                    // 'height.numeric' => 'Height must be a number',
                    // 'weight.required' => 'Please Enter your Weight',
                    // 'weight.numeric' => 'Weight must be a number',
                    // 'education.required' => 'Please enter your Education',

                    'life_styles.required' => 'Please select at least one Lifestyle',
                    'life_styles.array' => 'Lifestyles must be provided as an array',
                    'interest_and_hobby.required' => 'Please select at least one Interest or Hobby',
                    'interest_and_hobby.array' => 'Interests and Hobbies must be enter as an array',
                ]
            );

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }
            $user_id = $this->user->id;
            $user = User::where('id', $user_id)->first();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->save();
            $user_detail = UserDetail::where('user_id', $user_id)->first();
            $user_detail->state_id = $request->state_id;
            $user_detail->date_of_birth =  date('Y-m-d', strtotime($request->date_of_birth));
            $user_detail->city = $request->city;
            $user_detail->height = $request->height;
            $user_detail->weight = $request->weight;
            $user_detail->education = $request->education;
            // $user_detail->zodiac_sign_id = $request->zodiac_sign_id;
            $user_detail->faith_id  = ($request->faith_id == "" || $request->faith_id == 0) ? NULL : $request->faith_id;
            $user_detail->body_type_id  =   ($request->body_type_id == "" || $request->body_type_id == 0) ? NULL : $request->body_type_id;
            $user_detail->culture_id  =   ($request->culture_id == "" || $request->culture_id == 0) ? NULL : $request->culture_id;
            $user_detail->daily_activity_id  =   ($request->daily_activity_id == "" || $request->daily_activity_id == 0) ? NULL : $request->daily_activity_id;
            $user_detail->exercise_id   =   ($request->exercise_id == "" || $request->exercise_id == 0) ? NULL : $request->exercise_id;
            $user_detail->eating_habit_id   =   ($request->eating_habit_id == "" || $request->eating_habit_id == 0) ? NULL : $request->eating_habit_id;
            $user_detail->vaccination_status   = $request->vaccination_status;
            $user_detail->alcohol_status   = $request->alcohol_status;
            $user_detail->smoke_status   = $request->smoke_status;
            $user_detail->organization_id = ($request->organization_id == "" || $request->organization_id == 0) ? NULL : $request->organization_id;
            $user_detail->religion_id = ($request->religion_id == "" ||  $request->religion_id == 0) ? NULL : $request->religion_id;
            $user_detail->about_me = $request->about_me;
            $user_detail->height_type = $request->height_type;
            // dd($user_detail)
            $user_detail->save();

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
            $user_love_lang = $request->user_love_lang;
            if (isset($user_love_lang) && is_array($user_love_lang)) {
                // if exists then delete prev data //
                foreach ($user_love_lang as $val) {

                    $updateUserLoveLang =  UserLoveLang::where('id', $val['id'])->first();
                    $updateUserLoveLang->rate =  $val['rate'];
                    $updateUserLoveLang->save();
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

            return response()->json(['status' => true, 'message' => "Profile update successfully"]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {

            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function getApproachPreference()
    {

        $result = ApproachPreference::where('user_id', $this->user->id)->first();
        if ($result != null) {

            if (isNotNullOrBlank($result->religious_preference)) {

                $religious_preference = json_decode($result->religious_preference);
                $religious = Religion::select('id', 'religion as name')->whereIn('id', $religious_preference)->get();
                $result['religious_preference'] = $religious;
            } else {
                $result['religious_preference'] = [];
            }
            $result['preference_apply_in_search'] = ($result->preference_apply_in_search == "0") ? false : true;
            return response()->json(["status" => true, 'message' => "Approach reference", "data" => $result]);
        }
        return response()->json(["status" => false, 'message' => "Data not found", "data" => null]);
    }
    public function updateApproachPreference(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'min_age' => ['required'],
                    'max_age' => 'required',

                    'min_weight' => ['required'],
                    'max_weight' => ['required'],
                    'min_height' => ['required'],
                    'max_height' => ['required'],
                ],

            );

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }
            $user_id = $this->user->id;
            $approachPreference = ApproachPreference::where('user_id', $user_id)->first();
            if ($approachPreference != null) {
                $approachPreference->user_id = $this->user->id;
                $approachPreference->min_age = $request->min_age;
                $approachPreference->max_age = $request->max_age;
                $approachPreference->religious_preference = "";
                if (!empty($request->religious_preference)) {
                    $approachPreference->religious_preference = json_encode($request->religious_preference);
                }

                $approachPreference->min_weight = $request->min_weight;
                $approachPreference->max_weight = $request->max_weight;
                $approachPreference->min_height = $request->min_height;
                $approachPreference->max_height = $request->max_height;
                $approachPreference->preference_apply_in_search = ($request->preference_apply_in_search == true) ? '1' : '0';
                $approachPreference->save();
            } else {
                $addApproachPreference = new ApproachPreference();
                $addApproachPreference->user_id = $this->user->id;
                $addApproachPreference->min_age = $request->min_age;
                $addApproachPreference->max_age = $request->max_age;
                $addApproachPreference->religious_preference = json_encode($request->religious_preference);
                $addApproachPreference->min_weight = $request->min_weight;
                $addApproachPreference->max_weight = $request->max_weight;
                $addApproachPreference->min_height = $request->min_height;
                $addApproachPreference->max_height = $request->max_height;
                $addApproachPreference->preference_apply_in_search = ($request->preference_apply_in_search == true) ? '1' : '0';
                $addApproachPreference->save();
            }

            return response()->json(['status' => true, 'message' => "Approach preference update successfully"]);
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
            $validator = Validator::make(
                $request->all(),
                [
                    'full_name' => ['required', new OrganizationNameValidation],
                    'state_id' => 'required',
                    'city' => ['required', new AlphaNumericCity],
                    'email' => ['required', new CustomEmailValidation, Rule::unique('users')->ignore($this->user->id)],
                    // 'about_us' => 'required',
                    'size_of_organization_id' => 'required',
                    'established_year' => ['required', 'numeric', 'digits:4', 'lte:' . date('Y')],
                    'address' => ['required', new AddressValidation]
                ],
                [
                    'full_name.required' => 'Please enter Name of Church/Organization',
                    'state_id.required' => 'Please select a State',
                    'email.required' => 'Please enter Email',
                    'email.unique' => 'Email is already taken',
                    'city.required' => 'Please enter City',
                    // 'about_us.required' => 'Please enter About us',
                    'size_of_organization_id.required' => 'Please select the Size Of Organization.',
                    'established_year.required' => 'Please enter Established Year',
                    'established_year.numeric' => ' Please enter valid Established Year',
                    'established_year.digits' => ' Please enter valid Established Year',
                    'established_year.lte' => ' Please enter valid Established Year',
                    'address.required' => 'Please enter Address'
                ]
            );

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }
            $user_id = $this->user->id;
            $organization = User::where('id', $user_id)->first();
            $organization->full_name = $request->full_name;
            $organization->email = $request->email;
            $organization->save();

            $organization_detail = OrganizationDetail::where('organization_id', $user_id)->first();
            $organization_detail->state = $request->state_id;
            $organization_detail->city = $request->city;
            $organization_detail->about_us = $request->about_us;
            $organization_detail->size_of_organization_id = $request->size_of_organization_id;
            $organization_detail->established_year = $request->established_year;
            $organization_detail->address = $request->address;
            $organization_detail->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Organization profile update successfully"]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function updateShowStopperQues(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'question' => 'required|array',
                'delete_question' => 'array'

            ]);

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }
            $user_id = $this->user->id;
            DB::beginTransaction();
            if (isset($request->question) && !empty($request->question)) {

                foreach ($request->question as $val) {

                    if ($val['id'] != 0) {
                        $updateQue = UserShwstpprQue::where('id', $val['id'])->first();
                        $updateQue->question = $val['question'];
                        $updateQue->option_1 = $val['option_1'];
                        $updateQue->option_2 = $val['option_2'];
                        $updateQue->prefered_option = $val['prefered_option'];
                        $updateQue->save();
                    } else {
                        $addNewQue = new UserShwstpprQue();
                        $addNewQue->question = $val['question'];
                        $addNewQue->option_1 = $val['option_1'];
                        $addNewQue->user_id = $this->user->id;
                        $addNewQue->option_2 = $val['option_2'];
                        $addNewQue->prefered_option = $val['prefered_option'];
                        $addNewQue->save();
                    }
                }
            }

            if (isset($request->delete_question) && !empty($request->delete_question)) {
                foreach ($request->delete_question as $val) {
                    $removeQues = UserShwstpprQue::where('id', $val)->first();
                    $removeQues->status = 'inactive';
                    $removeQues->save();
                    $removeQues->delete();
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => "Showstopper questions updated successfully"]);
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

                        $imageName = $this->user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
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
                if (file_exists($filePath)) {

                    unlink($filePath);
                }
                $profile_delete = UserProfile::where('id', $request->profile_id)->delete();
                DB::commit();
                return response()->json(['status' => true, 'message' => "Profile delete"]);
            } else if ($request->type == "edit_img") {

                $profile = UserProfile::where('id', $request->profile_id)->select('profile')->get()->first();
                $filePath = public_path('storage/profile/' . $profile->profile);
                if (file_exists($filePath)) {

                    unlink($filePath);
                }
                if (!empty($request->profile_image)) {
                    $image = $request->profile_image;

                    $imageName = $this->user->id . '.' . $image->getClientOriginalExtension();
                    if ($checkImageExist != 0) {
                        $giveNum = $checkImageExist + 1;
                        $imageName = $this->user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
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

        // try {

        $userLat = (isset($request->latitude) && $request->latitude != "") ? $request->latitude : "";
        $userLog = (isset($request->longitude) && $request->longitude != "") ? $request->longitude : "";

        $database = Firebase::database();
        $data = $database->getReference('/user_locations')->getValue();

        if ($userLat == "" && $userLog == "") {
            $latitude = "0";
            $longitude = "0";
            $user_id = $this->user->id;
            $maleIds = array_keys($data['male']);

            if (in_array($user_id, $maleIds)) {
                $loginUserData = $data['male'][$user_id];
                $latitude = $loginUserData['latitude'];
                $longitude = $loginUserData['longitude'];
            }
        } else {
            $latitude = $userLat;
            $longitude = $userLog;
        }

        $femaleDataArray = [];
        if (isset($data['female'])) {

            foreach ($data['female'] as $keyId => $val) {

                $distance = distanceCalculation($latitude, $longitude, $val['latitude'], $val['longitude']);

                if ($distance <= 5) {
                    $femaleDataArray[] = $keyId;
                }
            }
        }


        $users = User::query();
        $users->with([
            'userdetail',
            'country',
            'userdetail.state',

        ])->whereIn('id', $femaleDataArray)->where('status', 'active');

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
                    now()->subYears($maxAge + 1)->format('Y-m-d'),
                    now()->subYears($minAge)->format('Y-m-d'),
                ]);
            });
        }
        $result = $users->get();


        $userData = [];

        foreach ($result as $key => $val) {


            $femaleId = $val->id;
            $maleId = $this->user->id;

            $approachPreferences = ApproachPreference::where('user_id', $femaleId)->first();

            $maleAge = calculateAge($this->user->userdetail->date_of_birth, date('Y-m-d'));
            $maleHeight = $this->user->userdetail->height;
            if ($this->user->userdetail->height_type == 'feet') {
                $maleHeight = $maleHeight * 30.48;
            }
            $maleWeight = $this->user->userdetail->weight;
            $male_religion_id = (isNotNullOrBlank($this->user->userdetail->religion_id)) ? $this->user->userdetail->religion_id : 0;
            if ($approachPreferences != null) {
                if (
                    ($approachPreferences->min_age <= $maleAge && $approachPreferences->max_age >= $maleAge) &&
                    ($approachPreferences->min_weight <= $maleWeight && $approachPreferences->max_weight >= $maleWeight) &&
                    ($approachPreferences->min_height <= $maleHeight && $approachPreferences->max_height >= $maleHeight)

                ) {

                    if (isNotNullOrBlank($approachPreferences->religious_preference)) {
                        $religious_preference = json_decode($approachPreferences->religious_preference);
                        if (!in_array($male_religion_id, $religious_preference)) {
                            continue;
                        }
                    }

                    $already_friend = ApproachRequest::where(function ($query) use ($femaleId, $maleId) {
                        $query->where(function ($query) use ($femaleId, $maleId) {
                            $query->where('sender_id', $maleId)
                                ->where('receiver_id', $femaleId);
                        })->orWhere(function ($query) use ($femaleId, $maleId) {
                            $query->where('sender_id', $femaleId)
                                ->where('receiver_id', $maleId);
                        });
                    })
                        ->where('status', 'accepted')
                        ->orderBy('id', 'DESC')
                        ->count();

                    if ($already_friend == 1) {
                        continue;
                    }


                    $already_approched = ApproachRequest::where(['receiver_id' => $val->id, 'type' => 'approach', 'status' => 'accepted'])->orderBy('id', 'DESC')->first();
                    if ($already_approched != null) {
                        continue;
                    }
                    // $approch_check_is_rejected = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' => $val->id])->withTrashed()->orderBy('id', 'DESC')->first();
                    // if ($approch_check_is_rejected != null) {

                    //     if ($approch_check_is_rejected->status == 'rejected') {
                    //         continue;
                    //     }
                    // }

                    $approch_check_is_block = ProfileBlock::where(function ($query) use ($val) {
                        $query->where('blocker_user_id', $this->user->id)
                            ->where('to_be_blocked_user_id', $val->id)
                            ->orWhere(function ($query) use ($val) {
                                $query->where('blocker_user_id', $val->id)
                                    ->where('to_be_blocked_user_id', $this->user->id);
                            });
                    })->orderBy('id', 'DESC')->count();

                    if ($approch_check_is_block == 1) {
                        continue;
                    }

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
            } else {
                $already_friend = ApproachRequest::where(function ($query) use ($femaleId, $maleId) {
                    $query->where(function ($query) use ($femaleId, $maleId) {
                        $query->where('sender_id', $maleId)
                            ->where('receiver_id', $femaleId);
                    })->orWhere(function ($query) use ($femaleId, $maleId) {
                        $query->where('sender_id', $femaleId)
                            ->where('receiver_id', $maleId);
                    });
                })
                    ->where('status', 'accepted')
                    ->orderBy('id', 'DESC')
                    ->count();

                if ($already_friend == 1) {
                    continue;
                }


                $already_approched = ApproachRequest::where(['receiver_id' => $val->id, 'type' => 'approach', 'status' => 'accepted'])->orderBy('id', 'DESC')->first();
                if ($already_approched != null) {
                    continue;
                }
                // $approch_check_is_rejected = ApproachRequest::where(['sender_id' => $this->user->id, 'receiver_id' => $val->id])->withTrashed()->orderBy('id', 'DESC')->first();
                // if ($approch_check_is_rejected != null) {

                //     if ($approch_check_is_rejected->status == 'rejected') {
                //         continue;
                //     }
                // }


                $approch_check_is_block = ProfileBlock::where(function ($query) use ($val) {
                    $query->where('blocker_user_id', $this->user->id)
                        ->where('to_be_blocked_user_id', $val->id)
                        ->orWhere(function ($query) use ($val) {
                            $query->where('blocker_user_id', $val->id)
                                ->where('to_be_blocked_user_id', $this->user->id);
                        });
                })->orderBy('id', 'DESC')->count();

                if ($approch_check_is_block == 1) {
                    continue;
                }

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
        }
        return response()->json(["status" => true, 'message' => 'User data', 'data' => $userData]);
        // } catch (QueryException $e) {
        //     return response()->json(['status' => false, 'message' => "Database error"]);
        // } catch (\Exception $e) {
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

            $checkAns = UserShwstpprQue::where('id', $val['question_id'])->withTrashed()->first();
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
            return response()->json(["status" => false, 'message' => 'She is not open for relationship', 'data' => $wrongQue]);
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

            $approch_check_is_block = ProfileBlock::where(function ($query) use ($receiver_id) {
                $query->where('blocker_user_id', $this->user->id)
                    ->where('to_be_blocked_user_id', $receiver_id);
            })->orderBy('id', 'DESC')->count();

            if ($approch_check_is_block != 0) {
                return response()->json(["status" => false, 'message' => 'You have blocked this person']);
            }

            DB::beginTransaction();

            $approch_request = new ApproachRequest();
            $approch_request->sender_id = $this->user->id;
            $approch_request->receiver_id = $receiver_id;
            $approch_request->status = 'pending';
            $approch_request->type = 'approach';
            $approch_request->message = $request->message;
            $approch_request->save();
            DB::commit();

            $notificationData = [
                'sender_id' => $user->id,
                'receiver_id' => $receiver_id,
                'status' => 'pending',
                'type' => 'approach',
                'notify_for' => 'approach_request'
            ];

            notification($notificationData);
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

            // $checkShwStopperQues = UserShwstpprQue::where('user_id', $request->user_id)->pluck('id');

            // if (count($checkShwStopperQues) != 0) {
            //     $checkUserAns = UserShwstpperAnswr::where('user_id', $this->user->id)->whereIn('question_id', $checkShwStopperQues)->pluck('answer_status');


            //     if (count($checkUserAns) != 0) {

            //         if (in_array('0', $checkUserAns->toArray())) {
            //             return response()->json(["status" => false, 'message' => 'She is not open for relationship']);
            //         }
            //     }
            // }

            $approch_check_is_block = ProfileBlock::where(function ($query) use ($request) {
                $query->where('blocker_user_id', $this->user->id)
                    ->where('to_be_blocked_user_id', $request->user_id);
            })->orderBy('id', 'DESC')->count();

            if ($approch_check_is_block != 0) {
                return response()->json(["status" => false, 'message' => 'You have blocked this person']);
            }
            $checkIsApproched = ApproachRequest::where(function ($query) use ($request) {
                $query->where('sender_id', $this->user->id)
                    ->where('receiver_id', $request->user_id)
                    ->orWhere(function ($query) use ($request) {
                        $query->where('sender_id', $request->user_id)
                            ->where('receiver_id', $this->user->id);
                    });
            })->withTrashed()
                ->selectRaw('*, CASE WHEN sender_id = ? THEN "sender" ELSE "receiver" END AS user_role', [$this->user->id])
                ->orderBy('id', 'DESC')->first();

            if ($checkIsApproched != null) {

                if ($checkIsApproched->status == 'pending') {
                    if ($checkIsApproched->type == 'approach') {


                        return response()->json(["status" => false, 'message' => 'You have already approach request to this person']);
                    } else if ($checkIsApproched->type == 'friend') {
                        if ($checkIsApproched->user_role == 'sender') {

                            return response()->json(["status" => false, 'message' => 'You have already friend request to this person']);
                        } elseif ($checkIsApproched->user_role == 'receiver') {
                            return response()->json(["status" => false, 'message' => 'You have already friend request from this person']);
                        }
                    }
                }
                // if ($checkIsApproched->status == 'rejected') {

                //     return response()->json(["status" => false, 'message' => 'You have rejected']);
                // }
                if ($checkIsApproched->status == 'accepted') {
                    return response()->json(["status" => false, 'message' => 'commited']);
                }
            }
            $approchOwncheck = ApproachRequest::where(['sender_id' => $this->user->id, 'status' => 'accepted', 'type' => 'approach'])->withTrashed()->orderBy('id', 'DESC')->first();
            $female_approch_check = ApproachRequest::where(['receiver_id' => $request->user_id, 'status' => 'accepted', 'type' => 'approach'])->withTrashed()->orderBy('id', 'DESC')->first();
            if ($approchOwncheck == null && $female_approch_check == null) {

                return response()->json(["status" => true, 'message' => 'you are elegible']);
            }

            if ($approchOwncheck != null) {

                return response()->json(["status" => false, 'message' => 'You have already committed with another user']);
            }

            if ($female_approch_check != null) {
                return response()->json(["status" => false, 'message' => 'she has already committed with another user']);
            }
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
            $type = "pending";
            if (isset($request->type) && $request->type != "") {
                $type = $request->type;
            }
            $requests = getManageRequestByMale($type, $page, $this->user->id);
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

            $requests = getManageRequestByFemale($type, $page, $this->user->id);
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
        // try {

        $page = 1;
        if (isset($request->page) && $request->page != "") {
            $page = $request->page;
        }
        $filter['search_name'] = "";
        if (isset($request->search_name) && $request->search_name != "") {
            $filter['search_name'] = $request->search_name;
        }
        $filter['city'] = "";
        if (isset($request->city) && $request->city != "") {
            $filter['city'] = $request->city;
        }

        $filter['organization_name'] = "";

        if (isset($request->organization_name) && $request->organization_name != "") {
            $filter['organization_name']  = $request->organization_name;
        }

        if (isset($request->min) && isset($request->max)) {
            $filter['minAge'] = $request->min;
            $filter['maxAge'] = $request->max;
        }

        $filter['words_of_affirmation_min'] = $request->words_of_affirmation_min;
        $filter['words_of_affirmation_max'] = $request->words_of_affirmation_max;
        $filter['act_of_services_min'] = $request->act_of_services_min;
        $filter['act_of_services_max'] = $request->act_of_services_max;
        $filter['gifts_min'] = $request->gifts_min;
        $filter['gifts_max'] = $request->gifts_max;
        $filter['quality_time_min'] = $request->quality_time_min;
        $filter['quality_time_max'] = $request->quality_time_max;
        $filter['physical_touch_min'] = $request->physical_touch_min;
        $filter['physical_touch_max'] = $request->physical_touch_max;

        $requests = getSearchUser(
            $filter,
            $page,
            $this->user->id

        );
        $userData = $requests['userData'];
        $total_page = $requests['total_page'];

        return response()->json(["status" => true, 'message' => 'Users', 'total_page' => $total_page, 'data' => $userData]);
        // } catch (QueryException $e) {

        //     DB::rollBack();

        //     return response()->json(['status' => false, 'message' => "db error"]);
        // } catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
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
                $type = $cancelRequest->type;
                $cancelRequest->status = 'cancelled';
                $cancelRequest->save();
                // Soft delete

                // soft delete //
                $cancelRequest->delete();
                // soft delete //
                $notificationData = [
                    'sender_id' => $this->user->id,
                    'receiver_id' => $request->user_id,
                    'status' => 'cancelled',
                    'type' => $type,
                    'notify_for' => 'cancel_request'
                ];

                notification($notificationData);
                return response()->json(["status" => true, 'message' => 'Request cancelled successfully']);
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

    public function acceptRejectByUser(Request $request)
    {
        try {

            if ($request->type == 'rejected') {
                $validator = Validator::make($request->all(), [
                    'user_id' => ['required', 'integer', 'exists:users,id'],
                    'type' => ['required', 'string', 'in:accepted,rejected'],

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
                if ($cancelRequest->type == 'approach') {

                    if ($request->type == 'rejected') {
                        $cancelRequest->message = $request->message;
                    }
                }
                $cancelRequest->status = $request->type;
                if ($request->type == 'accepted') {
                    $conversation_id =  generateConversationId([$request->user_id, $this->user->id]);
                    $cancelRequest->conversation_id = $conversation_id;
                }
                $cancelRequest->save();


                // Soft delete
                // soft delete //

                if ($request->type == 'rejected') {
                    $notificationData = [
                        'sender_id' => $this->user->id,
                        'receiver_id' => $request->user_id,
                        'status' => 'rejected',
                        'type' =>  $cancelRequest->type,
                        'message' => ($cancelRequest->type == 'approach') ? $request->message : "",
                        'notify_for' => 'accept_or_reject'
                    ];

                    notification($notificationData);
                    // if ($cancelRequest->type == 'approach') {

                    $cancelRequest->delete();
                    // }
                }

                // soft delete //
                if ($cancelRequest->type == 'approach') {

                    if ($request->type == 'accepted') {
                        $cancelLeftRequest = ApproachRequest::where(['receiver_id' => $this->user->id, 'status' => 'pending'])->where('sender_id', '!=', $request->user_id)->get();

                        if (count($cancelLeftRequest) != 0) {
                            foreach ($cancelLeftRequest as $val) {

                                $cancelThisReq = ApproachRequest::where(['id' => $val->id])->first();
                                $cancelThisReq->status = 'cancelled';
                                $cancelThisReq->save();
                                $cancelThisReq->delete();
                            }
                        }

                        $cancelLeftRequestOfMale = ApproachRequest::where(['sender_id' =>  $request->user_id, 'status' => 'pending'])->where('receiver_id', '!=', $this->user->id)->get();

                        if (count($cancelLeftRequestOfMale) != 0) {
                            foreach ($cancelLeftRequestOfMale as $value1) {

                                $cancelThisReqMale = ApproachRequest::where(['id' => $value1->id])->first();
                                $cancelThisReqMale->status = 'cancelled';
                                $cancelThisReqMale->save();
                                $cancelThisReqMale->delete();
                            }
                        }
                    }
                }

                if ($request->type == 'accepted') {
                    $notificationData = [
                        'sender_id' => $this->user->id,
                        'receiver_id' => $request->user_id,
                        'status' => 'accepted',
                        'type' =>  $cancelRequest->type,
                        'notify_for' => 'accept_or_reject'
                    ];

                    notification($notificationData);
                }

                // add notification //

                return response()->json(["status" => true, 'message' => 'Request ' . $request->type . ' successfully']);
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
            return response()->json(['status' => true, 'message' => "Sign Out successfully"]);
        }
    }


    public function userDevice($id, $requestData)
    {


        if (Device::where('user_id', $id)->exists()) {
            Device::where('user_id', $id)->delete();
        }
        Device::where('device_id', $requestData->device_id)->delete();

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
        // try {
        DB::beginTransaction();
        $page = 1;
        if (isset($request->page) && $request->page != "") {
            $page = $request->page;
        }


        $organization_id = (isset($request->user_id)) ? $request->user_id : $this->user->id;
        $total_request =  UserDetail::with(['user', 'user.user_profile' => function ($query) {
            $query->where('is_default', '1');
        }])->where('organization_id', $organization_id)->count();
        $total_page  = ceil($total_request / 10);
        $get_member = UserDetail::with(['user', 'user.user_profile' => function ($query) {
            $query->where('is_default', '1');
        }])->where('organization_id', $organization_id)->select('user_id')->paginate(10, ['*'], 'page', $page);

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
        return response()->json(["status" => true, 'message' => 'Success',  'total_page' => $total_page, 'data' => $data]);
        // } catch (QueryException $e) {

        //     DB::rollBack();

        //     return response()->json(['status' => false, 'message' => "db error"]);
        // } catch (\Exception $e) {
        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
    }


    public function organizationProfileId(Request $request)
    {
        try {
            DB::beginTransaction();

            $organizationId = $request->user_id;
            $user = User::with(['organizationdetail' => function ($query) {
                return $query->with('state_data', 'city_data', 'size_of_organization');
            }, 'country', 'user_profile'])->where(['id' => $organizationId, 'status' => 'active'])->first();

            $totalMember = UserDetail::where('organization_id', $organizationId)->count();
            $user_id =  $user->id;
            $full_name = ($user->full_name != "") ?  $user->full_name : "";
            $mobile_number = ($user->mobile_number != "") ?  $user->mobile_number : "";
            $email = ($user->email != "") ?  $user->email : "";
            // dd($this->user);
            $data = [];
            $data = [
                'name' => $full_name,
                'mobile_number' => $mobile_number,
                'email' => $email,
            ];

            if ($user_id) {

                $data['member_count'] = $totalMember;
                $data['established_year'] = $user->organizationdetail->established_year;
                $data['address'] = ($user->organizationdetail->address != "") ? $user->organizationdetail->address : "";
                $data['about_us'] = ($user->organizationdetail->about_us != "") ? $user->organizationdetail->about_us : " ";
                $data['state'] = ($user->organizationdetail->state != "") ? $user->organizationdetail->state : "";
                $data['country_code'] = ($user->country->iso != "") ? $user->country->iso : "";
                $data['country_dial_code'] = ($user->country_code != "") ? $user->country_code : "";
                $data['state_name'] = ($user->organizationdetail->state_data->state != "") ? $user->organizationdetail->state_data->state : "";
                $data['city'] = ($user->organizationdetail->city_data != null) ? $user->organizationdetail->city_data->city : "";
                $data['size_of_church_id'] = ($user->organizationdetail->size_of_organization_id != "") ? $user->organizationdetail->size_of_organization_id : "";
                $data['size_of_church'] = ($user->organizationdetail->size_of_organization->size_range != "") ? $user->organizationdetail->size_of_organization->size_range : "";

                $data['profile_image'] = [];
                if (count($user->user_profile)) {
                    foreach ($user->user_profile as $key => $val) {

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



    public function friendRequest(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer', 'exists:users,id'],
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
            $approch_request->type = 'friend';
            $approch_request->save();
            DB::commit();

            $notificationData = [
                'sender_id' => $user->id,
                'receiver_id' => $receiver_id,
                'status' => 'pending',
                'type' => 'friend',
                'notify_for' => 'friend_request'
            ];

            notification($notificationData);
            return response()->json(["status" => true, 'message' => 'Your request has been sent successfully!']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function blockUserList(Request $request)
    {
        try {
            DB::beginTransaction();

            $page = 1;
            if (isset($request->page) && $request->page != "") {
                $page = $request->page;
            }

            $totalBlockUser = ProfileBlock::with(['blocked_user', 'blocked_user.user_profile' => function ($query) {
                $query->where('is_default', '1')->first();
            }])->where(['blocker_user_id' => $this->user->id, 'is_remove' => '0'])->count();
            $total_page  = ceil($totalBlockUser / 10);
            $blockUser = ProfileBlock::with(['blocked_user.user_profile' => function ($query) {
                $query->where('is_default', '1');
            }])
                ->where(['blocker_user_id' => $this->user->id, 'is_remove' => '0'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10, ['*'], 'page', $page);



            $blockUserList = [];
            if (count($blockUser) != 0) {
                foreach ($blockUser as $val) {
                    $data['id'] = $val->blocked_user->id;
                    $data['name'] = $val->blocked_user->full_name;
                    $data['profile_image'] = ($val->blocked_user->user_profile != null) ? asset('storage/profile/' . $val->blocked_user->user_profile[0]->profile) : "";
                    $data['reason'] = $val->reason;
                    $blockUserList[] = $data;
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => "block user lists", 'data' => $blockUserList]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function blockUnblockToUser(Request $request)
    {

        // try {

        $validator = Validator::make($request->all(), [

            'user_id' => ['required', 'integer', 'exists:users,id'],
            'type' => ['required', 'in:block,unblock,remove'],

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->type == 'block') {
            $checkIsBlock = ProfileBlock::where([
                'blocker_user_id' => $this->user->id,
                'to_be_blocked_user_id' => $request->user_id
            ])->first();
            if ($checkIsBlock == null) {
                DB::beginTransaction();
                $checkReason = BlockReason::where('id', $request->block_reason_id)->first();

                $blockToUser = new ProfileBlock();
                $blockToUser->blocker_user_id  = $this->user->id;
                $blockToUser->to_be_blocked_user_id   = $request->user_id;
                $blockToUser->block_reason_id   = $request->block_reason_id;

                $blockToUser->reason = $checkReason->reason;
                if ($checkReason != null && $checkReason->reason == 'Others') {
                    $blockToUser->reason = $request->message;
                }
                $blockToUser->save();

                $toBeBlockId = $request->user_id;

                // check from login user //
                $changeApproachStatus = ApproachRequest::where(function ($query) use ($toBeBlockId) {
                    $query->where('sender_id', $this->user->id)
                        ->where('receiver_id', $toBeBlockId)
                        ->orWhere(function ($query) use ($toBeBlockId) {
                            $query->where('sender_id', $toBeBlockId)
                                ->where('receiver_id', $this->user->id);
                        });
                })
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($changeApproachStatus != null) {

                    $changeApproachStatus->status = 'block';
                    $changeApproachStatus->save();
                    // $changeApproachStatus->delete();
                }
                DB::commit();

                return response()->json(['status' => true, 'message' => "blocked successfully"]);
            }
            return response()->json(['status' => true, 'message' => "already blocked"]);
        } else if ($request->type == 'unblock') {
            $unblockToUser = ProfileBlock::where(['blocker_user_id' => $this->user->id, 'to_be_blocked_user_id' => $request->user_id])->first();

            if ($unblockToUser != null) {
                DB::beginTransaction();

                $changeUnBlockApproachStatus = ApproachRequest::where(function ($query) use ($request) {
                    $query->where('sender_id', $this->user->id)
                        ->where('receiver_id', $request->user_id)
                        ->orWhere(function ($query) use ($request) {
                            $query->where('sender_id', $request->user_id)
                                ->where('receiver_id', $this->user->id);
                        });
                })
                    ->where('status', 'block')
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($changeUnBlockApproachStatus != null) {

                    $changeUnBlockApproachStatus->status = 'unblock';
                    $changeUnBlockApproachStatus->save();
                    $changeUnBlockApproachStatus->delete();
                }
                $unblockToUser->delete();
                DB::commit();
                return response()->json(['status' => true, 'message' => "unblocked successfully"]);
            }
            return response()->json(['status' => true, 'message' => "User not found"]);
        } else if ($request->type == 'remove') {
            $removeBlockUser = ProfileBlock::where([
                'blocker_user_id' => $this->user->id,
                'to_be_blocked_user_id' => $request->user_id
            ])->first();
            if ($removeBlockUser != null) {
                $removeBlockUser->is_remove = '1';
                $removeBlockUser->save();
                return response()->json(['status' => true, 'message' => "blocked user removed successfully"]);
            }
        }
        return response()->json(['status' => true, 'message' => "try again"]);
        // } catch (QueryException $e) {
        //     DB::rollBack();

        //     return response()->json(['status' => false, 'message' => "db error"]);
        // } catch (\Exception $e) {


        //     return response()->json(['status' => false, 'message' => "something went wrong"]);
        // }
    }

    public function notificationList(Request $request)
    {
        try {

            $page = 1;
            if (isset($request->page) && $request->page != "") {
                $page = $request->page;
            }

            $notificationtotal = Notification::with(['sender_user'])->where('user_id', $this->user->id)->count();
            $total_page  = ceil($notificationtotal / 10);
            $notification = Notification::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(10, ['*'], 'page', $page);
            $notificationList = [];
            if (count($notification) != 0) {
                foreach ($notification as $val) {
                    $data['id'] = $val->id;
                    $data['user_id'] = $val->sender_id;
                    $data['name'] = $val->sender_user->full_name;
                    $data['profile_image'] = getProfile($val->sender_id);
                    $data['message'] = $val->message;
                    $data['notification_type'] = $val->notification_type;
                    $data['request_time'] =  setpostTime($val->created_at);
                    $data['status'] = $val->status;
                    $notificationList[] = $data;
                }
            }

            return response()->json(['status' => true, 'message' => "Notification lists", 'total_page' => $total_page, 'data' => $notificationList]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function deleteNotification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'notification_id' => ['required', 'integer', 'exists:notifications,id'],
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $deleteNotification = Notification::where(['id' => $request->notification_id])->first();
            if ($deleteNotification != null) {
                $deleteNotification->delete();
                return response()->json(["status" => true, 'message' => 'Notification deleted successfully']);
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

    public function ReportUser(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'to_be_reported_user_id' => ['required', 'integer'],
                    'report_message' => ['required', 'string'],
                ],
                [
                    'report_message.required' => "Please enter Report Message"
                ]
            );

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }

            DB::beginTransaction();
            $report_user = new Report();
            $report_user->reporter_user_id = $this->user->id;
            $report_user->to_be_reported_user_id = $request->to_be_reported_user_id;
            $report_user->report_message = $request->report_message;
            if (!empty($request->report_image)) {
                $image = $request->report_image;

                $imageName = $this->user->id . '_' . time() . '.' . $image->getClientOriginalExtension();


                $image->move(public_path('storage/report_media'), $imageName);
                $report_user->report_image = $imageName;
            }

            $report_user->save();

            if (!empty($request->report_chat_list)) {
                $report_id = $report_user->id;
                $chatData = json_decode($request->report_chat_list, true);
                foreach ($chatData as $value) {

                    $reportChat =  new UserReportChat();
                    $reportChat->report_id = $report_id;
                    $reportChat->sender_id = $value['sender_id'];
                    $reportChat->message = $value['message'];
                    $reportChat->save();
                }
            }

            DB::commit();

            $response = [
                'status' => true,
                'message' => __('messages.report_success_msg')
            ];

            return response()->json($response);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function UserFeedback(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'selected_feedback' => ['required'],
                    'to_be_feedback_user_id' => ['required', 'integer'],
                    'feedback_message' => ['required', 'string'],
                ],
                [
                    'feedback_message.required' => "Please enter Feedback / Review"
                ]
            );

            if ($validator->fails()) {
                return response()->json(["status" => false, 'message' => $validator->errors()->first()]);
            }

            DB::beginTransaction();
            $checkAlreadyFeedback = FeedbackReview::where(['by_user_id' => $this->user->id, 'user_id' => $request->to_be_feedback_user_id])->first();

            if ($checkAlreadyFeedback == null) {

                $feedback_user = new FeedbackReview();
                $feedback_user->by_user_id = $this->user->id;
                $feedback_user->feedback_review_id = json_encode($request->selected_feedback);
                $feedback_user->user_id = $request->to_be_feedback_user_id;
                $feedback_user->review = $request->feedback_message;
                $feedback_user->save();
            } else {

                $checkAlreadyFeedback->feedback_review_id = json_encode($request->selected_feedback);
                $checkAlreadyFeedback->review = $request->feedback_message;
                $checkAlreadyFeedback->save();
            }



            DB::commit();

            $response = [
                'status' => true,
                'message' => __('messages.feedback_success_msg')
            ];

            return response()->json($response);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }



    public function clearNotification()
    {
        try {
            $deleteNotification = Notification::where(['user_id' => $this->user->id])->delete();
            return response()->json(["status" => true, 'message' => 'Notification clear all successfully']);
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }
    public function installApp()
    {
        $versionSetting =  VersionSetting::first();

        return response()->json(["status" => true, 'message' => 'Application', 'url' => asset('public/appversion/traditional.apk'), 'version' => $versionSetting->android_version]);
    }

    public function ageLimiter()
    {
        $Settings =  Setting::select('min_age', 'max_age')->first();


        return response()->json(["status" => true, 'message' => 'Age limit', 'data' => $Settings]);
    }

    public function blockReason()
    {
        $BlockReason =  BlockReason::select('id', 'reason')->get();


        return response()->json(["status" => true, 'message' => 'Block Reasons', 'data' => $BlockReason]);
    }

    public function feedbackReviewList()
    {
        $feedbackReviewList =  FeedbackReviewList::select('id', 'feedback_review')->get();


        return response()->json(["status" => true, 'message' => 'Feedback Review List', 'data' => $feedbackReviewList]);
    }

    public function CertainWordList()
    {
        $certainWordList =  BadWord::select('id', 'words')->get();


        return response()->json(["status" => true, 'message' => 'Bad words', 'data' => $certainWordList]);
    }


    public function FaithList()
    {
        $faithList =  Faith::select('id', 'faith as name')->get();


        return response()->json(["status" => true, 'message' => 'Faith', 'data' => $faithList]);
    }

    public function ExerciseList()
    {
        $exerciseList =  Exercise::select('id', 'exercise as name')->get();


        return response()->json(["status" => true, 'message' => 'Exercise', 'data' => $exerciseList]);
    }

    public function EatingHabitList()
    {
        $eatingHabitList =  EatingHabit::select('id', 'eating_habit as name')->get();


        return response()->json(["status" => true, 'message' => 'Eating habit', 'data' => $eatingHabitList]);
    }

    public function CultureList()
    {
        $cultureList =  Culture::select('id', 'culture as name')->get();


        return response()->json(["status" => true, 'message' => 'Culture', 'data' => $cultureList]);
    }

    public function BodyTypeList()
    {
        $bodyTypeList =  BodyType::select('id', 'body_type as name')->get();


        return response()->json(["status" => true, 'message' => 'Body type', 'data' => $bodyTypeList]);
    }

    public function DailyActivityList()
    {
        $dailyActivityList =  DailyActivity::select('id', 'daily_activity as name')->get();


        return response()->json(["status" => true, 'message' => 'Daily activity', 'data' => $dailyActivityList]);
    }

    public function DisconnectToUser(Request $request)
    {


        try {

            $validator = Validator::make($request->all(), [

                'user_id' => ['required', 'integer', 'exists:users,id'],
                'disconnect_reason_id' => ['required'],

            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }


            $approch_check = ApproachRequest::where(function ($query) use ($request) {
                $query->where('sender_id', $this->user->id)
                    ->where('receiver_id', $request->user_id)
                    ->orWhere(function ($query) use ($request) {
                        $query->where('sender_id', $request->user_id)
                            ->where('receiver_id', $this->user->id);
                    });
            })
                ->where('status', 'accepted')
                ->orderBy('id', 'DESC')
                ->first();
            if ($approch_check != null) {
                DB::beginTransaction();
                $checkReason = BlockReason::where('id', $request->disconnect_reason_id)->first();


                $approch_check->status  = 'leave';
                $approch_check->leave_reason_id   = $request->disconnect_reason_id;
                $approch_check->message = $checkReason->message;
                if ($checkReason != null && $checkReason->reason == 'Others') {
                    $approch_check->message = $request->message;
                }
                $approch_check->save();
                $approch_check->delete();

                DB::commit();

                return response()->json(['status' => true, 'message' => "Leave successfully"]);
            }
            return response()->json(['status' => true, 'message' => "Already leave"]);

            return response()->json(['status' => true, 'message' => "try again"]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function getVerifyObject()
    {
        $objectVerification =  VerificationObject::inRandomOrder()->first();
        // $objectVerification =  VerificationObject::where('object_type', 'couch')->first();
        $verifyObj = null;
        if ($objectVerification != null) {
            $userProfile = UserProfile::where(['user_id' => $this->user->id, 'is_default' => '1'])->first();
            $verifyObj['id'] = $objectVerification->id;
            $verifyObj['object_type'] = $objectVerification->object_type;
            $verifyObj['object_image'] = ($objectVerification->object_image != null || $objectVerification->object_image != "") ? asset('storage/verification_object/' . $objectVerification->object_image) : "";
            $verifyObj['profile'] = ($userProfile != null && ($userProfile->profile != null || $userProfile->profile != "")) ? asset('storage/profile/' . $userProfile->profile) : "";
        }


        return response()->json(["status" => true, 'message' => 'Bad words', 'data' => $verifyObj]);
    }

    public function verifiedUserProfile(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [

                'verification_object_id' => ['required', 'integer', 'exists:verification_objects,id'],
                'profile' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $userVerifiedProfile =  ProfileVerify::where('user_id', $this->user->id)->first();

            DB::beginTransaction();
            if ($userVerifiedProfile == null) {
                $verifiedProfile = new ProfileVerify();

                $verifiedProfile->user_id = $this->user->id;
                $verifiedProfile->verification_object_id = $request->verification_object_id;

                if (!empty($request->profile)) {


                    $image = $request->profile;
                    $imageName = time() . 'verified.' . $image->getClientOriginalExtension();
                    $image->move(public_path('storage/user_verified_profile'), $imageName);
                    $verifiedProfile->profile = $imageName;
                }
                $verifiedProfile->save();


                DB::commit();

                return response()->json(['status' => true, 'message' => "verified successfully"]);
            }
            return response()->json(['status' => true, 'message' => "try again"]);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'message' => "db error"]);
        } catch (\Exception $e) {


            return response()->json(['status' => false, 'message' => "something went wrong"]);
        }
    }

    public function getFileSize()
    {
        $fileSize =  FileSizeMaster::first();
        return response()->json(["status" => true, 'message' => 'File size', 'data' => $fileSize]);
    }
}
