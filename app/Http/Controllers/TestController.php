<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $request_data = new \UON\Requests();
        $user_data = new \UON\Users();
        $responce = $request_data->get(19641);
        //$request = $request_data->getActions(19750);
        //$leads_data = new \UON\Leads();
        //$request = $leads_data->get(19770);
        var_dump($responce['message']->request[0]->dat_updated);
    }

}
