<?php
namespace Tests\Controllers;

use App\Patient;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Tests\TestCase;

class PatientControllerTest extends TestCase {

    use DatabaseTransactions;

    public function testViewPatients() {
        $this->actingAs(User::first())
            ->visit('patients')
            ->see('Patients');
        $this->seeElement("table");
    }


    public function testAddPatient() {
        $user = User::where('role_id', 1)->first();
        $patient = factory(Patient::class, 1)->make();
        $this->actingAs($user)
            ->call('POST', "patients/addPatient", [
                'firstName'  => $patient->first_name,
                'lastName'   => $patient->last_name,
                'address'    => $patient->address,
                'dob'        => $patient->dob,
                'phone'      => $patient->phone,
                'bloodGroup' => $patient->blood_group,
                'gender'     => $patient->gender
            ]);
        $this->seeInSession("success");
        $this->seeInDatabase('patients', [
            'first_name' => $patient->first_name,
            'created_by' => $user->id,
            'phone'      => $patient->phone
        ]);
        // Delete the saved patient
        $patient = $user->clinic->patients()->orderBy('id', 'DESC')->first();
        $this->actingAs($user)
            ->call('GET', "patients/deletePatient/" . $patient->id);
        $this->dontSeeInDatabase('patients', ['id' => $patient->id]);
    }


    public function testViewSinglePatient() {
        $user = User::first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->visit('patients/patient/' . $patient->id)
            ->see($patient->firstName);
    }


    public function testDeletePatient() {
        $user = User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->call('GET', "patients/deletePatient/" . $patient->id);
        if ($patient->prescriptions()->count() == 0) {
            $this->seeInSession("success");
        } else {
            $this->seeInSession("error");
        }
    }
}
