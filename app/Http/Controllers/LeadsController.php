<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class LeadsController extends Controller {

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
    public function LeadsList() {
        $table_name = config('crm_tables.uon_leads');
        $table_users = config('crm_tables.uon_users_table');
        $table_sourses = config('crm_tables.uon_sourses');
        $leads = DB::table($table_name)
                        ->leftJoin($table_users, $table_users . '.u_id', '=', $table_name . '.l_client_id')
                        ->leftJoin($table_sourses, $table_name . '.l_source_id', '=', $table_sourses . '.uon_id')
                        ->orderBy('l_id', 'desc')->paginate(50);
        return view('layouts.lead.leads_list', ['leads' => $leads]);
    }

}
