<?php

namespace App\Lib;


use App\Clinic;

/**
 * Class Utils
 * Utility class for chr247.com
 * @package App\Lib
 */
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

    /**
     * Formats numbers by removing trailing zeros in after the decimal place
     * @param $num
     * @return float
     */
    public static function getFormattedNumber($num) {
        return floatval($num);
    }

    /**
     * The post fix appended to URLs in order to prevent browser caching
     * @param $length |5 the length of the post fix
     * @return string the post fix to prevent caching
     */
    public static function getCachePreventPostfix($length = 5) {
        return "rev=" . str_random($length);
    }
}