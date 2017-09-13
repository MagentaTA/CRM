<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lost extends Model {

    public function LostClient($id) {
        $_users = new \UON\Users();
        $client_id = $id;
        $table_name = config('crm_tables.uon_users_table');
        $change_data = \GuzzleHttp\json_encode($_users->get($client_id));
        $change_data = \GuzzleHttp\json_decode($change_data);
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
        if ($result_query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function LostBid($id) {
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
                        'r_company_inn' => isset($zayavka_array->company_inn) ? $zayavka_array->company_inn : ''
                    ]
            );
            if ($result_query) {
                return 'Заявки небыло в нашей базе. Добавили и обновили: ' . $r_id;
            } else {
                return 'Ошибка обновления заявки: ' . $r_id;
            }
        } else {
            return 'Ошибка получения данных по заявке из базы UON';
        }
    }
}
    