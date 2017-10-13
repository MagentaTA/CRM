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
                ->where('r_id', '=', $r_id)
                ->get();
        return $flys;
    }

    public function getBidUserData($r_id) {
        $table_users = config('crm_tables.uon_users_table');
        $table_bid = config('crm_tables.uon_bids');
        $user_id = DB::table($table_bid)
                ->select('r_client_id')
                ->where('r_id', '=', $r_id)
                ->get();
        $user = DB::table($table_users)
                ->where('u_id', '=', $user_id[0]->r_client_id)
                ->first();
        return $user;
    }

    public function getBidDataByUser($u_id) {
        $Bid_table = config('crm_tables.uon_bids');
        $Bids_by_user = DB::table($Bid_table)
                ->where('r_client_id', '=', $u_id)
                ->orderBy('r_date_end', 'desc')
                ->get();
        return $Bids_by_user;
    }

    public function getUserData($u_id) {
        $User_table = config('crm_tables.uon_users_table');
        $Users = DB::table($User_table)
                ->where('u_id', '=', $u_id)
                ->first();
        return $Users;
    }

    public function getManagerData($m_id) {
        $User_table = config('crm_tables.uon_managers');
        $Users = DB::table($User_table)
                ->where('u_id', '=', $m_id)
                ->first();
        return $Users;
    }

    public function get_Q_by_O($opros_id) {
        $questions_table = config('crm_tables.crm_cc_questions');
        $Q_by_O = DB::table($questions_table)
                ->where('opros_id', '=', $opros_id)
                ->get();
        return $Q_by_O;
    }

    public function get_A_by_Q($q_id) {
        $answers_table = config('crm_tables.crm_cc_answers');
        $A_by_Q = DB::table($answers_table)
                ->where('q_id', '=', $q_id)
                ->get();
        return $A_by_Q;
    }

    public function get_Q_data($q_id) {
        $questions_table = config('crm_tables.crm_cc_questions');
        $Q_data = DB::table($questions_table)
                ->where('q_id', '=', $q_id)
                ->first();
        return $Q_data;
    }

    public function get_status_bid_color($status_id) {
        $status_table = config('crm_tables.uon_statuses');
        $status_data = DB::table($status_table)
                ->where('stat_id', '=', $status_id)
                ->first();
        return $status_data;
    }

    public function getBidData($r_id) {
        $Bid_table = config('crm_tables.uon_bids');
        $Bid_data = DB::table($Bid_table)
                ->where('r_id', '=', $r_id)
                ->first();
        return $Bid_data;
    }
    public function getOffices() {
        $Offices_table = config('crm_tables.crm_offices');
        $Offices_data = DB::table($Offices_table)
                ->get();
        return $Offices_data;
    }

}
