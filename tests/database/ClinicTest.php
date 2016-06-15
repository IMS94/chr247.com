<?php

namespace Tests\Database;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ClinicTest extends TestCase {
//    use DatabaseTransactions;

    private $clinic;

    public function testCreateClinic() {
        $this->clinic = factory('App\Clinic')->create();
        $this->seeInDatabase('clinics', ['email' => $this->clinic->email]);
    }

    /**
     * @after testCreateClinic
     */
    public function testDeleteClinic() {
        if (!is_null($this->clinic)) {
            $this->clinic->delete();
            $this->dontSeeInDatabase('clinics', ['email' => $this->clinic->email]);
        }
    }
}
