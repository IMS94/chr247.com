<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DosageControllerTest extends TestCase {

//    use DatabaseTransactions;

    public function testViewDosages() {
        $user = \App\User::first();
        $this->actingAs($user)
            ->visit('drugs/dosages')
            ->see("Dosages")
            ->see("Dosage Frequencies")
            ->see("Dosage Periods");
    }

    public function testAddDosage() {
        $user = \App\User::first();
        $this->actingAs($user)
            ->call('POST', 'drugs/addDosage', ['dosageDescription' => 'Some Description']);
        $this->assertSessionHas('success', "Dosage added successfully !");

        $this->actingAs($user)
            ->call('POST', 'drugs/addDosage', ['dosageDescription' => 'Some Description']);
        $this->assertSessionHas('errors');
    }

    public function testAddFrequency() {
        $user = \App\User::first();
        $this->actingAs($user)
            ->call('POST', 'drugs/addFrequency', ['frequencyDescription' => 'Some Description']);
        $this->assertSessionHas('success', "Dosage Frequency added successfully !");

        $this->actingAs($user)
            ->call('POST', 'drugs/addFrequency', ['frequencyDescription' => 'Some Description']);
        $this->assertSessionHas('errors');

    }

    public function testAddPeriod() {
        $user = \App\User::first();
        $this->actingAs($user)
            ->call('POST', 'drugs/addPeriod', ['description' => 'Some Description']);
        $this->assertSessionHas('success', "Dosage Period added successfully !");

        $this->actingAs($user)
            ->call('POST', 'drugs/addPeriod', ['description' => 'Some Description']);
        $this->assertSessionHas('errors');

    }

    public function testDeleteDosage() {
        $user = \App\User::where('role_id', 1)->first();
        $dosage = $user->clinic->dosages()->where('description', 'Some Description')->first();
        $this->actingAs($user)
            ->call('GET', 'drugs/deleteDosage/' . $dosage->id);
        $this->assertSessionHas('success', 'Entry deleted successfully');
    }


    public function testDeleteFrequency() {
        $user = \App\User::where('role_id', 1)->first();
        $dosage = $user->clinic->dosageFrequencies()->where('description', 'Some Description')->first();
        $this->actingAs($user)
            ->call('GET', 'drugs/deleteFrequency/' . $dosage->id);
        $this->assertSessionHas('success', 'Entry deleted successfully');
    }


    public function testDeletePeriod() {
        $user = \App\User::where('role_id', 1)->first();
        $dosage = $user->clinic->dosagePeriods()->where('description', 'Some Description')->first();
        $this->actingAs($user)
            ->call('GET', 'drugs/deletePeriod/' . $dosage->id);
        $this->assertSessionHas('success', 'Entry deleted successfully');
    }

}
