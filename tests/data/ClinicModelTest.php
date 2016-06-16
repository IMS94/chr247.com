<?php

namespace Tests\Data;

use App\Clinic;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ClinicModelTest extends TestCase {
    use DatabaseTransactions;

    private $clinic;

    public function testClinicModel() {
        $this->createClinic();
        $this->createUsers();

        $this->deleteClinicUnsuccessful();
        $this->deleteClinic();
    }

    /**
     * Create th clinic
     */
    private function createClinic() {
        $this->clinic = factory(Clinic::class)->create();
        $this->seeInDatabase('clinics', ['email' => $this->clinic->email]);
    }

    /**
     * Create Users of the Clinic
     */
    private function createUsers() {
        factory(User::class, 3)->make()->each(function (User $user) {
            $this->clinic->users()->save($user);
        });

        $this->assertEquals(3, $this->clinic->users()->count());
    }

    /**
     * Attempt to delete The clinic.
     * Should be unsuccessful due to foreign key constraint.
     */
    private function deleteClinicUnsuccessful() {
        try {
            $this->clinic->delete();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PDOException);
        }
        $this->seeInDatabase('clinics', ['email' => $this->clinic->email]);
    }

    /**
     * Successfully delete the clinic finally.
     */
    private function deleteClinic() {
        $this->clinic->users()->delete();
        $this->clinic->delete();
        $this->dontSeeInDatabase('clinics', ['email' => $this->clinic->email]);
    }
}
