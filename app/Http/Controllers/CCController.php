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
        $ppo_table = config('crm_tables.uon_bids');
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
        $ppo = DB::table($ppo_table)
                ->Join($Birthdays_table, $Birthdays_table . '.u_id', '=', $ppo_table . '.r_client_id')
                ->where('r_date_end', '<', date('Y-m-d', strtotime('-10 day')))
                ->where('r_date_end', '>', date('Y-m-d', strtotime('-25 day')))
                ->where('r_status_id', '<>', 3)
                ->where('r_status_id', '<>', 4)
                ->where('r_status_id', '<>', 9)
                ->where('r_status_id', '<>', 7)
                ->where('r_status_id', '<>', 11)
                ->groupBy('r_id')
                ->orderBy('r_date_end', 'asc')
                ->orderBy('u_phone_mobile', 'desc')
                ->orderBy('u_phone', 'desc')
                ->get();
        return view('layouts.cc.index', array(
            'Birthdays' => $Birthdays,
            'PPO' => $ppo
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
    public function Ppo_pool_data(Request $data) {
        $Birthday_table = config('crm_tables.crm_cc_pool_data');
        $answer = $data->get('a_data');
        if (count($data->get('comment')) > 0) {
            $answer = $data->get('comment');
        }
        DB::table($Birthday_table)->insert(
                [
                    'pool_id' => $data->get('pool_id'),
                    'r_id' => $data->get('r_id'),
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
    public function Ppo_call_data_delete(Request $data) {
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
        $date_for_call = null !== $data->get('date_for_call') ? $data->get('date_for_call') : '';
        $row = DB::table($Status_table)
                ->where('id', '=', $data->get('pool_id'))
                ->first();
        if ($row === null) {
            DB::table($Status_table)
                    ->insert(
                            [
                                'id' => $data->get('pool_id'),
                                'status' => $data->get('status'),
                                'date_for_call' => $date_for_call
                            ]
            );
        } else {
            DB::table($Status_table)
                    ->where('id', '=', $data->get('pool_id'))
                    ->update(
                            [
                                'id' => $data->get('pool_id'),
                                'status' => $data->get('status'),
                                'date_for_call' => $date_for_call
                            ]
            );
        }
//return 'Результаты опроса записаны';
        return (var_dump($data->all()));
    }

    public function Add_reminder(Request $data) {
        $chat = new \UON\Chat();
        $helper = new \App\Helper();
//Адрес сервера
        $SmtpServer = "mail.makintour.com";
//Адрес порта
        $SmtpPort = "26";
//Логин авторизации на сервера SMTP
        $SmtpUser = "call-center@makintour.com";
//Пароль авторизации на сервера SMTP
        $SmtpPass = "center2017";
        $client_data = $helper->getUserData($data->client_id);
        $manager_data = $helper->getManagerData($data->manager);
        $manager_email = $manager_data->u_email;
        //return var_dump($client_data);
        $text_remind = '';
        $text_remind .= '<h1>Задача</h1>';
        $text_remind .= '<b>Тип события:</b> ' . $data->do . '<h2></h2>';
        $text_remind .= '<b>Дата события:</b> ' . $data->date_remind . '<h2></h2>';
        $text_remind .= '<b>Комментарий:</b> ' . $data->remind_text . '<h2></h2>';
        $text_remind .= '<h1>Данные о туристе</h1>';
        $text_remind .= '<b>ФИО</b>: <a href="http://my.makintour.com/client_edit.php?client_id=' . $client_data->u_id . '">' . $client_data->u_surname . ' ' . $client_data->u_name . ' ' . $client_data->u_sname . '</a><h2></h2>';
        $text_remind .= '<b>Телефоны: </b>' . $client_data->u_phone . ', ' . $client_data->u_phone_mobile . '<h2></h2>';
        $text_remind .= '<b>E-Mail: </b>' . $client_data->u_email . '<h2></h2>';
        //return $data->all();
        //return $text_remind;
        //return var_dump($manager_data);
        $chat->create(
                [
                    'user_id_from' => $data->from_id,
                    'user_id_to' => $data->manager,
                    'text' => $text_remind
                ]
        );
        $to = $manager_email;
        $from = 'call-center@makintour.com';
        $subject = 'Новая задача от Кол-Центра';
        $body = $text_remind;

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
            $mail->SMTPAuth = true;  // use smpt auth
            $mail->SMTPSecure = "tls"; // or ssl
            $mail->Host = "mail.makintour.com";
            $mail->Port = 26; // most likely something different for you. This is the mailtrap.io port i use for testing. 
            $mail->Username = "call-center@makintour.com";
            $mail->Password = "center2017";
            $mail->setFrom("call-center@makintour.com", "Call Center");
            $mail->Subject = $subject;
            $mail->MsgHTML($body);
            $mail->addAddress($to, $manager_data->u_surname . ' ' . $manager_data->u_name);
            $mail->send();
        } catch (phpmailerException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }
        //die('success');
        return back()->withInput();
    }

    public function Ppo_call(Request $data) {
        $helper = new \App\Helper();
        $catalog_model = new \App\Catalog();
        $table_name = config('crm_tables.uon_bids');
        $table_users = config('crm_tables.uon_users_table');
        $table_sourses = config('crm_tables.uon_sourses');
        $table_tourist = config('crm_tables.crm_bid_tourist');
        $questions = $helper->get_Q_by_O($data->opros_id);
        $user_data = $helper->getUserData($data->user_id);
        $statuses = $catalog_model->getStatuses();
        $companies = $catalog_model->getCompanies();
        $operators = $catalog_model->getOperators();
        $types = $catalog_model->getTourType();
        $sourses = $catalog_model->getSourses();
        $offices = $catalog_model->getOffices();
        $get_rid_arr = explode('_', $data->id);
        $r_id = $get_rid_arr[0];
        $user = $helper->getBidUserData($r_id);
        $services = $helper->getBidServices($r_id);
        $managers = $catalog_model->getManagers();
        $flights = $helper->getBidFlights($r_id);
        $payments = $helper->getBidPayments($r_id);
        $reminders = $helper->getRemindersData($r_id);
        
        $bid = DB::table($table_name)
                ->leftJoin($table_sourses, $table_name . '.r_source_id', '=', $table_sourses . '.uon_id')
                ->where('r_id', '=', $r_id)
                ->first();
        $tourists = DB::table($table_tourist)
                        ->leftJoin($table_users, $table_tourist . '.user_id', '=', $table_users . '.u_id')
                        ->where('zayavka_id', '=', $r_id)->get();
        $pool_id = $data->opros_id;
        $id = $data->id;

        return view('layouts.cc.ppo_call', array(
            'questions' => $questions,
            'user_data' => $user_data,
            'managers' => $managers,
            'pool_id' => $pool_id,
            'id' => $id,
            'bid' => $bid,
            'statuses' => $statuses,
            'companies' => $companies,
            'operators' => $operators,
            'types' => $types,
            'sourses' => $sourses,
            'tourists' => $tourists,
            'user' => $user,
            'services' => $services,
            'flights' => $flights,
            'payments' => $payments,
            'reminders' => $reminders,
            'offices' => $offices
        ));
    }

}
