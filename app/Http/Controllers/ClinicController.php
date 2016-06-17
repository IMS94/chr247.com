<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Lib\Support\Country;
use App\Role;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClinicController extends Controller {

    use RegistersUsers;

    protected $redirectTo = "/";

    /**
     * Show the application registration form only if the user is authenticated
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        return view('auth.registerClinic');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request) {
        return $this->register($request);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if ($this->create($request->all())) {
            return redirect()->to("login")
                ->with('success', 'Your clinic registered successfully. ' .
                    'You will receive a confirmation email once the account is reviewed');
        } else {
            return back()
                ->with('error', 'The clinic could not be registered. Please try again!')->withInput();
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return \Validator::make($data, [
            'name'      => 'required|max:255|min:3',
            'email'     => 'required|email|max:255|unique:clinics',
            'address'   => 'required|min:6',
            'phone'     => 'required',
            'country'   => 'required|in:' . implode(",", array_keys(Country::$countries)),
            'timezone'  => 'required|timezone',
            'currency'  => 'required',
            'adminName' => 'required|min:6',
            'username'  => 'required|unique:users',
            'password'  => 'required|confirmed|min:6',
            'terms'     => 'required|accepted'
        ], [
            'terms.*' => "You have to accept the Terms and Conditions along with the Privacy Policy in order to register"
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * REMEMBER :   Update the $fillable array whenever adding additional attribute to Clinic table
     *
     * @param  array $data
     * @return Clinic
     */
    protected function create(array $data) {
        DB::beginTransaction();
        try {
            $clinic = Clinic::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'address'  => $data['address'],
                'phone'    => $data['phone'],
                'country'  => Country::$countries[$data['country']],
                'timezone' => $data['timezone'],
                'currency' => $data['currency'],
                'accepted' => false
            ]);

            $user = new User();
            $user->name = $data['adminName'];
            $user->username = $data['username'];
            $user->password = bcrypt($data['password']);
            $user->clinic()->associate($clinic);
            $user->role()->associate(Role::where('role', 'Admin')->first());
            $user->save();

        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        DB::commit();
        return true;
    }
}
