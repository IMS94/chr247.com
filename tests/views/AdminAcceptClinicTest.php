<?php
namespace Tests\Views;

use App\Admin;
use App\Clinic;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class AdminAcceptClinicTest extends TestCase {

    use DatabaseTransactions;

    private $username = "Admin";
    private $password = "admin123";
    private $clinicEmail = "imesha@highflyer.lk";

    public function testSendMailOnAcceptance() {
        $admin = Admin::first();
        $clinic = Clinic::where('email', $this->clinicEmail)->first();
        if (!$admin || !$clinic) {
            return;
        }
        Clinic::where('accepted', true)->update(['accepted' => true]);
        $clinic->accepted = false;
        $clinic->update();

        $this->visit("Admin/login")
            ->see("Admin Login");

        $this->type($this->username, 'username')
            ->type($this->password, 'password')
            ->press("Login")
            ->seePageIs("Admin/admin")
            ->see("Clinics To Be Accepted")
            ->click("Accept")
            ->see("Success");

        $this->seeInDatabase('clinics', ['email' => $clinic->email, 'accepted' => true]);
    }
}
