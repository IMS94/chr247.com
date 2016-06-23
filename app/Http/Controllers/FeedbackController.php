<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class FeedbackController extends Controller {

    public function getFeedbackForm() {
        return view('feedback.feedback');
    }

    /**
     * Emails the feedback entered by a user
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function sendFeedback(Request $request) {
        $validator = \Validator::make($request->all(), [
            'feedback' => 'required|min:20,max:200'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = User::getCurrentUser();
        \Mail::send('emails.feedback', ['feedback' => $request->feedback, 'user' => $user], function ($m) {
            $m->to("imesha@highflyer.lk", "CHR 24x7 Dev")->subject('CHR247.COM - User Feedback');
        });

        return back()->with('success', "Feedback submitted successfully. Thank you for your feedback!");
    }
}
