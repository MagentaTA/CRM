<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lost extends Model {

    var $ok_color = 'green';
    var $error_color = 'red';

    public function LostClient($id) {
        $table_name = config('crm_tables.uon_users_table');
        $_users = new \UON\Users();
        $client_id = $id;
        $change_data = \GuzzleHttp\json_encode($_users->get($client_id));
        $change_data = \GuzzleHttp\json_decode($change_data);
        if (is_object($change_data)) {
            $user = $change_data->message->user[0];
            $result_query = DB::table($table_name)->insert(
                    [
                        'u_id' => $user->u_id,
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
                return '<font color=' . $this->ok_color . '>Клиента небыло. Добавлен ID: ' . $id . '</font>';
            } else {
                return '<font color=' . $this->error_color . '>Клиента небыло и нет ID: ' . $id . '</font>';
            }
        } else {
            return '<font color=' . $this->error_color . '>Ошибка обращения к API UON по клиенту ID: ' . $id . '</font>';
        }
        return FALSE;
    }

    public function LostBid($id) {
        $table_name = config('crm_tables.uon_bids');
        $_requests = new \UON\Requests();
        $responce = \GuzzleHttp\json_encode($_requests->get($id));
        $responce = \GuzzleHttp\json_decode($responce);
        if (is_object($responce)) {
            $zayavka_array = $responce->message->request[0];
            $result_query = DB::table($table_name)->insert(
                    [
                        'r_id' => $zayavka_array->id,
                        'r_id_system' => isset($zayavka_array->id_system) ? $zayavka_array->id_system : 0,
                        'r_id_internal' => isset($zayavka_array->id_internal) ? $zayavka_array->id_internal : '',
                        'r_reservation_number' => isset($zayavka_array->reservation_number) ? $zayavka_array->reservation_number : '',
                        'r_supplier_id' => isset($zayavka_array->supplier_id) ? $zayavka_array->supplier_id : 0,
                        'r_supplier_name' => isset($zayavka_array->supplier_name) ? $zayavka_array->supplier_name : '',
                        'r_supplier_inn' => isset($zayavka_array->supplier_inn) ? $zayavka_array->supplier_inn : '',
                        'r_dat' => isset($zayavka_array->dat) ? $zayavka_array->dat : NULL,
                        'r_dat_lead' => isset($zayavka_array->dat_lead) ? $zayavka_array->dat_lead : NULL,
                        'r_manager_id' => isset($zayavka_array->manager_id) ? $zayavka_array->manager_id : 0,
                        'r_manager_surname' => isset($zayavka_array->manager_surname) ? $zayavka_array->manager_surname : '',
                        'r_manager_sname' => isset($zayavka_array->manager_sname) ? $zayavka_array->manager_sname : '',
                        'r_manager_name' => isset($zayavka_array->manager_name) ? $zayavka_array->manager_name : '',
                        'r_client_id' => isset($zayavka_array->client_id) ? $zayavka_array->client_id : 0,
                        'r_client_surname' => isset($zayavka_array->client_surname) ? $zayavka_array->client_surname : '',
                        'r_client_name' => isset($zayavka_array->client_name) ? $zayavka_array->client_name : '',
                        'r_client_sname' => isset($zayavka_array->client_sname) ? $zayavka_array->client_sname : '',
                        'r_client_phone' => isset($zayavka_array->client_phone) ? $zayavka_array->client_phone : '',
                        'r_client_phone_mobile' => isset($zayavka_array->client_phone_mobile) ? $zayavka_array->client_phone_mobile : '',
                        'r_client_email' => isset($zayavka_array->client_email) ? $zayavka_array->client_email : '',
                        'r_client_company' => isset($zayavka_array->client_company) ? $zayavka_array->client_company : '',
                        'r_client_inn' => isset($zayavka_array->client_inn) ? $zayavka_array->client_inn : '',
                        'r_date_begin' => isset($zayavka_array->date_begin) ? $zayavka_array->date_begin : NULL,
                        'r_date_end' => isset($zayavka_array->date_end) ? $zayavka_array->date_end : NULL,
                        'r_source_id' => isset($zayavka_array->source_id) ? $zayavka_array->source_id : 0,
                        'r_status_id' => isset($zayavka_array->status_id) ? $zayavka_array->status_id : 0,
                        'r_status' => isset($zayavka_array->status) ? $zayavka_array->status : '',
                        'r_calc_price_netto' => isset($zayavka_array->calc_price_netto) ? $zayavka_array->calc_price_netto : 0,
                        'r_calc_price' => isset($zayavka_array->calc_price) ? $zayavka_array->calc_price : 0,
                        'r_calc_partner_currency_id' => isset($zayavka_array->r_calc_partner_currency_id) ? $zayavka_array->r_calc_partner_currency_id : 0,
                        'r_calc_client_currency_id' => isset($zayavka_array->r_calc_client_currency_id) ? $zayavka_array->r_calc_client_currency_id : 0,
                        'r_calc_increase' => isset($zayavka_array->calc_increase) ? $zayavka_array->calc_increase : 0,
                        'r_calc_decrease' => isset($zayavka_array->calc_decrease) ? $zayavka_array->calc_decrease : 0,
                        'r_calc_client' => isset($zayavka_array->calc_client) ? $zayavka_array->calc_client : 0,
                        'r_calc_partner' => isset($zayavka_array->calc_partner) ? $zayavka_array->calc_partner : 0,
                        'r_dat_updated' => isset($zayavka_array->dat_updated) ? $zayavka_array->dat_updated : NULL,
                        'r_created_at' => isset($zayavka_array->created_at) ? $zayavka_array->created_at : NULL,
                        'r_created_by_manager' => isset($zayavka_array->created_by_manager) ? $zayavka_array->created_by_manager : 0,
                        'r_notes' => isset($zayavka_array->notes) ? $zayavka_array->notes : '',
                        'r_bonus_limit' => isset($zayavka_array->bonus_limit) ? $zayavka_array->bonus_limit : 0,
                        'r_company_name' => isset($zayavka_array->company_name) ? $zayavka_array->company_name : '',
                        'r_company_fullname' => isset($zayavka_array->company_fullname) ? $zayavka_array->company_fullname : '',
                        'r_company_name_rus' => isset($zayavka_array->company_name_rus) ? $zayavka_array->company_name_rus : '',
                        'r_company_inn' => isset($zayavka_array->company_inn) ? $zayavka_array->company_inn : '',
                        'r_travel_type_id' => isset($request->travel_type_id) ? $request->travel_type_id : 0,
                        'r_travel_type' => isset($request->travel_type) ? $request->travel_type : ''
                    ]
            );
            if ($result_query) {
                return '<font color=' . $this->ok_color . '>Заявки небыло в нашей базе. Добавили и обновили: ' . $id . '</font>';
            } else {
                return '<font color=' . $this->error_color . '>Ошибка добаления заявки: ' . $id . '</font>';
            }
        } else {
            return '<font color=' . $this->error_color . '>Ошибка получения данных по заявке из базы UON</font>';
        }
        return FALSE;
    }

    public function LostLead($id) {
        $table_name = config('crm_tables.uon_leads');
        $_requests = new \UON\Leads();
        $responce = \GuzzleHttp\json_encode($_requests->get($id));
        $responce = \GuzzleHttp\json_decode($responce);
        if (is_object($responce)) {
            foreach ($responce->message->lead as $request) {
                $result_query = DB::table($table_name)->insert(
                        [
                            'l_id' => $request->id,
                            'l_id_system' => isset($request->id_system) ? $request->id_system : 0,
                            'l_id_internal' => isset($request->id_internal) ? $request->id_internal : '',
                            'l_reservation_number' => isset($request->reservation_number) ? $request->reservation_number : '',
                            'l_supplier_id' => isset($request->supplier_id) ? $request->supplier_id : 0,
                            'l_dat' => isset($request->dat) ? $request->dat : '',
                            'l_dat_lead' => isset($request->dat_lead) ? $request->dat_lead : '',
                            'l_manager_id' => isset($request->manager_id) ? $request->manager_id : 0,
                            'l_manager_surname' => isset($request->manager_surname) ? $request->manager_surname : '',
                            'l_manager_sname' => isset($request->manager_sname) ? $request->manager_sname : '',
                            'l_manager_name' => isset($request->manager_name) ? $request->manager_name : '',
                            'l_client_id' => isset($request->client_id) ? $request->client_id : 0,
                            'l_client_surname' => isset($request->client_surname) ? $request->client_surname : '',
                            'l_client_name' => isset($request->client_name) ? $request->client_name : '',
                            'l_client_sname' => isset($request->client_sname) ? $request->client_sname : '',
                            'l_client_phone' => isset($request->client_phone) ? $request->client_phone : '',
                            'l_client_phone_mobile' => isset($request->client_phone_mobile) ? $request->client_phone_mobile : '',
                            'l_client_email' => isset($request->client_email) ? $request->client_email : '',
                            'l_client_company' => isset($request->client_company) ? $request->client_company : '',
                            'l_client_inn' => isset($request->client_inn) ? $request->client_inn : '',
                            'l_date_begin' => isset($request->date_begin) ? $request->date_begin : NULL,
                            'l_date_end' => isset($request->date_end) ? $request->date_end : NULL,
                            'l_source_id' => isset($request->source_id) ? $request->source_id : 0,
                            'l_source' => isset($request->source) ? $request->source : '',
                            'l_travel_type_id' => isset($request->travel_type_id) ? $request->travel_type_id : 0,
                            'l_travel_type' => isset($request->travel_type) ? $request->travel_type : '',
                            'l_status_id' => isset($request->status_id) ? $request->status_id : '',
                            'l_status' => isset($request->status) ? $request->status : '',
                            'l_calc_price_netto' => isset($request->r_calc_price_netto) ? $request->r_calc_price_netto : 0,
                            'l_calc_price' => isset($request->r_calc_price) ? $request->r_calc_price : 0,
                            'l_calc_partner_currency_id' => isset($request->r_calc_partner_currency_id) ? $request->r_calc_partner_currency_id : 0,
                            'l_calc_client_currency_id' => isset($request->r_calc_client_currency_id) ? $request->r_calc_client_currency_id : 0,
                            'l_calc_increase' => isset($request->r_calc_increase) ? $request->r_calc_increase : 0,
                            'l_calc_decrease' => isset($request->r_calc_decrease) ? $request->r_calc_decrease : 0,
                            'l_calc_client' => isset($request->r_calc_client) ? $request->r_calc_client : 0,
                            'l_calc_partner' => isset($request->r_calc_partner) ? $request->r_calc_partner : 0,
                            'l_dat_updated' => isset($request->dat_updated) ? $request->dat_updated : NULL,
                            'l_created_at' => isset($request->created_at) ? $request->created_at : NULL,
                            'l_created_by_manager' => isset($request->created_by_manager) ? $request->created_by_manager : 0,
                            'l_notes' => isset($request->notes) ? $request->notes : '',
                            'l_bonus_limit' => isset($request->bonus_limit) ? $request->bonus_limit : 0,
                            'l_company_name' => isset($request->company_name) ? $request->company_name : '',
                            'l_company_fullname' => isset($request->company_fullname) ? $request->company_fullname : '',
                            'l_company_name_rus' => isset($request->company_name_rus) ? $request->company_name_rus : '',
                            'l_company_inn' => isset($request->company_inn) ? $request->company_inn : ''
                        ]
                );
                if ($result_query) {
                    return '<font color=' . $this->ok_color . '>Обращения небыло в нашей базе. Добавили и обновили: ' . $id . '</font>';
                } else {
                    return '<font color=' . $this->error_color . '>Ошибка добавления обращения: ' . $id . '</font>';
                }
            }
        } else {
            return '<font color=' . $this->error_color . '>Ошибка получения данных по обращению из базы UON</font>';
        }
        return var_dump($responce);
    }

}
