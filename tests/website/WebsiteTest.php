<?php
namespace Tests\Website;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WebsiteTest extends TestCase {

    public function testBasicPages() {
        $this->visit("/")->see("Secure | Simple | Practical");
        $this->visit("web/features")->see("Features in detail ...");
        $this->visit("web/privacyPolicy")->see("chr247.com Privacy Policy");
        $this->visit("web/aboutUs")->see("Who We Are?");
        $this->visit("web/contactUs")->see("We will get back to you as soon as possible");
    }

    public function testContactUsForm() {
        $this->visit("web/contactUs")->see("We will get back to you as soon as possible");
        $this->visit("web/contactUs")
            ->type("Imesha Sudasingha", 'name')
            ->type("0717086160", 'contact')
            ->type("imesha@highflyer.lk", "email")
            ->type("This is a chr247.com test message. Please ignore this", "message")
            ->press("Submit")
            ->seePageIs("web/contactUs")
            ->see("Your message submitted successfully. We will contact you soon.");

        $this->visit("web/contactUs")
            ->type("Imesha Sudasingha", 'name')
            ->type("0717086160", 'contact')
            ->type("imesha@hi", "email")
            ->type("This is a chr247.com test message. Please ignore this", "message")
            ->press("Submit")
            ->seePageIs("web/contactUs")
            ->see("Please fill all the fields correctly.");
    }
}
