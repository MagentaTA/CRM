<?php

namespace App\Http\Controllers\Api\uon\out;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OutApiUonController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        
    }

    public function AllClients() {
        $date_from = date('Y-m-d', strtotime(now() . '- 30 day'));
        $date_to = date('Y-m-d', strtotime(now()));
        $table_name = config('crm_tables.uon_users_table');
        $_users = new \UON\Users();
        $responce = json_encode($_users->updated($date_from, $date_to));
        //$responce = json_encode($_users->all());
        $responce = \GuzzleHttp\json_decode($responce);
        // Удаляем таблицу и создаём новую с индексами
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('u_id');
            $table->text('u_surname');
            $table->text('u_name');
            $table->text('u_sname');
            $table->text('u_surname_en');
            $table->text('u_name_en');
            $table->text('u_email');
            $table->integer('u_sex')->default(0);
            $table->text('u_fax');
            $table->text('u_phone');
            $table->text('u_phone_mobile');
            $table->text('u_passport_number');
            $table->text('u_passport_taken')->default(NULL)->nullable();
            $table->date('u_passport_date')->default(NULL)->nullable();
            $table->text('u_zagran_number');
            $table->date('u_zagran_given')->default(NULL)->nullable();
            $table->text('u_zagran_expire')->default(NULL)->nullable();
            $table->text('u_zagran_organization');
            $table->date('u_birthday')->default(NULL)->nullable();
            $table->integer('manager_id')->default(0);
            $table->text('u_social_vk');
            $table->text('u_social_fb');
            $table->text('u_social_ok');
            $table->text('u_social_viber');
            $table->text('u_social_watsup');
            $table->text('u_social_telegram');
            $table->text('u_company');
            $table->text('u_inn');
            $table->text('u_kpp');
            $table->text('u_ogrn');
            $table->text('u_okved');
            $table->text('address');
            $table->text('address_juridical');
            $table->text('u_finance_bank');
            $table->text('u_finance_rs');
            $table->text('u_finance_ks');
            $table->text('u_finance_bik');
            $table->text('u_finance_okpo');
            $table->text('u_note');
            $table->dateTime('u_date_update')->default(NULL)->nullable();
        });
        foreach ($responce->message->users as $user) {
            DB::table($table_name)->insert(
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
                        'u_note' => isset($user->u_note) ? $user->u_note : '',
                        'u_date_update' => $user->u_date_update
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function AllRequests() {
        $date_from = date('Y-m-d', strtotime(now() . '- 5 day'));
        $date_to = date('Y-m-d', strtotime(now()));
        $table_name = config('crm_tables.uon_bids');
        $services_table = config('crm_tables.uon_bid_services');
        $table_flights = config('crm_tables.uon_bid_flights');
        $_requests = new \UON\Requests();
        $responce = \GuzzleHttp\json_encode($_requests->getDate($date_from, $date_to));
        $responce = \GuzzleHttp\json_decode($responce);
        Schema::dropIfExists($services_table);
        Schema::dropIfExists($table_name);
        Schema::dropIfExists($table_flights);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('r_id');
            $table->integer('r_id_system')->default(0);
            $table->text('r_id_internal');
            $table->text('r_reservation_number');
            $table->integer('r_supplier_id')->default(0);
            $table->text('r_supplier_name');
            $table->text('r_supplier_inn');
            $table->dateTime('r_dat')->default(NULL)->nullable();
            $table->dateTime('r_dat_lead')->default(NULL)->nullable();
            $table->integer('r_manager_id')->default(0);
            $table->text('r_manager_surname');
            $table->text('r_manager_sname');
            $table->text('r_manager_name');
            $table->integer('r_client_id')->default(0);
            $table->text('r_client_surname');
            $table->text('r_client_name');
            $table->text('r_client_sname');
            $table->text('r_client_phone');
            $table->text('r_client_phone_mobile');
            $table->text('r_client_email');
            $table->text('r_client_company');
            $table->text('r_client_inn');
            $table->dateTime('r_date_begin')->default(NULL)->nullable();
            $table->dateTime('r_date_end')->default(NULL)->nullable();
            $table->integer('r_source_id')->default(0);
            $table->integer('r_status_id')->default(0);
            $table->text('r_status');
            $table->integer('r_calc_price_netto')->default(0);
            $table->integer('r_calc_price')->default(0);
            $table->integer('r_calc_partner_currency_id')->default(0);
            $table->integer('r_calc_client_currency_id')->default(0);
            $table->integer('r_calc_increase')->default(0);
            $table->integer('r_calc_decrease')->default(0);
            $table->integer('r_calc_client')->default(0);
            $table->integer('r_calc_partner')->default(0);
            $table->dateTime('r_dat_updated')->default(NULL)->nullable();
            $table->dateTime('r_created_at')->default(NULL)->nullable();
            $table->integer('r_created_by_manager')->default(0);
            $table->text('r_notes');
            $table->integer('r_bonus_limit')->default(0);
            $table->text('r_company_name');
            $table->text('r_company_fullname');
            $table->text('r_company_name_rus');
            $table->text('r_company_inn');
            $table->integer('r_travel_type_id')->default(0);
            $table->text('r_travel_type');
        });
        $request_data = new \UON\Requests();
        foreach ($responce->message->requests as $request) {
            if (count($request->services) > 0) {
                $insert_services = new \App\Lost();
                $result_insert = $insert_services->insertService($request->services, $request->id);
            }
            
            $all_request_data = $request_data->get($request->id);
            foreach ($all_request_data['message']->request as $this_request) {
                foreach ($this_request->services as $this_service) {
                    if (isset($this_service->flights) && count($this_service->flights) > 0) {
                        //var_dump($this_service->flights);
                        $result_insert = $insert_services->insertFlights($this_service->flights, $request->id);
                    }
                }
            }

            DB::table($table_name)->insert(
                    [
                        'r_id' => $request->id,
                        'r_id_system' => isset($request->id_system) ? $request->id_system : 0,
                        'r_id_internal' => isset($request->id_internal) ? $request->id_internal : '',
                        'r_reservation_number' => isset($request->reservation_number) ? $request->reservation_number : '',
                        'r_supplier_id' => isset($request->supplier_id) ? $request->supplier_id : 0,
                        'r_supplier_name' => isset($request->supplier_name) ? $request->supplier_name : '',
                        'r_supplier_inn' => isset($request->supplier_inn) ? $request->supplier_inn : '',
                        'r_dat' => isset($request->dat) ? $request->dat : NULL,
                        'r_dat_lead' => isset($request->dat_lead) ? $request->dat_lead : NULL,
                        'r_manager_id' => isset($request->manager_id) ? $request->manager_id : 0,
                        'r_manager_surname' => isset($request->manager_surname) ? $request->manager_surname : '',
                        'r_manager_sname' => isset($request->manager_sname) ? $request->manager_sname : '',
                        'r_manager_name' => isset($request->manager_name) ? $request->manager_name : '',
                        'r_client_id' => isset($request->client_id) ? $request->client_id : 0,
                        'r_client_surname' => isset($request->client_surname) ? $request->client_surname : '',
                        'r_client_name' => isset($request->client_name) ? $request->client_name : '',
                        'r_client_sname' => isset($request->client_sname) ? $request->client_sname : '',
                        'r_client_phone' => isset($request->client_phone) ? $request->client_phone : '',
                        'r_client_phone_mobile' => isset($request->client_phone_mobile) ? $request->client_phone_mobile : '',
                        'r_client_email' => isset($request->client_email) ? $request->client_email : '',
                        'r_client_company' => isset($request->client_company) ? $request->client_company : '',
                        'r_client_inn' => isset($request->client_inn) ? $request->client_inn : '',
                        'r_date_begin' => isset($request->date_begin) ? $request->date_begin : NULL,
                        'r_date_end' => isset($request->date_end) ? $request->date_end : NULL,
                        'r_source_id' => isset($request->source_id) ? $request->source_id : 0,
                        'r_status_id' => isset($request->status_id) ? $request->status_id : 0,
                        'r_status' => isset($request->status) ? $request->status : '',
                        'r_calc_price_netto' => isset($request->calc_price_netto) ? $request->calc_price_netto : 0,
                        'r_calc_price' => isset($request->calc_price) ? $request->calc_price : 0,
                        'r_calc_partner_currency_id' => isset($request->r_calc_partner_currency_id) ? $request->r_calc_partner_currency_id : 0,
                        'r_calc_client_currency_id' => isset($request->r_calc_client_currency_id) ? $request->r_calc_client_currency_id : 0,
                        'r_calc_increase' => isset($request->calc_increase) ? $request->calc_increase : 0,
                        'r_calc_decrease' => isset($request->calc_decrease) ? $request->calc_decrease : 0,
                        'r_calc_client' => isset($request->calc_client) ? $request->calc_client : 0,
                        'r_calc_partner' => isset($request->calc_partner) ? $request->calc_partner : 0,
                        'r_dat_updated' => isset($request->dat_updated) ? $request->dat_updated : NULL,
                        'r_created_at' => isset($request->created_at) ? $request->created_at : NULL,
                        'r_created_by_manager' => isset($request->created_by_manager) ? $request->created_by_manager : 0,
                        'r_notes' => isset($request->notes) ? $request->notes : '',
                        'r_bonus_limit' => isset($request->bonus_limit) ? $request->bonus_limit : 0,
                        'r_company_name' => isset($request->company_name) ? $request->company_name : '',
                        'r_company_fullname' => isset($request->company_fullname) ? $request->company_fullname : '',
                        'r_company_name_rus' => isset($request->company_name_rus) ? $request->company_name_rus : '',
                        'r_company_inn' => isset($request->company_inn) ? $request->company_inn : '',
                        'r_travel_type_id' => isset($request->travel_type_id) ? $request->travel_type_id : 0,
                        'r_travel_type' => isset($request->travel_type) ? $request->travel_type : ''
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function AllLeadsRequests() {
        $date_from = date('Y-m-d', strtotime(now() . '- 30 day'));
        $date_to = date('Y-m-d', strtotime(now()));
        $table_name = config('crm_tables.uon_leads');
        $_requests = new \UON\Leads();
        $responce = \GuzzleHttp\json_encode($_requests->date($date_from, $date_to));
        $responce = \GuzzleHttp\json_decode($responce);
        var_dump($responce);
        /* Schema::dropIfExists($table_name);
          Schema::create($table_name, function($table) {
          $table->bigIncrements('l_id');
          $table->integer('l_id_system')->default(0);
          $table->text('l_id_internal');
          $table->text('l_reservation_number');
          $table->integer('l_supplier_id')->default(0);
          $table->text('l_dat');
          $table->text('l_dat_lead');
          $table->integer('l_manager_id')->default(0);
          $table->text('l_manager_surname');
          $table->text('l_manager_sname');
          $table->text('l_manager_name');
          $table->integer('l_client_id')->default(0);
          $table->text('l_client_surname');
          $table->text('l_client_name');
          $table->text('l_client_sname');
          $table->text('l_client_phone');
          $table->text('l_client_phone_mobile');
          $table->text('l_client_email');
          $table->text('l_client_company');
          $table->text('l_client_inn');
          $table->text('l_date_begin');
          $table->text('l_date_end');
          $table->integer('l_source_id')->default(0);
          $table->text('l_source');
          $table->integer('l_travel_type_id')->default(0);
          $table->text('l_travel_type');
          $table->text('l_status_id');
          $table->text('l_status');
          $table->integer('l_calc_price_netto')->default(0);
          $table->integer('l_calc_price')->default(0);
          $table->integer('l_calc_partner_currency_id')->default(0);
          $table->integer('l_calc_client_currency_id')->default(0);
          $table->integer('l_calc_increase')->default(0);
          $table->integer('l_calc_decrease')->default(0);
          $table->integer('l_calc_client')->default(0);
          $table->integer('l_calc_partner')->default(0);
          $table->dateTime('l_dat_updated')->default(NULL)->nullable();
          $table->dateTime('l_created_at')->default(NULL)->nullable();
          $table->integer('l_created_by_manager')->default(0);
          $table->text('l_notes');
          $table->integer('l_bonus_limit')->default(0);
          $table->text('l_company_name');
          $table->text('l_company_fullname');
          $table->text('l_company_name_rus');
          $table->text('l_company_inn');
          });

          foreach ($responce->message->leads as $request) {
          DB::table($table_name)->insert(
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
          'l_date_begin' => isset($request->date_begin) ? $request->date_begin : '',
          'l_date_end' => isset($request->date_end) ? $request->date_end : '',
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
          }
          return redirect()->route('admin'); */
    }

    public function GetCountries() {
        $_requests = new \UON\Countries();
        $response = json_encode($_requests->all());
        $response = \GuzzleHttp\json_decode($response);
        //var_dump($response);
        $table_name = config('crm_tables.uon_countries');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('uon_id');
            $table->text('uon_name');
            $table->text('uon_name_en');
        });

        foreach ($response->message->records as $country_array) {
            //echo $country_array->id;
            DB::table($table_name)->insert(
                    [
                        'uon_id' => $country_array->id,
                        'uon_name' => $country_array->name,
                        'uon_name_en' => $country_array->name_en,
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function GetHotels() {
        $_requests = new \UON\Hotels();
        $table_name = config('crm_tables.uon_hotels');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('uon_id');
            $table->string('uon_name', 255);
            $table->string('uon_name_en', 255);
            $table->string('uon_stars', 10);
            $table->integer('uon_country_id');
            $table->string('uon_country', 50);
            $table->integer('uon_city_id');
            $table->string('uon_city', 50);
            $table->integer('uon_bedroom_count');
            $table->integer('uon_guests_count');
            $table->integer('uon_price');
            $table->text('uon_text');
            $table->string('uon_reserve_rules', 255);
            $table->string('uon_exit_hour', 255);
            $table->string('uon_contacts', 255);
            $table->string('uon_notice', 255);
        });

        for ($page = 1; $page <= 100000; $page++) {
            $response = json_encode($_requests->all($page));
            if (is_object($response)) {
                $response = \GuzzleHttp\json_decode($response);
                //var_dump($response);
                foreach ($response->message->records as $hotels_array) {
                    DB::table($table_name)->insert(
                            [
                                'uon_id' => $hotels_array->id,
                                'uon_name' => isset($hotels_array->name) ? $hotels_array->name : '',
                                'uon_name_en' => isset($hotels_array->name_en) ? $hotels_array->name_en : '',
                                'uon_stars' => isset($hotels_array->stars) ? $hotels_array->stars : '',
                                'uon_country_id' => isset($hotels_array->country_id) ? $hotels_array->country_id : 0,
                                'uon_country' => isset($hotels_array->country) ? $hotels_array->country : 0,
                                'uon_city_id' => isset($hotels_array->city_id) ? $hotels_array->city_id : 0,
                                'uon_city' => isset($hotels_array->city) ? $hotels_array->city : '',
                                'uon_bedroom_count' => isset($hotels_array->bedroom_count) ? $hotels_array->bedroom_count : 0,
                                'uon_guests_count' => isset($hotels_array->guests_count) ? $hotels_array->guests_count : 0,
                                'uon_price' => isset($hotels_array->price) ? $hotels_array->price : 0,
                                'uon_text' => isset($hotels_array->text) ? $hotels_array->text : '',
                                'uon_reserve_rules' => isset($hotels_array->reserve_rules) ? $hotels_array->reserve_rules : '',
                                'uon_exit_hour' => isset($hotels_array->exit_hour) ? $hotels_array->exit_hour : '',
                                'uon_contacts' => isset($hotels_array->contacts) ? $hotels_array->contacts : '',
                                'uon_notice' => isset($hotels_array->notice) ? $hotels_array->notice : ''
                            ]
                    );
                }
            } else {
                break;
            }
        }
        return redirect()->route('admin');
    }

    public function GetCitys() {
        $table_citys = config('crm_tables.uon_citys');
        $table_country = config('crm_tables.uon_countries');
        Schema::dropIfExists($table_citys);
        Schema::create($table_citys, function($table) {
            $table->bigIncrements('uon_id');
            $table->string('uon_name', 255);
            $table->string('uon_name_en', 255);
        });

        $_requests = new \UON\Cities();
        $countrys = DB::table($table_country)->get();
        foreach ($countrys as $country) {
            //echo $country->uon_id.'<br />';
            $response = json_encode($_requests->all($country->uon_id));
            $response = \GuzzleHttp\json_decode($response);
            if (is_object($response)) {
                //var_dump($response->message->records);
                foreach ($response->message->records as $citys_array) {
                    DB::table($table_citys)->insert(
                            [
                                'uon_id' => $citys_array->id,
                                'uon_name' => isset($citys_array->name) ? $citys_array->name : '',
                                'uon_name_en' => isset($citys_array->name_en) ? $citys_array->name_en : ''
                            ]
                    );
                }
            }
        }
    }

    public function GetSourses() {
        $_requests = new \UON\Sources();
        $response = \GuzzleHttp\json_encode($_requests->all());
        $response = \GuzzleHttp\json_decode($response);
        //var_dump($response);
        $table_name = config('crm_tables.uon_sourses');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('uon_id');
            $table->text('uon_name');
        });

        foreach ($response->message->items as $item_array) {
            DB::table($table_name)->insert(
                    [
                        'uon_id' => $item_array->rs_id,
                        'uon_name' => $item_array->rs_name,
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function GetCompanies() {
        $table_name = config('crm_tables.crm_companies');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('name_en');
        });
        DB::table($table_name)->insert([
            [
                'id' => 1,
                'name' => 'ТОВ &quot;МАКіНТУР&quot;',
                'name_en' => '',
            ],
            [
                'id' => 2,
                'name' => 'ФОП Кухар М.А.',
                'name_en' => '',
            ],
            [
                'id' => 3,
                'name' => 'ФОП Кухар Н.М.',
                'name_en' => '',
            ]
        ]);
        return redirect()->route('admin');
    }

    public function GetManagers() {
        $_requests = new \UON\Misc();
        $response = \GuzzleHttp\json_encode($_requests->getManagers());
        $response = \GuzzleHttp\json_decode($response);
        //var_dump($response);
        $table_name = config('crm_tables.uon_managers');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('u_id');
            $table->text('u_surname');
            $table->text('u_name');
            $table->text('u_sname');
            $table->text('u_surname_en');
            $table->text('u_name_en');
            $table->text('u_email');
            $table->integer('u_sex');
            $table->text('u_fax');
            $table->text('u_phone');
            $table->text('u_phone_mobile');
            $table->text('u_passport_number');
            $table->text('u_passport_taken');
            $table->text('u_passport_date');
            $table->text('u_zagran_number');
            $table->text('u_zagran_expire');
            $table->text('u_birthday');
            $table->integer('manager_id');
            $table->text('u_social_vk');
            $table->text('u_social_fb');
            $table->text('u_social_ok');
            $table->text('u_company');
            $table->text('u_inn');
            $table->text('u_kpp');
            $table->text('u_ogrn');
            $table->text('u_okved');
            $table->text('address');
            $table->text('address_juridical');
            $table->text('u_finance_bank');
            $table->text('u_finance_rs');
            $table->text('u_finance_ks');
            $table->text('u_finance_bik');
            $table->text('u_finance_okpo');
            $table->text('u_date_update');
        });

        foreach ($response->message->users as $item_array) {
            DB::table($table_name)->insert(
                    [
                        'u_id' => $item_array->u_id,
                        'u_surname' => isset($item_array->u_surname) ? $item_array->u_surname : '',
                        'u_name' => isset($item_array->u_name) ? $item_array->u_name : '',
                        'u_sname' => isset($item_array->u_sname) ? $item_array->u_sname : '',
                        'u_surname_en' => isset($item_array->u_surname_en) ? $item_array->u_surname_en : '',
                        'u_name_en' => isset($item_array->u_name_en) ? $item_array->u_name_en : '',
                        'u_email' => isset($item_array->u_email) ? $item_array->u_email : '',
                        'u_sex' => isset($item_array->u_sex) ? $item_array->u_sex : 0,
                        'u_fax' => isset($item_array->u_fax) ? $item_array->u_fax : '',
                        'u_phone' => isset($item_array->u_phone) ? $item_array->u_phone : '',
                        'u_phone_mobile' => isset($item_array->u_phone_mobile) ? $item_array->u_phone_mobile : '',
                        'u_passport_number' => isset($item_array->u_passport_number) ? $item_array->u_passport_number : '',
                        'u_passport_taken' => isset($item_array->u_passport_taken) ? $item_array->u_passport_taken : '',
                        'u_passport_date' => isset($item_array->u_passport_date) ? $item_array->u_passport_date : '',
                        'u_zagran_number' => isset($item_array->u_zagran_number) ? $item_array->u_zagran_number : '',
                        'u_zagran_expire' => isset($item_array->u_zagran_expire) ? $item_array->u_zagran_expire : '',
                        'u_birthday' => isset($item_array->u_birthday) ? $item_array->u_birthday : '',
                        'manager_id' => isset($item_array->manager_id) ? $item_array->manager_id : 0,
                        'u_social_vk' => isset($item_array->u_social_vk) ? $item_array->u_social_vk : '',
                        'u_social_fb' => isset($item_array->u_social_fb) ? $item_array->u_social_fb : '',
                        'u_social_ok' => isset($item_array->u_social_ok) ? $item_array->u_social_ok : '',
                        'u_company' => isset($item_array->u_company) ? $item_array->u_company : '',
                        'u_inn' => isset($item_array->u_inn) ? $item_array->u_inn : '',
                        'u_kpp' => isset($item_array->u_kpp) ? $item_array->u_kpp : '',
                        'u_ogrn' => isset($item_array->u_ogrn) ? $item_array->u_ogrn : '',
                        'u_okved' => isset($item_array->u_okved) ? $item_array->u_okved : '',
                        'address' => isset($item_array->address) ? $item_array->address : '',
                        'address_juridical' => isset($item_array->address_juridical) ? $item_array->address_juridical : '',
                        'u_finance_bank' => isset($item_array->u_finance_bank) ? $item_array->u_finance_bank : '',
                        'u_finance_rs' => isset($item_array->u_finance_rs) ? $item_array->u_finance_rs : '',
                        'u_finance_bik' => isset($item_array->u_finance_bik) ? $item_array->u_finance_bik : '',
                        'u_finance_okpo' => isset($item_array->u_finance_okpo) ? $item_array->u_finance_okpo : '',
                        'u_date_update' => isset($item_array->u_date_update) ? $item_array->u_date_update : '',
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function GetOperators() {
        $_requests = new \UON\Suppliers();
        $response = \GuzzleHttp\json_encode($_requests->all());
        $response = \GuzzleHttp\json_decode($response);
        var_dump($response);
        $table_name = config('crm_tables.crm_operators');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->integer('type_id')->default(0);
            $table->text('type');
            $table->text('address');
            $table->text('phones');
            $table->text('email');
            $table->text('contacts');
            $table->text('note');
        });

        foreach ($response->message->records as $item_array) {
            if ($item_array->type == 'Туроператоры') {
                DB::table($table_name)->insert(
                        [
                            'id' => $item_array->id,
                            'name' => isset($item_array->name) ? $item_array->name : '',
                            'type_id' => isset($item_array->type_id) ? $item_array->type_id : 0,
                            'type' => isset($item_array->type) ? $item_array->type : '',
                            'address' => isset($item_array->address) ? $item_array->address : '',
                            'phones' => isset($item_array->phones) ? $item_array->phones : '',
                            'email' => isset($item_array->email) ? $item_array->email : '',
                            'contacts' => isset($item_array->contacts) ? $item_array->contacts : '',
                            'note' => isset($item_array->note) ? $item_array->note : '',
                        ]
                );
            }
        }
        return redirect()->route('admin');
    }

    public function GetServices() {
        $_requests = new \UON\Services();
        $responce = \GuzzleHttp\json_encode($_requests->getTypes());
        $responce = \GuzzleHttp\json_decode($responce);
        //var_dump($responce);
        $table_name = config('crm_tables.crm_services');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('id');
            $table->text('name');
        });

        foreach ($responce->message->items as $item_array) {
            DB::table($table_name)->insert(
                    [
                        'id' => $item_array->id,
                        'name' => isset($item_array->name) ? $item_array->name : '',
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function GetCash() {
        $_requests = new \UON\Misc();
        $responce = \GuzzleHttp\json_encode($_requests->getCash());
        $responce = \GuzzleHttp\json_decode($responce);
        var_dump($responce);
        $table_name = config('crm_tables.uon_cash');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('id');
            $table->text('name');
        });

        foreach ($responce->message->records as $item_array) {
            DB::table($table_name)->insert(
                    [
                        'id' => $item_array->id,
                        'name' => isset($item_array->name) ? $item_array->name : '',
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function GetStatuses() {
        $_requests = new \UON\Statuses();
        $responce = \GuzzleHttp\json_encode($_requests->get());
        $responce = \GuzzleHttp\json_decode($responce);
        //var_dump($responce);
        $table_name = config('crm_tables.uon_statuses');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('stat_id');
            $table->text('stat_name');
        });

        foreach ($responce->message->records as $item_array) {
            DB::table($table_name)->insert(
                    [
                        'stat_id' => $item_array->id,
                        'stat_name' => isset($item_array->name) ? $item_array->name : '',
                    ]
            );
        }
        return redirect()->route('admin');
    }

    public function TourTypes() {
        $table_name = config('crm_tables.crm_tour_types');
        Schema::dropIfExists($table_name);
        Schema::create($table_name, function($table) {
            $table->bigIncrements('id');
            $table->text('name');
        });
        DB::table($table_name)->insert([
            [
                'id' => 1,
                'name' => 'Пакетний тур',
            ],
            [
                'id' => 2,
                'name' => 'Авіаквиток',
            ],
            [
                'id' => 3,
                'name' => 'Віза',
            ],
            [
                'id' => 4,
                'name' => 'Страхування',
            ],
            [
                'id' => 5,
                'name' => 'Автобусний тур',
            ],
            [
                'id' => 6,
                'name' => 'Круїз',
            ],
            [
                'id' => 7,
                'name' => 'Готель',
            ],
            [
                'id' => 8,
                'name' => 'Екскурсійний тур',
            ],
            [
                'id' => 9,
                'name' => 'Паспорт',
            ],
            [
                'id' => 10,
                'name' => 'Тревел Сім',
            ],
            [
                'id' => 11,
                'name' => 'Паспорт',
            ],
            [
                'id' => 12,
                'name' => 'Автобусні квитки',
            ]
        ]);
        return redirect()->route('admin');
    }

}
