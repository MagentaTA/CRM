<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller {

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
    public function CountryList() {
        $table_name = config('crm_tables.uon_countries');
        $countries = DB::table($table_name)->orderBy('uon_id', 'desc')->paginate(50);
        return view('layouts.country.countries_list', ['countries' => $countries]);
    }

}
