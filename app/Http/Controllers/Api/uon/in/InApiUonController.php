<?php

namespace App\Http\Controllers\Api\uon\in;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InApiUonController extends Controller {

    var $ok_color = 'green';
    var $error_color = 'red';

    public function index() {
        
    }

    public function NewClient(Request $request) {
        $client_id = $request->get('client_id');
        $lost = new \App\Lost();
        $result = $lost->LostClient($client_id);
        if ($result !== FALSE) {
            return $result;
        } else {
            return '<font color=' . $this->error_color . '>Ошибка добавления клиента с ID: ' . $client_id . '</font>';
        }
        return FALSE;
    }

    public function NewZayavka(Request $request) {
        $id = $request->get('request_id');
        $lost = new \App\Lost();
        $result = $lost->LostBid($id);
        if ($result !== FALSE) {
            return $result;
        } else {
            return '<font color=' . $this->error_color . '>Ошибка добавления заявки с ID: ' . $client_id . '</font>';
        }
        return FALSE;
    }

    public function NewLead(Request $request) {
        $lead_id = $request->get('request_id');
        $lost = new \App\Lost();
        $result = $lost->LostLead($lead_id);
        if ($result !== FALSE) {
            return $result;
        } else {
            return '<font color=' . $this->error_color . '>Ошибка добавления обращения с ID: ' . $lead_id . '</font>';
        }
        return FALSE;
    }

    public function ChangeClient(Request $request) {
        $_users = new \UON\Users();
        $client_id = $request->get('client_id');
        $table_name = config('crm_tables.uon_users_table');
        $change_data = \GuzzleHttp\json_encode($_users->get($client_id));
        $change_data = \GuzzleHttp\json_decode($change_data);
        if (is_object($change_data)) {
            $user = $change_data->message->user[0];
            $result_query = DB::table($table_name)
                    ->where('u_id', $client_id)
                    ->update(
                    [
                        'u_surname' => isset($user->u_surname) ? $user->u_surname : '',
                        'u_name' => isset($user->u_name) ? $user->u_name : '',
                        'u_sname' => isset($user->u_sname) ? $user->u_sname : '',
                        'u_surname_en' => isset($user->u_surname_en) ? $user->u_surname_en : '',
                        'u_name_en' => isset($user->u_name_en) ? $user->u_name_en : '',
                        'u_email' => isset($user->u_email) ? $user->u_email : '',
                        'u_sex' => isset($user->u_sex) ? $user->u_sex : 0,
                        'u_fax' => isset($user->u_fax) ? $user->u_fax : '',
                        'u_phone' => isset($user->u_phone) ? $user->u_phone : '',
                        'u_phone_mobile' => isset($user->u_phone_mobile) ? $user->u_phone_mobile : '',
                        'u_passport_number' => isset($user->u_passport_number) ? $user->u_passport_number : '',
                        'u_passport_taken' => isset($user->u_passport_taken) ? $user->u_passport_taken : NULL,
                        'u_passport_date' => isset($user->u_passport_date) ? $user->u_passport_date : NULL,
                        'u_zagran_number' => isset($user->u_zagran_number) ? $user->u_zagran_number : '',
                        'u_zagran_given' => isset($user->u_zagran_given) ? $user->u_zagran_given : NULL,
                        'u_zagran_organization' => isset($user->u_zagran_organization) ? $user->u_zagran_organization : '',
                        'u_birthday' => isset($user->u_birthday) ? $user->u_birthday : NULL,
                        'manager_id' => isset($user->manager_id) ? $user->manager_id : 0,
                        'u_social_vk' => isset($user->u_social_vk) ? $user->u_social_vk : '',
                        'u_social_fb' => isset($user->u_social_fb) ? $user->u_social_fb : '',
                        'u_social_ok' => isset($user->u_social_ok) ? $user->u_social_ok : '',
                        'u_company' => isset($user->u_company) ? $user->u_company : '',
                        'u_inn' => isset($user->u_inn) ? $user->u_inn : '',
                        'u_kpp' => isset($user->u_kpp) ? $user->u_kpp : '',
                        'u_ogrn' => isset($user->u_ogrn) ? $user->u_ogrn : '',
                        'u_okved' => isset($user->u_okved) ? $user->u_okved : '',
                        'address' => isset($user->address) ? $user->address : '',
                        'address_juridical' => isset($user->address_juridical) ? $user->address_juridical : '',
                        'u_finance_bank' => isset($user->u_finance_bank) ? $user->u_finance_bank : '',
                        'u_finance_rs' => isset($user->u_finance_rs) ? $user->u_finance_rs : '',
                        'u_finance_ks' => isset($user->u_finance_ks) ? $user->u_finance_ks : '',
                        'u_finance_bik' => isset($user->u_finance_bik) ? $user->u_finance_bik : '',
                        'u_finance_okpo' => isset($user->u_finance_okpo) ? $user->u_finance_okpo : '',
                        'u_date_update' => $user->u_date_update
                    ]
            );
            if ($result_query > 0) {
                return '<font color=' . $this->ok_color . '>Изменён клиент: ' . $client_id . '</font>';
                //return var_dump($result_query);
            } else {
                $lost = new \App\Lost();
                $result = $lost->LostClient($client_id);
                if ($result !== FALSE) {
                    return $result;
                } else {
                    return '<font color=' . $this->error_color . '>Ошибка добавления клиента с ID: ' . $client_id . '</font>';
                }
            }
        } else {
            return '<font color=' . $this->error_color . '>Ошибка получения данных по клиенту из базы UON</font>';
        }
        return FALSE;
    }

    public function DeleteClient(Request $request) {
        $client_id = $request->get('client_id');
        $table_name = config('crm_tables.uon_users_table');
        $result_query = DB::table($table_name)->where('u_id', '=', $client_id)->delete();

        if ($result_query) {
            return '<font color=' . $this->ok_color . '>Удалён клиент: ' . $client_id . '</font>';
        } else {
            return '<font color=' . $this->error_color . '>Ошибка удаления клиента: ' . $client_id . '</font>';
        }
        return FALSE;
    }

    public function StatusZayavka(Request $request) {
        $r_id = $request->get('request_id');
        $r_new_status = $request->get('status_id_new');
        $table_name = config('crm_tables.uon_bids');

        $find_text_data = new \App\Status();
        $get_text = $find_text_data->get_text_name($r_new_status);

        $result_query = DB::table($table_name)
                ->where('r_id', $r_id)
                ->update(
                [
                    'r_status_id' => isset($r_new_status) ? $r_new_status : 0,
                    'r_status' => 'Транзит статус'
                ]
        );
        if ($result_query > 0) {
            $result_query = DB::table($table_name)
                    ->where('r_id', $r_id)
                    ->update(
                    [
                        'r_status_id' => isset($r_new_status) ? $r_new_status : 0,
                        'r_status' => isset($get_text) ? $get_text : ''
                    ]
            );
            return var_dump($result_query) . '<font color=' . $this->ok_color . '>Обновлён статус заявки: ' . $r_id . ' на ' . $get_text . '(' . $r_new_status . ')</font>';
        } else {
            $lost = new \App\Lost();
            $result = $lost->LostBid($r_id);
            if ($result !== FALSE) {
                return $result;
            } else {
                return '<font color=' . $this->error_color . '>Ошибка добавления заявки с ID: ' . $client_id . '</font>';
            }
        }
        return FALSE;
    }

    public function NewTourist(Request $request) {
        $zayavka_id = $request->get('r_id');
        $tourist_id = $request->get('tourist_id');
        $user_id = $request->get('user_id');
        $table_name = config('crm_tables.crm_bid_tourist');
        $u_date_update = $request->get('datetime');
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function($table) {
                $table->integer('zayavka_id');
                $table->integer('tourist_id');
                $table->integer('user_id');
                $table->dateTime('u_date_update')->default(NULL)->nullable();
            });
        }
        $result_query = DB::table($table_name)->insert(
                [
                    'zayavka_id' => $zayavka_id,
                    'tourist_id' => $tourist_id,
                    'user_id' => $user_id,
                    'u_date_update' => $u_date_update
                ]
        );
        if ($result_query) {
            return '<font color=' . $this->ok_color . '>К заявке ' . $zayavka_id . ' прикреплён турист ' . $tourist_id . '</font>';
        } else {
            return '<font color=' . $this->error_color . '>Ошибка добавления туриста ' . $tourist_id . ' к заявке ' . $zayavka_id . '</font>';
        }
        return FALSE;
    }

    public function DeleteTourist(Request $request) {
        $zayavka_id = $request->get('r_id');
        $user_id = $request->get('user_id');
        $table_name = config('crm_tables.crm_bid_tourist');
        $result_query = DB::table($table_name)->where(
                        [
                            ['zayavka_id', '=', (int) $zayavka_id],
                            ['user_id', '=', (int) $user_id]
                        ]
                )->delete();
        if ($result_query) {
            return 'Удалён турист (' . $tourist_id . ') из заявки (' . $zayavka_id . ')';
        } else {
            return 'Ошибка удаления туриста (' . $tourist_id . ') из заявки (' . $zayavka_id . ')';
        }
    }

    public function NewService(Request $request) {
        $zayavka_id = $request->get('request_id');
        $service_id = $request->get('service_id');
        $user_id = $request->get('user_id');
        $u_date_update = $request->get('datetime');
        $table_name = config('crm_tables.crm_bid_service');
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function($table) {
                $table->integer('zayavka_id');
                $table->integer('service_id');
                $table->integer('user_id')->default(NULL)->nullable();
                $table->dateTime('u_date_update')->default(NULL)->nullable();
            });
        }
        $result_query = DB::table($table_name)->insert(
                [
                    'zayavka_id' => $zayavka_id,
                    'service_id' => $service_id,
                    'user_id' => $user_id,
                    'u_date_update' => $u_date_update
                ]
        );
        if ($result_query) {
            return '<font color = ' . $this->ok_color . '>К заявке ' . $zayavka_id . ' прикреплена услуга ' . $service_id . '</font>';
        } else {
            return '<font color = ' . $this->error_color . '>Ошибка добавления услуги ' . $service_id . ' к заявке ' . $zayavka_id . '</font>';
        }
        return FALSE;
    }

    public function ChangeService(Request $request) {
        //$services = new \UON\Services();


        return '0';
    }

    public function NewPayment(Request $request) {
        $table_name = config('crm_tables.uon_payments');
        $payment_id = $request->get('payment_id');
        $_requests = new \UON\Payments();
        $responce = \GuzzleHttp\json_encode($_requests->get($payment_id));
        $responce = \GuzzleHttp\json_decode($responce);
        if (is_object($responce)) {
            if (Schema::hasTable($table_name) === FALSE) {
                Schema::create($table_name, function($table) {
                    $table->bigIncrements('id');
                    $table->text('date_create');
                    $table->text('date_plan');
                    $table->text('reason');
                    $table->integer('cash_id')->default(0);
                    $table->integer('number')->default(0);
                    $table->integer('type_id')->default(0);
                    $table->integer('cio_id')->default(0);
                    $table->integer('in_plan')->default(0);
                    $table->integer('is_bonus_pay')->default(0);
                    $table->integer('is_deposit')->default(0);
                    $table->integer('from1c')->default(0);
                    $table->integer('office_id')->default(0);
                    $table->integer('client_id')->default(0);
                    $table->integer('price')->default(0);
                    $table->integer('rate')->default(0);
                    $table->integer('currency_id')->default(0);
                    $table->text('currency');
                    $table->text('currency_code');
                    $table->integer('r_id')->default(0);
                });
            }
            $payment_data = $responce->message;
            $result_insert = DB::table($table_name)->insert(
                    [
                        'id' => $payment_data->id,
                        'date_create' => isset($payment_data->date_create) ? $payment_data->date_create : '',
                        'date_plan' => isset($payment_data->date_plan) ? $payment_data->date_plan : '',
                        'reason' => isset($payment_data->reason) ? $payment_data->reason : '',
                        'cash_id' => isset($payment_data->cash_id) ? $payment_data->cash_id : 0,
                        'number' => isset($payment_data->number) ? $payment_data->number : 0,
                        'type_id' => isset($payment_data->type_id) ? $payment_data->type_id : 0,
                        'cio_id' => isset($payment_data->cio_id) ? $payment_data->cio_id : 0,
                        'in_plan' => isset($payment_data->in_plan) ? $payment_data->in_plan : 0,
                        'is_bonus_pay' => isset($payment_data->is_bonus_pay) ? $payment_data->is_bonus_pay : 0,
                        'is_deposit' => isset($payment_data->is_deposit) ? $payment_data->is_deposit : 0,
                        'from1c' => isset($payment_data->from1c) ? $payment_data->from1c : 0,
                        'office_id' => isset($payment_data->office_id) ? $payment_data->office_id : 0,
                        'client_id' => isset($payment_data->client_id) ? $payment_data->client_id : 0,
                        'price' => isset($payment_data->price) ? $payment_data->price : 0,
                        'rate' => isset($payment_data->rate) ? $payment_data->rate : 0,
                        'currency_id' => isset($payment_data->currency_id) ? $payment_data->currency_id : 0,
                        'currency' => isset($payment_data->currency) ? $payment_data->currency : '',
                        'currency_code' => isset($payment_data->currency_code) ? $payment_data->currency_code : '',
                        'r_id' => isset($payment_data->r_id) ? $payment_data->r_id : 0
                    ]
            );
        } else {
            return '<font color = ' . $this->error_color . '>Ошибка доступа к базе UON</font>';
        }
        if ($result_insert > 0) {
            return '<font color = ' . $this->ok_color . '>Платёж был успешно добавлен в нашу базу</font>';
        } else {
            return '<font color = ' . $this->error_color . '>Ошибка записи в нашу базу</font>';
        }
    }

    public function PriceChanged(Request $request) {
        $table_name = config('crm_tables.price_change_history');
        $r_table = config('crm_tables.uon_bids');
        DB::table($r_table)
                ->where('r_id', $request->get('r_id'))
                ->update(['r_calc_price_netto' => $request->get('price_new')]);
        if (Schema::hasTable($table_name) === FALSE) {
            Schema::create($table_name, function($table) {
                $table->bigIncrements('id');
                $table->integer('r_id');
                $table->integer('user_id')->default(0);
                $table->integer('type_id')->default(0);
                $table->float('price_old', 8, 2)->default(0.00);
                $table->float('price_new', 8, 2)->default(0.00);
                $table->text('datetime');
            });
        }
        DB::table($table_name)->insert(
                [
                    'r_id' => $request->get('r_id'),
                    'user_id' => $request->get('user_id'),
                    'type_id' => $request->get('type_id'),
                    'price_old' => $request->get('price_old'),
                    'price_new' => $request->get('price_new'),
                    'datetime' => $request->get('datetime')
                ]
        );
        return $request->get('r_id');
    }

}
