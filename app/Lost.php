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

}
