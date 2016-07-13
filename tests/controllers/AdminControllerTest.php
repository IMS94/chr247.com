<?php
namespace Tests\Controllers;

use App\Admin;
use App\Clinic;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminControllerTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * Test if the accept clinic method adds required basic quantity types to the clinic
     */
    public function testAcceptClinic() {
        $clinic = factory(\App\Clinic::class)->create();
        $user = factory(User::class)->make();
        $clinic->users()->save($user);
        $clinic->save();

        // check if it is added to the database.
        $this->seeInDatabase('clinics', ['id' => $clinic->id, 'accepted' => 0]);

        $admin = Admin::first();
        $this->assertNotNull($admin);
        $this->actingAs($admin)->call('GET', 'Admin/acceptClinic/' . $clinic->id);
        $this->assertSessionHas("success");

        //check if the clinic is now accepted.
        $this->seeInDatabase('clinics', ['id' => $clinic->id, 'accepted' => 1]);
        $this->assertEquals(5, $clinic->quantityTypes()->count());

        $clinic->quantityTypes()->delete();
        $clinic->users()->delete();
        $clinic->delete();
    }
}
