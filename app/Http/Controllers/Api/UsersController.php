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
    public function signup(UserValidate $request){
        $user = new User();
        $user->username=$request->username;
        $user->country_code=$request->country_code;
        $user->phone_number=$request->phone_number;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->user_type=$request->user_type;
        $user->remember_token=$request->remember_token;
    }
}
