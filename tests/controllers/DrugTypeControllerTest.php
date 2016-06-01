<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DrugTypeControllerTest extends TestCase {
    use DatabaseTransactions;

    public function testViewDrugTypes() {
        $user = \App\User::first();
        $this->actingAs($user)
            ->visit("drugs/drugTypes")
            ->see("Quantity Types");
    }

    public function testAddDrugType() {
        $drugType = "Sample Drug Type";
        $user = \App\User::first();
        $this->actingAs($user)
            ->call("POST", "drugs/addDrugType", ['drugType' => $drugType]);

        $this->seeInDatabase('drug_types', ['drug_type' => $drugType, 'created_by' => $user->id]);
    }

    public function testDeleteDrugType() {
        $user = \App\User::where('role_id', 1)->first();
        $drugType = $user->clinic->quantityTypes()->first();

        $this->actingAs($user)
            ->call("POST", "drugs/deleteDrugType/" . $drugType->id);
        if (\App\Drug::where('drug_type_id', $drugType->id)->count() > 0) {
            $this->seeInSession("success");
            $this->dontSeeInDatabase('drug_types', ['id' => $drugType->id]);
        } else {
            $this->seeInSession("error");
        }
    }
}