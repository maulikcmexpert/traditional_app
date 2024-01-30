<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserValidate;
// use App\Models\User_connection;
// use App\Models\User_connection;
// use App\Models\User_connection;
// use App\Models\User_connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\EducatorResource;
use App\Models\Category;
use App\Models\Section;
use App\Models\Subcategory;
use App\Models\Course;
use App\Models\User;
use App\Models\User_connection;
use DB;

class EducatorsController extends BaseController
{

    public function getCategoryOfsubcategory(Request $request)
    {
        // DB::enableQueryLog();
        $categoryGet = Category::with(['subcategories' => function ($query) {
            $query->select('category_id', 'name');
        }])->select('id', 'name')->get();
        return $this->sendResponse(__('messages.getCategoryOrSubcategory'), $categoryGet);
    }

    public function createcourse(Request $request)
    {
        if (Auth::user()) {
            $user_id = Auth::user()->id;

            $validatedData = [
                'class_title' => 'required|string|max:255',
                'description' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'start_time' => 'required',
                'end_time' => 'required',
                'venue_type' => 'required',
                'slots' => 'required',
                'pricing' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'day' => 'required',
                'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            if ($request->venue_type == 'in_person') {
                $validatedData['street_address'] = "required";
                $validatedData['country'] = "required";
                $validatedData['state'] = "required";
                $validatedData['city'] = "required";
                $validatedData['pincode'] = "required";

            }

            try {
                $this->validate($request, $validatedData);
            } catch (ValidationException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => $e->validator->errors(),
                ]);
            }
            $cover_image = $request->file('cover_image')->store('uploads', 'public');
            $course = new Course();
            $course->user_id = $user_id;
            $course->subcategory_id = $request->subcategory_id;
            $course->cover_image = $cover_image;
            $course->class_title = $request->class_title;
            $course->description = $request->description;
            $course->start_date = $request->start_date;
            $course->end_date = $request->end_date;
            $course->start_time = $request->start_time;
            $course->end_time = $request->end_time;
            $course->venue_type = $request->venue_type;
            $course->street_address = $request->street_address;
            $course->country = $request->country;
            $course->state = $request->state;
            $course->city = $request->city;
            $course->slots = $request->slots;
            $course->pincode = $request->pincode;
            $course->pricing = $request->pricing;
            $course->section_id = $request->section_id;
            $course->latitude = $request->latitude;
            $course->longitude = $request->longitude;
            $course->day = $request->day;
            $course->save();
            $lastCourseId = $course->getKey();
            $course_detail['courseDetail'] = Course::where('user_id', $user_id)->get();

            return $this->sendResponse(__('messages.coursecreated'), $course_detail);

        } else {
            return $this->sendError(__('messages.authFailed'), 401);
        }
    }


    public function getLearners(Request $request)
    {
        DB::enableQueryLog();

        $searchTerm = $request->search;
        $User = User::with([
            'userdetail' => function ($query) {
                $query->select('id', 'gender', 'birth_date', 'document', 'document_number',
                    'latitude', 'longitude', 'about', 'portfolio', 'work_experience', 'achievement',
                    'skill', 'hobby', 'facebook_link', 'instagram_link', 'linkedin_link', 'other_link',
                    'image', 'user_id');
            },
            'usereducationdetail' => function ($query) {
                $query->select('id', 'school_name', 'year', 'qualification', 'degree', 'user_id');
            }
        ])

            ->where('role', 'learner')
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            })
            ->select('id', 'name', 'email', 'mobile')
            ->get();
        $queryLog = DB::getQueryLog();
        // dd($queryLog);
        return $this->sendResponse(__('messages.getCategoryOrSubcategory'), $User);
    }


    public function user_connection(Request $request)
    {
        if (Auth::user()) {
            $sender_id = Auth::user()->id;
            $role = Auth::user()->role;
            $receiver_id = $request->receiver_id;
            $status = $request->status;
            $Connection = new User_connection();
            $Connection->receiver_id = $receiver_id;
            $Connection->role = $role;
            $Connection->status = $status;
            $Connection->sender_id = 1;

            $Connection->save();
            return $this->sendResponse(__('messages.sendRequest'), $Connection);


        } else {
            return $this->sendError(__('messages.authFailed'), 401);
        }
    }

    public function getUserRequest(Request $request)
    {

        DB::enableQueryLog();
        if (Auth::user()) {
            $searchTerm = $request->search;
            $receiver_id = Auth::user()->id;
            $User = User_connection::with(['sender_user' => function ($query) {
                $query->select('id', 'name', 'email', 'mobile');
                $query->with(['userdetail', 'usereducationdetail' => function ($query) {
                    $query->select('id', 'school_name', 'year', 'qualification', 'degree', 'user_id');
                }]);
            },
            ])

                ->where('role', 'learner')
                ->where('receiver_id', '=', $receiver_id)


                ->get();

            $queryLog = DB::getQueryLog();
            dd($User);

            return $this->sendResponse(__('messages.getCategoryOrSubcategory'), $User);


        } else {
            return $this->sendError(__('messages.authFailed'), 401);
        }
    }

}