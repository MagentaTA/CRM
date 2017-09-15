<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myDate extends Model {

    public function getBirthdayDate($date) {
        if ($date <> '0000-00-00') {
            return date('d.m.Y', strtotime($date));
        }
    }

}
