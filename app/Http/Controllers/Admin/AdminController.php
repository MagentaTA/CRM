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

        $cc = new Role();
        $cc->name = 'cc';
        $cc->display_name = 'Операторы Call-Center'; // optional
        $cc->description = 'Права оператора Call-Center'; // optional
        $cc->update();
        $cc->save();


        $admin_user = User::where('email', '=', 'vader85@inbox.ru')->first();
        $admin_user->detachRole('developer');
        $admin_user->attachRole('developer');
        $admin_user->detachRole('cc');
        $admin_user->attachRole('cc');


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
            $table->integer('r_id')->default(0);
            $table->text('answer')->nullable();
            $table->text('status')->nullable();
            $table->dateTime('date_pool');
        });
        Schema::dropIfExists($questions_table);
        Schema::create($questions_table, function($table) {
            $table->integer('q_id');
            $table->text('question_text');
            $table->integer('opros_id');
            $table->text('q_type');
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
            $table->text('date_for_call');
        });
        // Опросник по ДР
        DB::table($questions_table)->insert(
                [
                    'q_id' => 10,
                    'question_text' => 'Дозвонились',
                    'opros_id' => 1,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 1,
                    'answer_text' => 'Да',
                    'q_id' => 10,
                    'q_next_id' => 20,
                    'type' => 'button'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 2,
                    'answer_text' => 'Нет',
                    'q_id' => 10,
                    'q_next_id' => 30,
                    'type' => 'button'
                ]
        );

        DB::table($questions_table)->insert(
                [
                    'q_id' => 20,
                    'question_text' => 'Поздравили',
                    'opros_id' => 1,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 3,
                    'answer_text' => 'Да',
                    'q_id' => 20,
                    'q_next_id' => 30,
                    'type' => 'button'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 4,
                    'answer_text' => 'Нет',
                    'q_id' => 20,
                    'q_next_id' => 30,
                    'type' => 'button'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 30,
                    'question_text' => 'Оставить комментарий',
                    'opros_id' => 1,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 5,
                    'answer_text' => 'type="text" name="comment"',
                    'q_id' => 30,
                    'q_next_id' => 0,
                    'type' => 'input'
                ]
        );
        // Опросник по ППО
        DB::table($questions_table)->insert(
                [
                    'q_id' => 40,
                    'question_text' => 'Дозвонились',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 6,
                    'answer_text' => 'Да',
                    'q_id' => 40,
                    'q_next_id' => 50,
                    'type' => 'button'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 7,
                    'answer_text' => 'Нет',
                    'q_id' => 40,
                    'q_next_id' => 60,
                    'type' => 'button'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 60,
                    'question_text' => 'Оставить комментарий',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 8,
                    'answer_text' => 'type="text" name="comment"',
                    'q_id' => 60,
                    'q_next_id' => 0,
                    'type' => 'input'
                ]
        );

        DB::table($questions_table)->insert(
                [
                    'q_id' => 50,
                    'question_text' => 'Турист готов говорить',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 9,
                    'answer_text' => 'Да',
                    'q_id' => 50,
                    'q_next_id' => 69,
                    'type' => 'button'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 10,
                    'answer_text' => 'Нет',
                    'q_id' => 50,
                    'q_next_id' => 80,
                    'type' => 'button'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 80,
                    'question_text' => 'Дата звонка',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 11,
                    'answer_text' => 'type="text" name="date_for_call"',
                    'q_id' => 80,
                    'q_next_id' => 0,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 69,
                    'question_text' => 'Чому ви обрали саме нашу компанію',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 19,
                    'answer_text' => 'type="text" name="why_our_company"',
                    'q_id' => 69,
                    'q_next_id' => 70,
                    'type' => 'input'
                ]
        );

        DB::table($questions_table)->insert(
                [
                    'q_id' => 70,
                    'question_text' => 'Що важливо для вас при виборі компанії',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 12,
                    'answer_text' => 'type="text" name="important_comment"',
                    'q_id' => 70,
                    'q_next_id' => 90,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 90,
                    'question_text' => 'Сподобалось у нас в офісі? Чи було зручно оформлятись через інтернет',
                    'opros_id' => 2,
                    'q_type' => 'select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 13,
                    'answer_text' => 'Так',
                    'q_id' => 90,
                    'q_next_id' => 100,
                    'type' => 'option'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 14,
                    'answer_text' => 'Ні',
                    'q_id' => 90,
                    'q_next_id' => 100,
                    'type' => 'option'
                ]
        );
        
        DB::table($questions_table)->insert(
                [
                    'q_id' => 100,
                    'question_text' => 'Запропонував менеджер додаткові послуги',
                    'opros_id' => 2,
                    'q_type' => 'select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 15,
                    'answer_text' => 'Так',
                    'q_id' => 100,
                    'q_next_id' => 110,
                    'type' => 'option'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 16,
                    'answer_text' => 'Ні',
                    'q_id' => 100,
                    'q_next_id' => 110,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 110,
                    'question_text' => 'Оцініть вашого персонального менеджера по 10-бальній шкалі',
                    'opros_id' => 2,
                    'q_type' => 'select_0_10'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 17,
                    'answer_text' => 'type="hidden" name="manager_rating"',
                    'q_id' => 110,
                    'q_next_id' => 120,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 120,
                    'question_text' => 'Що повинен був зробити ваш менеджер, щоб ви поставили йому 10-ку',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 18,
                    'answer_text' => 'type="text" name="manager_do"',
                    'q_id' => 120,
                    'q_next_id' => 130,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 130,
                    'question_text' => 'Чи відповідав готель опису, який надав вам ваш менеджер',
                    'opros_id' => 2,
                    'q_type' => 'select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 20,
                    'answer_text' => 'Так',
                    'q_id' => 130,
                    'q_next_id' => 140,
                    'type' => 'option'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 21,
                    'answer_text' => 'Ні',
                    'q_id' => 130,
                    'q_next_id' => 140,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 140,
                    'question_text' => 'Оцініть готель',
                    'opros_id' => 2,
                    'q_type' => 'hotel_select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 22,
                    'answer_text' => '',
                    'q_id' => 140,
                    'q_next_id' => 150,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 150,
                    'question_text' => 'Що ви можете прокоментувати про готель',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 23,
                    'answer_text' => 'type="text" name="hotel_comment"',
                    'q_id' => 150,
                    'q_next_id' => 160,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 160,
                    'question_text' => 'Оцініть роботу авиакомпании ',
                    'opros_id' => 2,
                    'q_type' => 'avia_select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 24,
                    'answer_text' => '',
                    'q_id' => 160,
                    'q_next_id' => 170,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 170,
                    'question_text' => 'Оцініть роботу приймаючої сторони',
                    'opros_id' => 2,
                    'q_type' => 'operator_select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 25,
                    'answer_text' => '',
                    'q_id' => 170,
                    'q_next_id' => 180,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 180,
                    'question_text' => 'Поділіться своїми враженнями від поїздки, що сподобалось найбільше',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 26,
                    'answer_text' => '',
                    'q_id' => 180,
                    'q_next_id' => 190,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 190,
                    'question_text' => 'Чи зв\'язувався з вами менеджер після поїздки',
                    'opros_id' => 2,
                    'q_type' => 'select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 27,
                    'answer_text' => 'Так',
                    'q_id' => 190,
                    'q_next_id' => 200,
                    'type' => 'option'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 28,
                    'answer_text' => 'Ні',
                    'q_id' => 190,
                    'q_next_id' => 200,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 200,
                    'question_text' => 'Чи рекомендували нашу компанію друзям',
                    'opros_id' => 2,
                    'q_type' => 'select'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 28,
                    'answer_text' => 'Так',
                    'q_id' => 200,
                    'q_next_id' => 210,
                    'type' => 'option'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 29,
                    'answer_text' => 'Ні',
                    'q_id' => 200,
                    'q_next_id' => 210,
                    'type' => 'option'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 30,
                    'answer_text' => 'Не прокоментувала',
                    'q_id' => 200,
                    'q_next_id' => 210,
                    'type' => 'option'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 210,
                    'question_text' => 'Що ми можемо зробити для того, щоб ви нас рекомендували',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 31,
                    'answer_text' => '',
                    'q_id' => 210,
                    'q_next_id' => 220,
                    'type' => 'input'
                ]
        );
        DB::table($questions_table)->insert(
                [
                    'q_id' => 220,
                    'question_text' => 'На які дати ви плануєте ваш наступний відпочинок',
                    'opros_id' => 2,
                    'q_type' => 'input'
                ]
        );
        DB::table($answers_table)->insert(
                [
                    'a_id' => 32,
                    'answer_text' => 'name="date_for_travel"',
                    'q_id' => 220,
                    'q_next_id' => 230,
                    'type' => 'input'
                ]
        );


        return view('layouts.admin.admin_index');
    }

}
