<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $result_insert = $this->insertReminders($id);
            $all_request_data = $_requests->get($id);
            foreach ($all_request_data['message']->request as $this_request) {
                if (count($this_request->payments) > 0) {
                    $result_insert = $this->insertPayments($this_request->payments, $id);
                }

                foreach ($this_request->services as $this_service) {
                    if (isset($this_service->flights) && count($this_service->flights) > 0) {
                        //var_dump($this_service->flights);
                        $result_insert = $this->insertFlights($this_service->flights, $id);
                    }
                }
                $result_insert = $this->addServiceforBid($this_request->services, $id, $this_request->client_id, $this_request->dat_updated);
            }
            foreach ($all_request_data['message']->request[0]->tourists as $tourist) {
                $result_insert = $this->insertTourist($tourist, $id);
            }
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

    public function insertService($services_array, $bid_id) {
        $table_name = config('crm_tables.uon_bid_services');
        if (Schema::hasTable($table_name) === FALSE) {
            Schema::create($table_name, function($table) {
                $table->bigIncrements('crm_id');
                $table->integer('r_id')->default(0);
                $table->text('date_begin');
                $table->text('date_end');
                $table->text('description');
                $table->integer('in_package')->default(0);
                $table->integer('service_type_id')->default(0);
                $table->text('duration');
                $table->integer('price_netto')->default(0);
                $table->float('rate_netto', 12, 10)->default(0);
                $table->integer('currency_id_netto')->default(0);
                $table->integer('price')->default(0);
                $table->float('rate', 12, 10)->default(0);
                $table->integer('currency_id')->default(0);
                $table->integer('tourists_count')->default(0);
                $table->integer('tourists_child_count')->default(0);
                $table->integer('tourists_baby_count')->default(0);
                $table->text('service_type');
                $table->integer('partner_id')->default(0);
                $table->text('partner_name');
                $table->text('partner_name_en');
                $table->text('partner_inn');
                $table->integer('country_id')->default(0);
                $table->text('country');
                $table->text('country_en');
                $table->integer('city_id')->default(0);
                $table->text('city');
                $table->text('city_en');
                $table->integer('hotel_id')->default(0);
                $table->text('hotel');
                $table->text('hotel_en');
                $table->integer('hotel_type_id')->default(0);
                $table->text('hotel_type');
                $table->text('hotel_type_en');
                $table->integer('nutrition_id')->default(0);
                $table->text('nutrition');
                $table->text('nutrition_en');
                $table->text('currency_netto');
                $table->text('currency_code_netto');
                $table->text('currency');
                $table->text('currency_code');
            });
        }
        foreach ($services_array as $service) {
            $result_query = DB::table($table_name)->insert(
                    [
                        'r_id' => isset($bid_id) ? $bid_id : 0,
                        'date_begin' => isset($service->date_begin) ? $service->date_begin : '',
                        'date_end' => isset($service->date_end) ? $service->date_end : '',
                        'description' => isset($service->description) ? $service->description : '',
                        'in_package' => isset($service->in_package) ? $service->in_package : 0,
                        'service_type_id' => isset($service->service_type_id) ? $service->service_type_id : 0,
                        'duration' => isset($service->duration) ? $service->duration : 0,
                        'price_netto' => isset($service->price_netto) ? $service->price_netto : 0,
                        'rate_netto' => isset($service->rate_netto) ? $service->rate_netto : 0,
                        'currency_id_netto' => isset($service->currency_id_netto) ? $service->currency_id_netto : 0,
                        'price' => isset($service->price) ? $service->price : 0,
                        'rate' => isset($service->rate) ? $service->rate : 0,
                        'currency_id' => isset($service->currency_id) ? $service->currency_id : 0,
                        'tourists_count' => isset($service->tourists_count) ? $service->tourists_count : 0,
                        'tourists_child_count' => isset($service->tourists_child_count) ? $service->tourists_child_count : 0,
                        'tourists_baby_count' => isset($service->tourists_baby_count) ? $service->tourists_baby_count : 0,
                        'service_type' => isset($service->service_type) ? $service->service_type : '',
                        'partner_id' => isset($service->partner_id) ? $service->partner_id : 0,
                        'partner_name' => isset($service->partner_name) ? $service->partner_name : '',
                        'partner_name_en' => isset($service->partner_name_en) ? $service->partner_name_en : '',
                        'partner_inn' => isset($service->partner_inn) ? $service->partner_inn : '',
                        'country_id' => isset($service->country_id) ? $service->country_id : 0,
                        'country' => isset($service->country) ? $service->country : '',
                        'country_en' => isset($service->country_en) ? $service->country_en : '',
                        'city_id' => isset($service->city_id) ? $service->city_id : 0,
                        'city' => isset($service->city) ? $service->city : '',
                        'city_en' => isset($service->city_en) ? $service->city_en : '',
                        'hotel_id' => isset($service->hotel_id) ? $service->hotel_id : 0,
                        'hotel' => isset($service->hotel) ? $service->hotel : '',
                        'hotel_en' => isset($service->hotel_en) ? $service->hotel_en : '',
                        'hotel_type_id' => isset($service->hotel_type_id) ? $service->hotel_type_id : 0,
                        'hotel_type' => isset($service->hotel_type) ? $service->hotel_type : '',
                        'hotel_type_en' => isset($service->hotel_type_en) ? $service->hotel_type_en : '',
                        'nutrition_id' => isset($service->nutrition_id) ? $service->nutrition_id : 0,
                        'nutrition' => isset($service->nutrition) ? $service->nutrition : '',
                        'nutrition_en' => isset($service->nutrition_en) ? $service->nutrition_en : '',
                        'currency_netto' => isset($service->currency_netto) ? $service->currency_netto : '',
                        'currency_code_netto' => isset($service->currency_code_netto) ? $service->currency_code_netto : '',
                        'currency' => isset($service->currency) ? $service->currency : '',
                        'currency_code' => isset($service->currency_code) ? $service->currency_code : ''
            ]);
        }

        return $result_query;
    }

    public function insertFlights($flights_array, $bid_id) {
        $table_name = config('crm_tables.uon_bid_flights');
        if (Schema::hasTable($table_name) === FALSE) {
            Schema::create($table_name, function($table) {
                $table->bigIncrements('crm_id');
                $table->integer('r_id')->default(0);
                $table->text('date_begin');
                $table->text('time_begin');
                $table->text('date_end');
                $table->text('time_end');
                $table->text('flight_number');
                $table->text('course_begin');
                $table->text('course_end');
                $table->text('terminal_begin');
                $table->text('terminal_end');
                $table->text('code_begin');
                $table->text('code_end');
                $table->text('seats');
                $table->text('tickets');
                $table->text('type');
                $table->text('class');
                $table->text('duration');
                $table->text('supplier_id');
            });
        }
        foreach ($flights_array as $flight) {
            $result_query = DB::table($table_name)->insert(
                    [
                        'r_id' => isset($bid_id) ? $bid_id : 0,
                        'date_begin' => isset($flight->date_begin) ? $flight->date_begin : '',
                        'time_begin' => isset($flight->time_begin) ? $flight->time_begin : '',
                        'date_end' => isset($flight->date_end) ? $flight->date_end : '',
                        'time_end' => isset($flight->time_end) ? $flight->time_end : '',
                        'flight_number' => isset($flight->flight_number) ? $flight->flight_number : '',
                        'course_begin' => isset($flight->course_begin) ? $flight->course_begin : '',
                        'course_end' => isset($flight->course_end) ? $flight->course_end : '',
                        'terminal_begin' => isset($flight->terminal_begin) ? $flight->terminal_begin : '',
                        'terminal_end' => isset($flight->terminal_end) ? $flight->terminal_end : '',
                        'code_end' => isset($flight->code_end) ? $flight->code_end : '',
                        'seats' => isset($flight->date_begin) ? $flight->date_begin : '',
                        'tickets' => isset($flight->tickets) ? $flight->tickets : '',
                        'type' => isset($flight->type) ? $flight->type : '',
                        'class' => isset($flight->class) ? $flight->class : '',
                        'duration' => isset($flight->duration) ? $flight->duration : '',
                        'supplier_id' => isset($flight->supplier_id) ? $flight->supplier_id : ''
            ]);
        }
        return $result_query;
    }

    public function insertPayments($payments_array, $bid_id) {
        $table_name = config('crm_tables.uon_bid_payments');
        if (Schema::hasTable($table_name) === FALSE) {
            Schema::create($table_name, function($table) {
                $table->bigIncrements('crm_id');
                $table->integer('id')->default(0);
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
                $table->float('price', 8, 2)->default(0);
                $table->integer('rate')->default(0);
                $table->integer('currency_id')->default(0);
                $table->text('currency');
                $table->text('currency_code');
                $table->integer('r_id');
            });
        }
        foreach ($payments_array as $payment) {
            $result_query = DB::table($table_name)->insert(
                    [
                        'id' => isset($payment->id) ? $payment->id : 0,
                        'date_create' => isset($payment->date_create) ? $payment->date_create : '',
                        'date_plan' => isset($payment->date_plan) ? $payment->date_plan : '',
                        'reason' => isset($payment->reason) ? $payment->reason : '',
                        'cash_id' => isset($payment->cash_id) ? $payment->cash_id : 0,
                        'number' => isset($payment->number) ? $payment->number : 0,
                        'type_id' => isset($payment->type_id) ? $payment->type_id : 0,
                        'cio_id' => isset($payment->cio_id) ? $payment->cio_id : 0,
                        'in_plan' => isset($payment->in_plan) ? $payment->in_plan : 0,
                        'is_bonus_pay' => isset($payment->is_bonus_pay) ? $payment->is_bonus_pay : 0,
                        'is_deposit' => isset($payment->is_deposit) ? $payment->is_deposit : 0,
                        'from1c' => isset($payment->from1c) ? $payment->from1c : 0,
                        'office_id' => isset($payment->office_id) ? $payment->office_id : 0,
                        'client_id' => isset($payment->client_id) ? $payment->client_id : 0,
                        'price' => isset($payment->price) ? $payment->price : 0,
                        'rate' => isset($payment->rate) ? $payment->rate : 0,
                        'currency_id' => isset($payment->currency_id) ? $payment->currency_id : 0,
                        'currency' => isset($payment->currency) ? $payment->currency : '',
                        'currency_code' => isset($payment->currency_code) ? $payment->currency_code : '',
                        'r_id' => isset($payment->r_id) ? $payment->r_id : ''
            ]);
        }
        return $result_query;
    }

    public function insertReminders($bid_id) {
        $table_name = config('crm_tables.uon_bid_reminders');
        $reminder_class = new \UON\Reminders();
        $reminds = $reminder_class->get($bid_id);
        if (Schema::hasTable($table_name) === FALSE) {
            Schema::create($table_name, function($table) {
                $table->bigIncrements('crm_id');
                $table->integer('id')->default(0);
                $table->integer('r_id')->default(0);
                $table->integer('type_id')->default(0);
                $table->text('text');
                $table->text('datetime');
                $table->integer('created_u_id')->default(0);
                $table->integer('is_done')->default(0);
                $table->text('done_at');
                $table->integer('done_u_id')->default(0);
            });
        }
        foreach ($reminds['message']->reminder as $remind) {
            $result_query = DB::table($table_name)->insert(
                    [
                        'id' => isset($remind->id) ? $remind->id : 0,
                        'r_id' => isset($remind->r_id) ? $remind->r_id : 0,
                        'type_id' => isset($remind->type_id) ? $remind->type_id : 0,
                        'text' => isset($remind->text) ? $remind->text : '',
                        'created_u_id' => isset($remind->created_u_id) ? $remind->created_u_id : 0,
                        'is_done' => isset($remind->is_done) ? $remind->is_done : 0,
                        'done_at' => isset($remind->done_at) ? $remind->done_at : '',
                        'datetime' => isset($remind->datetime) ? $remind->datetime : '',
                        'done_u_id' => isset($remind->done_u_id) ? $remind->done_u_id : 0
            ]);
        }
        return TRUE;
    }

    public function insertTourist($tourist, $bid_id) {
        $table_name = config('crm_tables.crm_bid_tourist');
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function($table) {
                $table->integer('zayavka_id');
                $table->integer('tourist_id')->default(0);
                $table->integer('user_id');
                $table->dateTime('u_date_update')->default(NULL)->nullable();
            });
        }
        $result_query = DB::table($table_name)->insert(
                [
                    'zayavka_id' => $bid_id,
                    'tourist_id' => 0,
                    'user_id' => isset($tourist->u_id) ? $tourist->u_id : 0,
                    'u_date_update' => $tourist->u_date_update
                ]
        );
        return TRUE;
    }

    public function addServiceforBid($services, $bid_id, $user_id, $u_date_update) {
        $table_name = config('crm_tables.crm_bid_service');
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function($table) {
                $table->integer('zayavka_id');
                $table->integer('service_id')->default(0);
                $table->integer('user_id');
                $table->dateTime('u_date_update')->default(NULL)->nullable();
            });
        }
        foreach ($services as $service) {
            $result_query = DB::table($table_name)->insert(
                    [
                        'zayavka_id' => $bid_id,
                        'service_id' => 0,
                        'user_id' => $user_id,
                        'u_date_update' => $u_date_update
                    ]
            );
        }
        return TRUE;
    }

}
