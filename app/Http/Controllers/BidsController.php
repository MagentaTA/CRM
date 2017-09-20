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
        $table_tourist = config('crm_tables.crm_bid_tourist');
        $bid = DB::table($table_name)
                ->leftJoin($table_users, $table_users . '.u_id', '=', $table_name . '.r_client_id')
                ->leftJoin($table_sourses, $table_name . '.r_source_id', '=', $table_sourses . '.uon_id')
                ->where('r_id', '=', $request->id)
                ->first();
        $tourists = DB::table($table_tourist)
                        ->leftJoin($table_users, $table_tourist . '.tourist_id', '=', $table_users . '.u_id')
                        ->where('zayavka_id', '=', $request->id)->get();
        $catalog_model = new \App\Catalog();
        $companies = $catalog_model->getCompanies();
        $operators = $catalog_model->getOperators();
        
        return view('layouts.bid.bid_edit', array(
            'bid' => $bid,
            'tourists' => $tourists,
            'companies' => $companies,
            'operators' => $operators
        ));
    }

    public function BidChange(Request $request) {
        return false;
    }

}
