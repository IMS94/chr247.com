<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Log;
use Mail;
use Validator;

class FeedbackController extends Controller {

    const LOG_CLASS_NAME = "FeedbackController : ";

    public function getFeedbackForm() {
        return view('feedback.feedback');
    }

    /**
     * Emails the feedback entered by a user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendFeedback(Request $request) {
        Log::debug(self::LOG_CLASS_NAME . "Sending feedback : " . $request->feedback);

        $validator = Validator::make($request->all(), [
            'feedback' => 'required|min:20,max:200'
        ]);

        if ($validator->fails()) {
            Log::error($validator->errors());
            return back()->withErrors($validator)->withInput();
        }

        $user = User::getCurrentUser();
        $emails = env("CONTACTUS_MAIL", "chr24x7@gmail.com");
        $emails = explode(",", $emails);

        Mail::send('emails.feedback', ['feedback' => $request->feedback, 'user' => $user], function ($m) use ($emails) {
            $m->to($emails)->subject('CHR247.COM - User Feedback');
        });

        Log::debug(self::LOG_CLASS_NAME . "Feedback sent by user - $user->id");

        return back()->with('success', "Feedback submitted successfully. Thank you for your feedback!");
    }
}
