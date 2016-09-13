<?php

namespace App\Lib;

use App\User;
use Auth;
use Log;

// TODO Implement the logger if required
class Logger {

    public static function info($message, array $array = null) {
        $user = User::getCurrentUser();
        $error = Auth::check() ? "CLINIC:" . $user->clinic->id . ",USER:" . $user->id . "," . $message : $message;
        Log::info($error, $array);
    }

    public static function error($message, array $array = null) {
        $user = User::getCurrentUser();
        $error = Auth::check() ? "CLINIC:" . $user->clinic->id . ",USER:" . $user->id . "," . $message : $message;
        Log::error($error, $array);
    }
}