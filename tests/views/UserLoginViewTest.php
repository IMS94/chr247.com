<?php
namespace Tests\Views;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserLoginViewTest extends TestCase {
    use DatabaseTransactions;

    private $username = 'imesha';
    private $password = "1234";

    public function testDeactivatedUserLogin() {
        $user = User::where('username', $this->username)->first();
        $user->active = false;
        $user->update();

        $this->visit('login')
            ->type($this->username, 'username')
            ->type($this->password, 'password')
            ->press('Login')
            ->seePageIs('login')
            ->see("These credentials do not match our records.");

        $user->active = true;
        $user->update();

        $this->visit('login')
            ->type($this->username, 'username')
            ->type($this->password, 'password')
            ->press('Login')
            ->seePageIs('/');
    }
}
