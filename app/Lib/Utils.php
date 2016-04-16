<?php
/**
 * Created by PhpStorm.
 * User: imesha
 * Date: 4/12/16
 * Time: 6:11 PM
 */

namespace App\Lib;


use Illuminate\Support\Facades\Log;

class Utils
{
    /**
     * Get the age once a birthday is given
     * @param $date
     * @return string
     */
    public static function getAge($date)
    {
        return $date ? date_diff(date_create($date), date_create('today'))->y . " yrs" : "-";
    }


    /**
     * Get the readable date from a timestamp
     * @param $timestamp
     * @return bool|string
     */
    public static function getTimestamp($timestamp)
    {
        return date("jS M,Y H:i:s", strtotime($timestamp));
    }


    /**
     * Check id a patient is a Male
     * @param $patient
     * @return bool
     */
    public static function isMale($patient)
    {
        return $patient->gender === "Male";
    }


    /**
     * Check id a patient is a Female
     * @param $patient
     * @return bool
     */
    public static function isFemale($patient)
    {
        return $patient->gender === "Female";
    }
}