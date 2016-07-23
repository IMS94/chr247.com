<?php
/**
 * Created by PhpStorm.
 * User: imesha
 * Date: 4/12/16
 * Time: 6:11 PM
 */

namespace App\Lib;


use App\Clinic;

class Utils {
    /**
     * Get the age once a birthday is given
     * @param $date
     * @return string
     */
    public static function getAge($date) {
        $d = date_diff(date_create($date), date_create('today'));
        $text = "";
        if ($date) {
            $text .= $d->y == 0 ? "" : $d->y . " yrs";
            $text .= $d->y < 5 ? " " . $d->m . " months" : "";
            $text .= $d->y < 1 ? " " . $d->d . " days" : "";
        }
        return $date ? $text : "-";
    }


    /**
     * Get the readable date and time from a timestamp
     * @param $timestamp
     * @return bool|string
     */
    public static function getTimestamp($timestamp) {
        $clinic = Clinic::getCurrentClinic();
        return date("jS M, Y h:i A", strtotime($timestamp->timezone($clinic->timezone)));
    }

    /**
     * Get a date formatted. Ex: 9th May, 2015
     * @param $date
     * @return bool|string
     */
    public static function getFormattedDate($date) {
        $clinic = Clinic::getCurrentClinic();
        $date = date_create($date, timezone_open($clinic->timezone));
        return date_format($date, "jS M, Y");
    }


    /**
     * Check id a patient is a Male
     * @param $patient
     * @return bool
     */
    public static function isMale($patient) {
        return $patient->gender === "Male";
    }


    /**
     * Check id a patient is a Female
     * @param $patient
     * @return bool
     */
    public static function isFemale($patient) {
        return $patient->gender === "Female";
    }
}