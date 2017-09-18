<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class BidsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function BidsList() {
        $table_name = config('crm_tables.uon_bids');
        $table_users = config('crm_tables.uon_users_table');
        $table_sourses = config('crm_tables.uon_sourses');
        $bids = DB::table($table_name)
                        ->leftJoin($table_users, $table_users . '.u_id', '=', $table_name . '.r_client_id')
                        ->leftJoin($table_sourses, $table_name . '.r_source_id', '=', $table_sourses . '.uon_id')
                        ->orderBy('r_id', 'desc')->paginate(50);
        return view('layouts.bid.bids_list', ['bids' => $bids]);
    }

    public function BidEdit(Request $request) {
        $table_name = config('crm_tables.uon_bids');
        $table_users = config('crm_tables.uon_users_table');
        $table_sourses = config('crm_tables.uon_sourses');
        $bid = DB::table($table_name)
                ->leftJoin($table_users, $table_users . '.u_id', '=', $table_name . '.r_client_id')
                ->leftJoin($table_sourses, $table_name . '.r_source_id', '=', $table_sourses . '.uon_id')
                ->where('r_id', '=', $request->id)
                ->first();
        return view('layouts.bid.bid_edit', ['bid' => $bid]);
    }

    public function BidChange(Request $request) {
        return false;
    }

}
