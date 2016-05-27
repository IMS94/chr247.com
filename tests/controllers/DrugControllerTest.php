<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DrugControllerTest extends TestCase {

    use DatabaseTransactions;

    public function testGetDrugListView() {
        $user = \App\User::first();
        $this->actingAs($user)
            ->visit('drugs')
            ->see("Drugs")
            ->see('Drug Name');
    }

    public function testGetDrugView() {
        $user = \App\User::first();
        $drug = $user->clinic->drugs()->first();
        $this->actingAs($user)
            ->visit('drugs/drug/' . $drug->id)
            ->see($drug->name);
    }

    public function testAddDrug() {
        // Add a drug without initial stock
        $user = \App\User::first();
        $drug = factory(App\Drug::class, 1)->make();
        $quantityType = $user->clinic->quantityTypes()->first();
        $this->actingAs($user)
            ->call('POST', 'drugs/addDrug', [
                'drugName'     => $drug->name,
                'manufacturer' => $drug->manufacturer,
                'quantityType' => $quantityType->id
            ]);
        $this->assertSessionHas('success', "Drug added successfully !");
        $this->seeInDatabase('drugs', [
            'name'         => $drug->name,
            'clinic_id'    => $user->clinic->id,
            'drug_type_id' => $quantityType->id
        ]);

        // Add a drug with initial stock
        $drug = factory(App\Drug::class, 1)->make();
        $stock = factory(App\Stock::class, 1)->make();
        $quantityType = $user->clinic->quantityTypes()->first();
        $this->actingAs($user)
            ->call('POST', 'drugs/addDrug', [
                'drugName'         => $drug->name,
                'manufacturer'     => $drug->manufacturer,
                'quantityType'     => $quantityType->id,
                'quantity'         => $stock->quantity,
                'manufacturedDate' => $stock->manufactured_date,
                'receivedDate'     => $stock->received_date,
                'expiryDate'       => $stock->expiry_date,
                'remarks'          => $stock->remarks
            ]);
        $this->assertSessionHas('success', "Drug added successfully !");
        $this->seeInDatabase('drugs', [
            'name'         => $drug->name,
            'clinic_id'    => $user->clinic->id,
            'drug_type_id' => $quantityType->id
        ]);
        // Check entry in the database
        $drug = \App\Drug::where('name', $drug->name)->where('clinic_id', $user->clinic->id)
            ->where('drug_type_id', $quantityType->id)->first();
        $this->seeInDatabase('stocks', [
            'drug_id'           => $drug->id,
            'manufactured_date' => $stock->manufactured_date,
            'received_date'     => $stock->received_date
        ]);
    }


    public function testDeleteDrug() {
        $user = \App\User::where('role_id', 1)->first();
        $drug = $user->clinic->drugs()->first();
        $this->actingAs($user)
            ->call('POST', 'drugs/deleteDrug/' . $drug->id);
        if (\App\PrescriptionDrug::where('drug_id', $drug->id)->count() > 0) {
            $this->assertSessionHas('error', "The drug cannot be deleted!");
            $this->seeInDatabase('drugs', ['id' => $drug->id]);
        } else {
            $this->assertSessionHas('success', "The drug successfully deleted!");
            $this->dontSeeInDatabase('drugs', ['id' => $drug->id]);
        }
    }

    public function testEditDrug() {
        $user = \App\User::where('role_id', 1)->first();
        $drug = $user->clinic->drugs()->first();
        $this->actingAs($user)
            ->call('POST', 'drugs/editDrug/' . $drug->id, [
                'drugName'     => "Test Drug",
                'manufacturer' => $drug->manufacturer,
                'quantityType' => $drug->drug_type_id
            ]);
        $this->assertSessionHas('success', "Drug updated successfully !");
        $this->seeInDatabase('drugs', ['id' => $drug->id, 'name' => 'Test Drug']);
    }

}
