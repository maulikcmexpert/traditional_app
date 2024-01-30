<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserValidate;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserEducationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\Api\UserResource;

class UsersController extends BaseController
{
    function signup(UserValidate $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->country_code = $request->country_code;
        $user->role = $request->role;
        $user->name = $request->name;
        $user->save();
        return $this->sendResponse(__('messages.registered'));
    }

    function profileupdate(Request $request)
    {
        if (Auth::user()) {
            // dd(Auth::user());
            $user_id = Auth::user()->id;
            $validatedData = [
                'gender' => 'required',
                'birth_date' => 'required|date',
                'document_type_id' => 'required|exists:document_types,id',
                'document' => 'required|file|mimes:pdf|max:2048',
                'document_number' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'about' => 'required',
                'portfolio' => 'required',
                'work_experience' => 'required',
                'achievement' => 'required',
                'skill' => 'required',
                'hobby' => 'required',
                'facebook_link' => 'required',
                'instagram_link' => 'required',
                'linkedin_link' => 'required',
                'other_link' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'school_name' => 'required',
                'year' => 'required',
                'qualification' => 'required',
                'degree' => 'required|file|mimes:pdf|max:2048',
            ];
            try {
                $this->validate($request, $validatedData);
            } catch (ValidationException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => $e->validator->errors(),
                ]);
            }

            $documentPath = $request
                ->file('document')
                ->store('documents', 'public');

            $imagePath = $request->file('image')->store('uploads', 'public');
            $userDetail = UserDetail::firstOrNew(['user_id' => $user_id]);

            $userDetail->gender = $request->gender;
            $userDetail->birth_date = $request->birth_date;
            $userDetail->document_type_id = $request->document_type_id;
            $userDetail->document = $documentPath;
            $userDetail->document_number = $request->document_number;
            $userDetail->latitude = $request->latitude;
            $userDetail->longitude = $request->longitude;
            $userDetail->about = $request->about;
            $userDetail->portfolio = $request->portfolio;
            $userDetail->work_experience = $request->work_experience;
            $userDetail->achievement = $request->achievement;
            $userDetail->skill = $request->skill;
            $userDetail->hobby = $request->hobby;
            $userDetail->facebook_link = $request->facebook_link;
            $userDetail->instagram_link = $request->instagram_link;
            $userDetail->linkedin_link = $request->linkedin_link;
            $userDetail->other_link = $request->other_link;
            $userDetail->image = $imagePath;
            $userDetail->save();
            $updatedUserId = $userDetail->getKey();

            // $educationDetails = $request->input('user_education_details');

            for ($i = 0; $i < count($request->school_name); $i++) {
                $filePath = $request
                    ->file('degree')
                    ->store('documents', 'public');

                $school_name = $request->school_name;
                $year = $request->year;
                $qualification = $request->qualification;

                $userEducationDetail = UserEducationDetail::firstOrNew([
                    'user_id' => $user_id,
                ]);
                // $userEducationDetail->user_id = Auth::user()->id;
                $userEducationDetail->school_name = $school_name[$i];
                $userEducationDetail->year = $year[$i];
                $userEducationDetail->qualification = $qualification[$i];
                $userEducationDetail->degree = $filePath;

                $userEducationDetail->save();
            }
            $user_detail = UserDetail::find($updatedUserId);
            $user_detail->user_education = UserEducationDetail::where('user_id', $user_id)->get();

            return $this->sendResponse(__('messages.updatedprofile'), new UserResource($user_detail));
        } else {
            return $this->sendError(__('messages.authFailed'), 401);
        }
    }
}