<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller {

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
    public function ServiceEdit(Request $request) {
        $service_table = config('crm_tables.uon_bid_services');
        $catalog_class = new \App\Catalog();
        $helper_class = new \App\Helper();
        
        
        
        $services_types = $catalog_class->getServicesList();
        $nutritions = $catalog_class->getNutritions();
        $avia = $catalog_class->getAvia();
        $partners = $catalog_class->getPartners();
        
        
        $service_data = DB::table($service_table)
                ->where('crm_id', '=', $request->id)
                ->first();
        $flys = $helper_class->getFlys($service_data->r_id);
        return view('layouts.service.service_edit', array(
            'service_data' => $service_data,
            'services_types' => $services_types,
            'nutritions' => $nutritions,
            'flys' => $flys,
            'avia' => $avia,
            'partners' => $partners
        ));
    }

}
