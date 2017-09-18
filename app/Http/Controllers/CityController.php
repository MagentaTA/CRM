<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class CityController extends Controller {

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
    public function CityList() {
        $table_name = config('crm_tables.uon_citys');
        $citys = DB::table($table_name)->orderBy('uon_id', 'desc')->paginate(50);
        return view('layouts.city.citys_list', ['citys' => $citys]);
    }

}
