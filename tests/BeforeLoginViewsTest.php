<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BeforeLoginViewsTest extends TestCase {

    use DatabaseTransactions;

    private $username = 'florian06';
    private $password = "123456";

    /**
     * Test method to test the Login page
     */
    public function testLogin() {
        // see the login page
        $this->visit('/')->see('Login');

        //type username and press login
        $this->visit('/')
            ->type($this->username, 'username')
            ->type($this->password, 'password')
            ->press('Login')
            ->see('Home');
    }

    /**
     * Test method to test registration of a clinic
     */
    public function testRegisterClinicFail() {
        $this->visit('/')
            ->click('Register')
            ->seePageIs('/registerClinic');

        //register a clinic and check if the clinic registers correctly
        $this->visit('registerClinic')
            ->type('Admin\'s Clinic', 'name')
            ->type('imesha@highflyer.lk', 'email')
            ->type('24,Kudagammana, Divulapitiya', 'address')
            ->type('0717086160', 'phone')
            ->select('LK', 'country')
            ->type('Rupees', 'currency')
            ->type('Imesha Sudasingha', 'adminName')
            ->type('imesha94', 'username')
            ->type('123456', 'password')
            ->type('123456', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/registerClinic')
            ->see('The timezone must be a valid zone.');
    }


    /**
     * Test registration of a new clinic
     */
    public function testRegisterClinicSuccess() {
        //register a clinic and check if the clinic registers correctly
        $response = $this->call('POST', '/registerClinic', [
            'name'                  => 'Admin\'s Clinic',
            'email'                 => 'imesha@highflyer.lk',
            'address'               => '24, Divulapitiya',
            'phone'                 => '0717086160',
            'country'               => 'LK',
            'timezone'              => 'Asia/Colombo',
            'currency'              => 'Rupees',
            'adminName'             => 'Imesha Sudasingha',
            'username'              => 'imesha94',
            'password'              => '123456',
            'password_confirmation' => '123456'
        ]);

        $this->seeInDatabase('clinics', ['email' => 'imesha@highflyer.lk']);
    }

    /**
     * Test forgot password page
     */
    public function testForgotPasswordView() {
        $this->visit('/')
            ->click('Forgot Your Password?')
            ->seePageIs('/password/reset')
            ->see('Reset Password');

        $this->type('imesha@highflyer.lk', 'email')
            ->press('Send Password Reset Link')
            ->see('We have e-mailed your password reset link!');

    }
}
