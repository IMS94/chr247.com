<?php
namespace Tests\Views;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class QuantityTypesViewTest extends TestCase {
    use DatabaseTransactions;

    /**
     * Visiting the view.
     */
    public function testVisitView() {
        $user = User::find(1);
        $this->actingAs($user)
            ->visit('drugs/drugTypes')
            ->see('Quantity Types');
    }
}
