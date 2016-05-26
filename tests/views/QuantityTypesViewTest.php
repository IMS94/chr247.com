<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuantityTypesViewTest extends TestCase {
    use DatabaseTransactions;

    /**
     * Visiting the view.
     */
    public function testVisitView() {
        $user = \App\User::find(1);
        $this->actingAs($user)
            ->visit('drugs/drugTypes')
            ->see('Quantity Types');
    }
}
