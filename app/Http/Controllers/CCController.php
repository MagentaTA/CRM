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
        $Pool_table = config('crm_tables.crm_cc_pool_data');
        $Status_table = config('crm_tables.crm_cc_pool_status');
        $Birthdays = DB::table($Birthdays_table)
                ->leftJoin($Pool_table, $Pool_table . '.user_id', '=', $Birthdays_table . '.u_id')
                ->leftJoin($Status_table, $Status_table . '.id', '=', $Pool_table . '.pool_id')
                ->whereMonth('u_birthday', '=', date('m'))
                ->whereDay('u_birthday', '=', date('d'))
                ->groupBy('u_id')
                ->orderBy($Status_table . '.status', 'asc')
                ->orderBy('u_phone_mobile', 'desc')
                ->orderBy('u_phone', 'desc')
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
        $bids = $helper->getBidDataByUser($data->user_id);
        $pool_id = $data->opros_id;
        $id = $data->id;

        return view('layouts.cc.birthday_call', array(
            'questions' => $questions,
            'user_data' => $user_data,
            'managers' => $managers,
            'pool_id' => $pool_id,
            'id' => $id,
            'bids' => $bids
        ));
    }

    public function Birthday_pool_data(Request $data) {
        $Birthday_table = config('crm_tables.crm_cc_pool_data');
        $answer = $data->get('a_data');
        if (count($data->get('comment')) > 0) {
            $answer = $data->get('comment');
        }
        DB::table($Birthday_table)->insert(
                [
                    'pool_id' => $data->get('pool_id'),
                    'user_id' => $data->get('user_id'),
                    'q_id' => $data->get('q_id'),
                    'answer' => $answer,
                    'status' => $data->get('status'),
                    'date_pool' => date(now())
                ]
        );
//return 'Результаты опроса записаны';
        return (var_dump($data->all()));
    }

    public function Birthday_pool_data_delete(Request $data) {
        $Birthday_table = config('crm_tables.crm_cc_pool_data');
        $row = DB::table($Birthday_table)
                ->where('pool_id', '=', $data->get('pool_id'))
                ->first();
        if ($row === null) {
            return (var_dump($data->all()));
        } else {
            DB::table($Birthday_table)
                    ->where('pool_id', '=', $data->get('pool_id'))
                    ->delete();
        }
//return 'Результаты опроса записаны';
        return (var_dump($data->all()));
    }

    public function Birthday_pool_status(Request $data) {
        $Status_table = config('crm_tables.crm_cc_pool_status');
        $row = DB::table($Status_table)
                ->where('id', '=', $data->get('pool_id'))
                ->first();
        if ($row === null) {
            DB::table($Status_table)
                    ->insert(
                            [
                                'id' => $data->get('pool_id'),
                                'status' => $data->get('status'),
                            ]
            );
        } else {
            DB::table($Status_table)
                    ->where('id', '=', $data->get('pool_id'))
                    ->update(
                            [
                                'id' => $data->get('pool_id'),
                                'status' => $data->get('status'),
                            ]
            );
        }
//return 'Результаты опроса записаны';
        return (var_dump($data->all()));
    }

    public function Add_reminder(Request $data) {
        $chat = new \UON\Chat();
        return $chat->create(
                        [
                            'user_id_from' => 2,
                            'user_id_to' => 18519,
                            'text' => $data->remind_text
                        ]
        );
        //return back()->withInput();
    }

}
