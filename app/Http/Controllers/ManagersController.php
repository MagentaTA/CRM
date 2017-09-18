<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class ManagersController extends Controller {

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
    public function ManagersList() {
        $table_name = config('crm_tables.uon_managers');
        $managers = DB::table($table_name)->orderBy('u_id', 'desc')->paginate(20);
        return view('layouts.manager.managers_list', ['managers' => $managers]);
    }

}
