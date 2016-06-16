<?php
namespace Tests\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Tests\TestCase;

class SettingsControllerTest extends TestCase {

    use DatabaseTransactions;

    private $adminUser, $nurseUser, $doctorUser;

    public function setUp() {
        parent::setUp();
        $this->adminUser = User::where('role_id', 1)->first();
        $this->nurseUser = User::where('role_id', 3)->first();
        $this->doctorUser = User::where('role_id', 2)->first();
    }

    public function testViewSettings() {
        $this->actingAs($this->adminUser)
            ->visit('/settings')
            ->see('Settings');
    }

    public function testChangePassword() {
        //success scenario
        $this->actingAs($this->nurseUser)
            ->call('POST', 'settings/changePassword', [
                'current_password'      => '1234',
                'password'              => '12345',
                'password_confirmation' => '12345'
            ]);
        $this->assertSessionHas("errors");

        // Failure Scenario
        $this->actingAs($this->nurseUser)
            ->call('POST', 'settings/changePassword', [
                'current_password'      => '1234',
                'password'              => '123456',
                'password_confirmation' => '123456'
            ]);
        $this->assertSessionHas("success", 'Password Changed Successfully');
    }

    public function testCreateAccount() {
        //success scenario
        $newUser = factory(User::class, 1)->make();
        $response = $this->actingAs($this->adminUser)
            ->call('POST', 'settings/createAccount', [
                'user_name'                  => $newUser->name,
                'user_username'              => $newUser->username,
                'user_role'                  => $newUser->role_id,
                'user_password'              => "123456",
                'user_password_confirmation' => '123456'
            ]);
        if ($newUser->role_id == 1) {
            $this->assertSessionHas("errors");
        } else {
            $this->assertSessionHas("success");
            $this->seeInDatabase('users', ['username' => $newUser->username]);
        }

        //fail scenarios - unauthorized accesses.
        $newUser = factory(User::class, 1)->make();
        $response = $this->actingAs($this->nurseUser)
            ->call('POST', 'settings/createAccount', [
                'user_name'     => $newUser->name,
                'user_username' => $newUser->username,
                'user_role'     => $newUser->role_id,
                'user_password' => "123456"
            ]);
        $this->assertTrue($response->status() == 401);
    }


    public function testAccountDeactivation() {
        $user = $this->adminUser->clinic->users()->where('role_id', '<>', 1)
            ->where('active', true)->first();

        $this->actingAs($this->adminUser)
            ->call("GET", 'settings/deleteAccount/' . $user->id);
        $this->seeInDatabase('users', ['id' => $user->id, 'active' => false]);

        $this->actingAs($this->adminUser)
            ->call("GET", 'settings/deleteAccount/' . $user->id);
        $this->seeInDatabase('users', ['id' => $user->id, 'active' => true]);

        $response = $this->actingAs($this->doctorUser)
            ->call("GET", 'settings/deleteAccount/' . $user->id);
        $this->assertEquals(401, $response->status());
        $this->dontSeeInDatabase('users', ['id' => $user->id, 'active' => false]);

        $response = $this->actingAs($this->nurseUser)
            ->call("GET", 'settings/deleteAccount/' . $user->id);
        $this->assertEquals(401, $response->status());
        $this->dontSeeInDatabase('users', ['id' => $user->id, 'active' => false]);
    }
}
