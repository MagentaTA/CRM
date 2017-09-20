<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Catalog extends Model {

    public function getCompanies() {
        $table_companies = config('crm_tables.crm_companies');
        $companies = DB::table($table_companies)
                ->pluck('name', 'id');
        return $companies;
    }
    public function getOperators() {
        $table_operators = config('crm_tables.crm_operators');
        $operators = DB::table($table_operators)
                ->pluck('name', 'id');
        return $operators;
    }

}
