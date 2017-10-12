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
    public function ClientList(Request $request) {
        $table_name = config('crm_tables.uon_users_table');
        if ($request->get('search')) {
            $users = DB::table($table_name)
                    ->where('u_surname', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('u_name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('u_sname', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('u_phone', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('u_phone_mobile', 'like', '%' . $request->get('search') . '%')
                    ->orderBy('u_id', 'desc')
                    ->paginate(100000);
        } else {
            $users = DB::table($table_name)->orderBy('u_id', 'desc')->paginate(50);
        }
        return view('layouts.client.client_list', ['users' => $users]);
    }

    public function ClientEdit(Request $request) {
        $table_name = config('crm_tables.uon_users_table');
        $table_bids = config('crm_tables.uon_bids');
        $table_leads = config('crm_tables.uon_leads');
        $user = DB::table($table_name)->where('u_id', '=', $request->id)->first();
        $bids = DB::table($table_bids)->where('r_client_id', '=', $request->id)->get();
        $leads = DB::table($table_leads)->where('l_client_id', '=', $request->id)->get();
        return view('layouts.client.client_edit', array(
            'user' => $user,
            'bids' => $bids,
            'leads' => $leads
        ));
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

    public function ClientChangeData(Request $data) {
        $client_id = $data->get('u_id');
        $table_name = config('crm_tables.uon_users_table');
        $b_date = date_create($data->birthday);
        $b_date = date_format($b_date, 'Y-m-d');
        $result_query = DB::table($table_name)
                ->where('u_id', $client_id)
                ->update(
                [
                    'u_surname' => isset($data->surname) ? $data->surname : '',
                    'u_name' => isset($data->name) ? $data->name : '',
                    'u_sname' => isset($data->sname) ? $data->sname : '',
                    'u_surname_en' => isset($data->surname_en) ? $data->surname_en : '',
                    'u_name_en' => isset($data->name_en) ? $data->name_en : '',
                    'u_email' => isset($data->email) ? $data->email : '',
                    'u_fax' => isset($data->fax) ? $data->fax : '',
                    'u_phone' => isset($data->phone) ? $data->phone : '',
                    'u_phone_mobile' => isset($data->phone_mobile) ? $data->phone_mobile : '',
                    'u_passport_number' => isset($data->passport_number) ? $data->passport_number : '',
                    'u_birthday' => isset($b_date) ? $b_date : NULL,
                    'u_social_vk' => isset($data->social_vk) ? $data->social_vk : '',
                    'u_social_fb' => isset($data->social_fb) ? $data->social_fb : '',
                    'u_social_ok' => isset($data->social_ok) ? $data->social_ok : '',
                    'address' => isset($data->address) ? $data->address : '',
                    'address_juridical' => isset($data->address_juridical) ? $data->address_juridical : '',
                    'u_date_update' => now()
                ]
        );
        //return FALSE;
        return var_dump($data->all());
    }

}
