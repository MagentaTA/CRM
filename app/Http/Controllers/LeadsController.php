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

    public function LeadEdit(Request $request) {
        $table_name = config('crm_tables.uon_leads');
        $catalog_model = new \App\Catalog();
        $lead = DB::table($table_name)
                ->where('l_id', '=', $request->id)
                ->first();

        $managers = $catalog_model->getManagers();
        $companies = $catalog_model->getCompanies();
        $sourses = $catalog_model->getSourses();
        $tour_types = $catalog_model->getTourType();
        $statuses = $catalog_model->getStatuses();
        return view('layouts.lead.lead_edit', array(
            'lead' => $lead,
            'managers' => $managers,
            'companies' => $companies,
            'sourses' => $sourses,
            'tour_types' => $tour_types,
            'statuses' => $statuses
        ));
    }

}
