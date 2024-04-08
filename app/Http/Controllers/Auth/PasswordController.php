<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostChangePassword;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(PostChangePassword $request): RedirectResponse
    {
        dd($request->new_password);

        $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function checkCurrentPass(Request $request)
    {
        try {

            $currentPassword = $request->input('current_password');

            // Get the authenticated user
            $user = Auth::user();

            // Check if the current password matches the one stored in the database
            if (Hash::check($currentPassword, $user->password)) {
                return response()->json(true); // Password matches
            } else {
                return response()->json(false); // Password does not match
            }

            exit;
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(false);
        }
    }
}
