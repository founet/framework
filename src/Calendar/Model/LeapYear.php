<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18/01/2018
 * Time: 15:03
 */

namespace Calendar\Model;

class LeapYear
{
    public function isLeapYear($year = null)
    {
        if (null === $year) {
            $year = date('Y');
        }

        return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
    }
}