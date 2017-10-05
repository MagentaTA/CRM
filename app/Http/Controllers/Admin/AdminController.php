<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\User;

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

        $admin_user = User::where('email', '=', 'vader85@inbox.ru')->first();
        $admin_user->detachRole('developer');
        $admin_user->attachRole('developer');

        return view('layouts.admin.admin_index');
    }

    public function add_cc_birthdays_q() {
        $questions_table = config('crm_tables.crm_cc_questions');
        $answers_table = config('crm_tables.crm_cc_answers');
        $pool_data_table = config('crm_tables.crm_cc_pool_data');
        $status_pool_table = config('crm_tables.crm_cc_pool_status');
        Schema::dropIfExists($pool_data_table);
        Schema::create($pool_data_table, function($table) {
            $table->bigIncrements('p_auto_id');
            $table->text('pool_id');
            $table->integer('user_id')->default(0);
            $table->integer('q_id')->default(0);
            $table->text('answer')->nullable();
            $table->text('status')->nullable();
            $table->dateTime('date_pool');
        });
        Schema::dropIfExists($questions_table);
        Schema::create($questions_table, function($table) {
            $table->integer('q_id');
            $table->text('question_text');
            $table->integer('opros_id');
        });
        Schema::dropIfExists($answers_table);
        Schema::create($answers_table, function($table) {
            $table->integer('a_id');
            $table->text('answer_text');
            $table->integer('q_id');
            $table->integer('q_next_id');
            $table->text('type');
        });
        Schema::dropIfExists($status_pool_table);
        Schema::create($status_pool_table, function($table) {
            $table->text('id');
            $table->text('status');
        });
        
        DB::table($questions_table)->insert(
                [
                    'q_id' => 1,
                    'question_text' => 'Дозвонились',
                    'opros_id' => 1
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 1,
                    'answer_text' => 'Да',
                    'q_id' => 1,
                    'q_next_id' => 2,
                    'type' => 'button'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 2,
                    'answer_text' => 'Нет',
                    'q_id' => 1,
                    'q_next_id' => 3,
                    'type' => 'button'
                ]
        );

        DB::table($questions_table)->insert(
                [
                    'q_id' => 2,
                    'question_text' => 'Поздравили',
                    'opros_id' => 1
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 3,
                    'answer_text' => 'Да',
                    'q_id' => 2,
                    'q_next_id' => 3,
                    'type' => 'button'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 4,
                    'answer_text' => 'Нет',
                    'q_id' => 2,
                    'q_next_id' => 3,
                    'type' => 'button'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 3,
                    'question_text' => 'Оставить комментарий',
                    'opros_id' => 1
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 5,
                    'answer_text' => 'type="text" name="comment"',
                    'q_id' => 3,
                    'q_next_id' => 0,
                    'type' => 'input'
                ]
        );

        return view('layouts.admin.admin_index');
    }

}
