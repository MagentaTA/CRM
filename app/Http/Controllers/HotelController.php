<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller {

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
    public function HotelList(Request $request) {
        $table_name = config('crm_tables.uon_hotels');
        if ($request->get('search')) {
            $hotels = DB::table($table_name)
                    ->where('uon_name', 'like', '%' . $request->get('search') . '%')
                    ->orderBy('uon_id', 'desc')
                    ->paginate(100000);
            return view('layouts.hotel.hotels_list', ['hotels' => $hotels]);
        } else {
            $hotels = DB::table($table_name)->orderBy('uon_id', 'desc')->paginate(50);
            return view('layouts.hotel.hotels_list', ['hotels' => $hotels]);
        }
    }

}
