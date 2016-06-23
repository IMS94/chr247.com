<?php
namespace Tests\Controllers;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase {

    public function testSubmitFeedbackSuccess() {
        $user = User::first();
        $this->actingAs($user)
            ->visit('feedback')
            ->see("Give Us Your Feedback");

        $this->actingAs($user)
            ->visit('feedback')
            ->type("This is a random test feedback. Please ignore the content", "feedback")
            ->press("Submit")
            ->seeInSession("success");


        $this->actingAs($user)
            ->visit('feedback')
            ->type("This is a ran.", "feedback")
            ->press("Submit");
        $this->seeInSession("errors");

    }
}
