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

}
