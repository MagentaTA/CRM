<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class myDate extends Model {

    public function getBirthdayDate($date) {
        if ($date <> '0000-00-00') {
            return date('d.m.Y', strtotime($date));
        }
    }
    public function getDateFromDatetime ($string)
    {
        $carbon = new Carbon();
        $date = $carbon->parse($string);
        $date = $date->format('d.m.Y');
        return $date;
    }

    public function getNormalDate($date) {
        if ($date == '0000-00-00 00:00:00')
        {
            return '';
        }
        $carbon = new Carbon();
        $carbon->setToStringFormat('d.m.Y');
        $return_date = $carbon->parse($date,'Europe/London');
        $return_date = $return_date->format('d.m.Y');
        return $return_date;
    }
    public function getNormalDateTime($date) {
        if ($date == '0000-00-00 00:00:00')
        {
            return '';
        }
        $carbon = new Carbon();
        $carbon->setToStringFormat('d.m.Y H:i:s');
        $return_date = $carbon->parse($date,'Europe/London');
        $return_date = $return_date->format('d.m.Y H:i:s');
        return $return_date;
    }

}
