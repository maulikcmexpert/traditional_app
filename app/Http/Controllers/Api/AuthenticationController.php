<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Api\UserResource;

class AuthenticationController extends BaseController
{
    public function store(Request $request)
    {
        if (
            Auth::attempt([
                'country_code' => $request['country_code'],
                'mobile' => $request['mobile'],
            ])
        ) {
            $user = User::find(Auth::user()->id);
            $user->accessToken = $user->createToken('appToken')->accessToken;

            return $this->sendResponse(
                __('messages.loggedIn'),
                new UserResource($user)
            );
        } else {
            return $this->sendError(
                'Unauthorised.',
                ['error' => __('messages.authFailed')],
                401
            );
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $request
                ->user()
                ->token()
                ->delete();
            return $this->sendResponse(__('messages.loggedout'));
        } else {
            return $this->sendError(__('messages.authFailed'), 401);
        }
    }
}