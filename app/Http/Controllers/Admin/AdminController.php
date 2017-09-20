<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller {

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
    public function index() {
        return view('layouts.admin.admin_index');
    }

    public function add_role() {

        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        $owner = new Role();
        $owner->name = 'developer';
        $owner->display_name = 'Разработчик CRM'; // optional
        $owner->description = 'Все функции и дополнительные права'; // optional
        $owner->save();

        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Администратор CRM'; // optional
        $admin->description = 'Полные права'; // optional
        $admin->save();

        $user = new Role();
        $user->name = 'user';
        $user->display_name = 'Пользователь CRM'; // optional
        $user->description = 'Права пользователя CRM'; // optional
        $user->update();
        $user->save();
    }

}
