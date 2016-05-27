<?php

/**
 * Created by PhpStorm.
 * User: imesha
 * Date: 5/26/16
 * Time: 9:49 PM
 */
class APIControllerTest extends TestCase {

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    /**
     * Check if get drugs method functions correctly.
     */
    public function testGetDrugs() {
        $user = \App\User::where('role_id', 1)->first();
        $drug = $user->clinic->drugs()->first();
        $this->actingAs($user)
            ->json('POST', 'API/drugs')
            ->seeJson(['id' => $drug->id]);
    }

    /**
     * test get dosages method
     */
    public function testGetDosages() {
        $user = \App\User::where('role_id', 1)->first();
        $dasage = $user->clinic->dosages()->first();
        $this->actingAs($user)
            ->json('POST', 'API/dosages')
            ->seeJson(['id' => $dasage->id, 'description' => $dasage->description]);
    }

    /**
     * test save prescription method
     */
    public function testSavePrescription() {
        $user = \App\User::where('role_id', 2)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/savePrescription', [
                'complaints'      => "Fever",
                'id'              => $patient->id,
                'diagnosis'       => 'Fever',
                'prescribedDrugs' => []
            ])
            ->seeJson(['status' => 1])
            ->seeInDatabase('prescriptions', ['patient_id' => $patient->id, 'complaints' => 'Fever', 'diagnosis' => 'Fever']);
    }

    /**
     * Test get prescriptions method
     */
    public function testGetPrescriptions() {
        $user = \App\User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/getPrescriptions/' . $patient->id)
            ->seeJson(['status' => 1]);
    }

    /**
     * Test get remaining prescriptions method
     */
    public function testGetAllRemainingPrescriptions() {
        $user = \App\User::where('role_id', 1)->first();
        $this->actingAs($user)
            ->json('POST', 'API/getAllPrescriptions')
            ->seeJson(['status' => 1]);
    }

    /**
     * test issue prescription method
     */
    public function testIssuePrescription() {
        $user = \App\User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $prescription = $patient->prescriptions()->where('issued', false)->first();
        $drugs = [];
        foreach ($prescription->prescriptionDrugs()->get() as $d) {
            $drugs[] = ['id' => $d->id, 'issuedQuantity' => 20];
        }
        $this->actingAs($user)
            ->json('POST', 'API/issuePrescription', [
                'prescription' => [
                    'id'                 => $prescription->id,
                    'payment'            => 100,
                    'paymentRemarks'     => 'None',
                    'prescription_drugs' => $drugs
                ]
            ])
            ->seeJson(['status' => 1]);
    }

    /**
     * test delete prescription method
     */
    public function testDeletePrescription() {
        $user = \App\User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $prescription = $patient->prescriptions()->where('issued', false)->first();
        $this->actingAs($user)
            ->json('POST', 'API/deletePrescription/' . $prescription->id)
            ->seeJson(['status' => 1]);
    }


    /**
     * Test get medical records method
     */
    public function testGetMedicalRecords() {
        $user = \App\User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/getMedicalRecords/' . $patient->id)
            ->seeJson(['status' => 1]);
    }
}
