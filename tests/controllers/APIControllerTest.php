<?php
namespace Tests\Controllers;

use App\User;
use Tests\TestCase;

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
        $user = User::where('role_id', 1)->first();
        $drug = $user->clinic->drugs()->first();
        $this->actingAs($user)
            ->json('POST', 'API/drugs')
            ->seeJson(['id' => $drug->id]);
    }

    /**
     * test get dosages method
     */
    public function testGetDosages() {
        $user = User::where('role_id', 1)->first();
        $dasage = $user->clinic->dosages()->first();
        $this->actingAs($user)
            ->json('POST', 'API/dosages')
            ->seeJson(['id' => $dasage->id, 'description' => $dasage->description]);
    }

    /**
     * test save prescription method
     */
    public function testSavePrescriptionWithoutAnyDrug() {
        $user = User::where('role_id', 2)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/savePrescription', [
                'complaints'      => "Fever",
                'id'              => $patient->id,
                'diagnosis'       => 'Fever with No Drugs',
                'prescribedDrugs' => [],
                'pharmacyDrugs'   => []
            ])
            ->seeJson(['status' => 1])
            ->seeInDatabase('prescriptions',
                ['patient_id' => $patient->id, 'complaints' => 'Fever', 'diagnosis' => 'Fever with No Drugs']);
    }

    public function testSavePrescriptionWithPharmacyDrugsOnly() {
        $user = User::where('role_id', 2)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/savePrescription', [
                'complaints'      => "Fever",
                'id'              => $patient->id,
                'diagnosis'       => 'Fever with Pharmacy Drugs Only',
                'prescribedDrugs' => [],
                'pharmacyDrugs'   => [
                    ['name' => 'Amoxicilin 250', 'remarks' => 'For 1 week'],
                    ['name' => 'Cetricine']
                ]
            ])
            ->seeJson(['status' => 1]);
        $prescription = $patient->prescriptions()->orderBy('id', 'DESC')->first();
        $this->assertNotNull($prescription);
        $this->assertEquals('Fever with Pharmacy Drugs Only', $prescription->diagnosis);
        $this->assertEquals(2, $prescription->prescriptionPharmacyDrugs()->count());
    }

    public function testSavePrescriptionWithDrugsOnly() {
        $user = User::where('role_id', 2)->first();
        $patient = $user->clinic->patients()->first();
        $drugs = $user->clinic->drugs()->take(3)->get();
        $dose = $user->clinic->dosages()->take(2)->get();
        $frequency = $user->clinic->dosageFrequencies()->first();
        $dosagePeriod = $user->clinic->dosagePeriods()->first();
        $this->actingAs($user)
            ->json('POST', 'API/savePrescription', [
                'complaints'      => "Fever",
                'id'              => $patient->id,
                'diagnosis'       => 'Fever with Drugs Only',
                'prescribedDrugs' => [[
                    'drug'      => ['id' => $drugs[0]->id],
                    'dose'      => ['id' => $dose[0]->id],
                    'frequency' => ['id' => $frequency->id],
                    'period'    => null
                ], [
                    'drug'      => ['id' => $drugs[1]->id],
                    'dose'      => ['id' => $dose[1]->id],
                    'frequency' => null,
                    'period'    => null
                ]],
                'pharmacyDrugs'   => []
            ])
            ->seeJson(['status' => 1]);
        $prescription = $patient->prescriptions()->orderBy('id', 'DESC')->first();
        $this->assertNotNull($prescription);
        $this->assertEquals('Fever with Drugs Only', $prescription->diagnosis);
        $this->assertEquals(2, $prescription->prescriptionDrugs()->count());
    }


    public function testSavePrescriptionWithAllDrugs() {
        $user = User::where('role_id', 2)->first();
        $patient = $user->clinic->patients()->first();
        $drugs = $user->clinic->drugs()->take(3)->get();
        $dose = $user->clinic->dosages()->take(2)->get();
        $frequency = $user->clinic->dosageFrequencies()->first();
        $dosagePeriod = $user->clinic->dosagePeriods()->first();
        $this->actingAs($user)
            ->json('POST', 'API/savePrescription', [
                'complaints'      => "Fever",
                'id'              => $patient->id,
                'diagnosis'       => 'Fever with Drugs Only',
                'prescribedDrugs' => [[
                    'drug'      => ['id' => $drugs[0]->id],
                    'dose'      => ['id' => $dose[0]->id],
                    'frequency' => ['id' => $frequency->id],
                    'period'    => null
                ], [
                    'drug'      => ['id' => $drugs[1]->id],
                    'dose'      => ['id' => $dose[1]->id],
                    'frequency' => null,
                    'period'    => null
                ]],
                'pharmacyDrugs'   => [
                    ['name' => 'Amoxicilin 250', 'remarks' => 'For 1 week'],
                    ['name' => 'Cetricine']
                ]
            ])
            ->seeJson(['status' => 1]);
        $prescription = $patient->prescriptions()->orderBy('id', 'DESC')->first();
        $this->assertNotNull($prescription);
        $this->assertEquals('Fever with Drugs Only', $prescription->diagnosis);
        $this->assertEquals(2, $prescription->prescriptionDrugs()->count());
        $this->assertEquals(2, $prescription->prescriptionPharmacyDrugs()->count());
    }

    public function testSavePrescriptionWithSameDrugTwice() {
        $user = User::where('role_id', 2)->first();
        $patient = $user->clinic->patients()->first();
        $drugs = $user->clinic->drugs()->take(3)->get();
        $dose = $user->clinic->dosages()->take(2)->get();
        $frequency = $user->clinic->dosageFrequencies()->first();
        $dosagePeriod = $user->clinic->dosagePeriods()->first();
        $this->actingAs($user)
            ->json('POST', 'API/savePrescription', [
                'complaints'      => "Fever",
                'id'              => $patient->id,
                'diagnosis'       => 'Fever with Drugs Only',
                'prescribedDrugs' => [[
                    'drug'      => ['id' => $drugs[0]->id],
                    'dose'      => ['id' => $dose[0]->id],
                    'frequency' => ['id' => $frequency->id],
                    'period'    => null
                ], [
                    'drug'      => ['id' => $drugs[0]->id],
                    'dose'      => ['id' => $dose[1]->id],
                    'frequency' => null,
                    'period'    => null
                ]],
                'pharmacyDrugs'   => [
                    ['name' => 'Amoxicilin 250', 'remarks' => 'For 1 week'],
                    ['name' => 'Cetricine']
                ]
            ])
            ->seeJson(['status' => 0]);
    }

    /**
     * Test get prescriptions method
     */
    public function testGetPrescriptions() {
        $user = User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/getPrescriptions/' . $patient->id)
            ->seeJson(['status' => 1]);
    }

    /**
     * Test get remaining prescriptions method
     */
    public function testGetAllRemainingPrescriptions() {
        $user = User::where('role_id', 1)->first();
        $this->actingAs($user)
            ->json('POST', 'API/getAllPrescriptions')
            ->seeJson(['status' => 1]);
    }

    /**
     * test issue prescription method
     */
    public function testIssuePrescription() {
        $user = User::where('role_id', 1)->first();
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
        $user = User::where('role_id', 1)->first();
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
        $user = User::where('role_id', 1)->first();
        $patient = $user->clinic->patients()->first();
        $this->actingAs($user)
            ->json('POST', 'API/getMedicalRecords/' . $patient->id)
            ->seeJson(['status' => 1]);
    }
}
