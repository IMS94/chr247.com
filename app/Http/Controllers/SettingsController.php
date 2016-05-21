<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller {
    /**
     * Shows the settings view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewSettings() {
        return view('settings.settings');
    }


    /**
     * Changes a user's password
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:6'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // check the current user's password and the entered password using hash helper function
        $user = User::getCurrentUser();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->update();
            return back()->with('success', 'Password Changed Successfully');
        }
        return back()->withInput()->withErrors(['current_password' => 'Your current password is incorrect']);
    }


    /**
     * Creates a new account
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function createAccount(Request $request) {
        // check if the user can create new users
        $this->authorize('register', 'App\User');

        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|max:255',
            'user_username' => 'required|unique:users,username',
            'user_role'     => 'required|exists:roles,id,role,!Admin',
            'user_password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->user_name;
        $user->username = $request->user_username;
        $user->password = bcrypt($request->user_password);
        $user->role()->associate($request->user_role);
        $user->clinic()->associate(Clinic::getCurrentClinic());
        $user->save();
        return back()->with('success', 'User Created Successfully');
    }
}
