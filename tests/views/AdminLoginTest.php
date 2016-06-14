<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminLoginTest extends TestCase {
    private $username = "Admin";
    private $password = "admin123";

    public function testLoginSuccess() {
        $this->visit("Admin/login")
            ->see("Admin Login");

        $this->type($this->username, 'username')
            ->type($this->password, 'password')
            ->press("Login")
            ->seePageIs("Admin/admin")
            ->see("Clinics To Be Accepted");
    }

    public function testAdminURLAccess() {
        $this->visit("Admin/admin")
            ->see("Login");
    }
}
