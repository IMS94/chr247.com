<?php
namespace Tests\Data;

use App\Admin;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminTest extends TestCase {

    use DatabaseTransactions;

    public function testCreateAndDeleteAdmin() {
        $admin = new Admin();
        $admin->username = "TestAdmin";
        $admin->password = bcrypt("Password");
        $admin->save();

        $this->seeInDatabase('admins', ['username' => $admin->username]);

        $admin->delete();

        $this->dontSeeInDatabase('admins', ['username' => $admin->username]);
    }

}
