<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Catalog extends Model {

    public function getCompanies() {
        $table = config('crm_tables.crm_companies');
        $companies = DB::table($table)
                ->pluck('name', 'id');
        return $companies;
    }

    public function getOperators() {
        $table = config('crm_tables.crm_operators');
        $operators = DB::table($table)
                ->pluck('name', 'id');
        return $operators;
    }

    public function getOffices() {
        $table = config('crm_tables.crm_offices');
        $offices = DB::table($table)
                ->pluck('name', 'uon_id');
        return $offices;
    }

    public function getServicesList() {
        $table = config('crm_tables.crm_services');
        $services = DB::table($table)
                ->pluck('name', 'id');
        return $services;
    }

    public function getTourType() {
        $table = config('crm_tables.crm_tour_types');
        $types = DB::table($table)
                ->pluck('name', 'id');
        return $types;
    }

    public function getManagers() {
        $table = config('crm_tables.uon_managers');
        $managers = DB::table($table)
                ->select(
            DB::raw("CONCAT(u_surname,' ',u_name,' ',u_sname) AS name"),'u_id')
            ->pluck('name', 'u_id');        
        return $managers;
    }

    public function getSourses() {
        $table = config('crm_tables.uon_sourses');
        $sourses = DB::table($table)
                ->pluck('uon_name', 'uon_id');
        return $sourses;
    }

    public function getStatuses() {
        $table = config('crm_tables.uon_statuses');
        $statuses = DB::table($table)
                ->pluck('stat_name', 'stat_id');
        return $statuses;
    }

    public function getNutritions() {
        $table = config('crm_tables.uon_nutritions');
        $nutririon = DB::table($table)
                ->pluck('name', 'uon_id');
        return $nutririon;
    }

    public function getAvia() {
        $table = config('crm_tables.crm_avia');
        $avia = DB::table($table)
                ->pluck('name', 'id');
        return $avia;
    }
    public function getPartners() {
        $table = config('crm_tables.crm_partners');
        $partners = DB::table($table)
                ->select(DB::raw("CONCAT(name,' (',type,')') AS name_1"),'name')
                ->pluck('name_1','name');
        return $partners;
    }

}
