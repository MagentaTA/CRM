<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller {

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
    public function ClientList() {
        $table_name = config('crm_tables.uon_users_table');
        $users = DB::table($table_name)->orderBy('u_id', 'desc')->paginate(50);
        return view('layouts.client.client_list', ['users' => $users]);
    }

    public function ClientEdit(Request $request) {
        $table_name = config('crm_tables.uon_users_table');
        $table_bids = config('crm_tables.uon_bids');
        $user = DB::table($table_name)->where('u_id', $request->id)->first();
        $bids = DB::table($table_bids)->where('r_client_id', $request->id)->get();
        return view('layouts.client.client_edit', 
            ['user' => $user],
            ['bids' => $bids]
        );
    }

    public function ClientAdd() {
        return view('layouts.client.client', ['view' => 'client_add']);
    }

    public function ClientCreate(Request $user_data) {
        $v = Validator::make($user_data->all(), [
                    'name' => 'required|max:255',
                    'phone_mobile' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            return redirect(route('client_add'));
        }
    }

}
