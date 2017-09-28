<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Helper extends Model {

    public function getBidServices($bid_id) {
        $table = config('crm_tables.uon_bid_services');
        $services = DB::table($table)
                ->where('r_id', '=', $bid_id)
                ->get();
        return $services;
    }

    public function getBidFlights($bid_id) {
        $table = config('crm_tables.uon_bid_flights');
        $flights = DB::table($table)
                ->where('r_id', '=', $bid_id)
                ->get();
        return $flights;
    }

    public function getBidPayments($bid_id) {
        $table = config('crm_tables.uon_bid_payments');
        $payments = DB::table($table)
                ->where('r_id', '=', $bid_id)
                ->get();
        return $payments;
    }
    public function getCashData($id) {
        $table = config('crm_tables.uon_cash');
        $cash = DB::table($table)
                ->where('id', '=', $id)
                ->first();
        return $cash;
    }
    public function getRemindersData($id) {
        $table = config('crm_tables.uon_bid_reminders');
        $reminders = DB::table($table)
                ->where('r_id', '=', $id)
                ->get();
        return $reminders;
    }
    public function getFlys($r_id) {
        $table = config('crm_tables.uon_bid_flights');
        $flys = DB::table($table)
                ->where('r_id','=',$r_id)
                ->get();
        return $flys;
    }

}
