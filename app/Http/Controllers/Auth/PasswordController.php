<?php

namespace App\Http\Controllers\Auth;

use App\Clinic;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = "login";

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request) {
        $this->validate($request, ['email' => 'required|email|exists:clinics']);

        $broker = $this->getBroker();

        // Get the admin of that clinic
        $clinic = Clinic::where('email', $request->email)->first();
        $credentials = ['clinic_id' => $clinic->id, 'role_id' => 1];

        $response = Password::broker($broker)->sendResetLink(
            $credentials, $this->resetEmailBuilder()
        );

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->getSendResetLinkEmailSuccessResponse($response);

            case Password::INVALID_USER:
            default:
                return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request) {
        $this->validate(
            $request,
            $this->getResetValidationRules(),
            $this->getResetValidationMessages(),
            $this->getResetValidationCustomAttributes()
        );

        // Get the admin of that clinic
        $clinic = Clinic::where('email', $request->email)->first();
        $credentials = [
            'clinic_id'             => $clinic->id,
            'role_id'               => 1,
            'password'              => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'token'                 => $request->token
        ];

        $broker = $this->getBroker();

        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return $this->getResetSuccessResponse($response);

            default:
                return $this->getResetFailureResponse($request, $response);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password) {
        $user->forceFill([
            'password'       => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetSuccessResponse($response) {
        return redirect($this->redirectPath())->with('success', trans($response));
    }
}
