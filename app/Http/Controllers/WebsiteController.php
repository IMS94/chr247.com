<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WebsiteController extends Controller {

    public function getAboutUsPage() {
        return view("website.aboutUs");
    }

    public function getFeaturesPage() {
        return view("website.features");
    }

    public function getPrivacyPolicyPage() {
        return view("website.privacyPolicy");
    }
}
