<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class CCController extends Controller {

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
    public function Index() {
        $Birthdays_table = config('crm_tables.uon_users_table');
        $Birthdays = DB::table($Birthdays_table)
                ->whereMonth('u_birthday', '=', date('m'))
                ->whereDay('u_birthday', '=', date('d'))
                ->get();


        return view('layouts.cc.index', array(
            'Birthdays' => $Birthdays
        ));
    }

    public function Birthday_call(Request $data) {
        $helper = new \App\Helper();
        $catalog_model = new \App\Catalog();
        $questions = $helper->get_Q_by_O($data->opros_id);
        $user_data = $helper->getUserData($data->user_id);
        $managers = $catalog_model->getManagers();
        $pool_id = $data->opros_id;
        
        return view('layouts.cc.birthday_call', array(
            'questions' => $questions,
            'user_data' => $user_data,
            'managers' => $managers,
            'pool_id' => $pool_id
        ));
    }
    public function Birthday_pool_data(){
        //var_dump($data);
        return 'sdfsfsdfsdf';
    }

}
