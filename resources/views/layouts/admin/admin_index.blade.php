@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Административная панель</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif


                    <div class="links">
                        <a href="<?=route('all_clients')?>">Импорт Туристов</a><br />
                        <a href="<?=route('ParseBids')?>">Импорт Заявок</a><br />
                        <a href="<?=route('all_leads_requests')?>">Импорт Обращений</a><br />
                        <a href="<?=route('get_countries')?>">Импорт Стран</a><br />
                        <a href="<?=route('get_citys')?>">Импорт Городов</a><br />
                        <a href="<?=route('get_hotels')?>">Импорт Отелей</a><br />
                        <a href="<?=route('get_sourses')?>">Импорт Источников</a><br />
                        <a href="<?=route('get_managers')?>">Импорт Менеджеров</a><br />
                        <a href="<?=route('get_companies')?>">Импорт Компаний</a><br />
                        <a href="<?=route('get_operators')?>">Импорт Туроператоров</a><br />
                        <a href="<?=route('get_avia')?>">Импорт Авиакомпаний</a><br />
                        <a href="<?=route('get_partners')?>">Импорт Партнёров</a><br />
                        <a href="<?=route('get_services')?>">Импорт Услуг</a><br />
                        <a href="<?=route('add_tour_type')?>">Добавить типы услуг</a><br />
                        <a href="<?=route('get_statuses')?>">Импорт статусов заявок</a><br />
                        <a href="<?=route('get_cash')?>">Импорт касс</a><br />
                        <a href="<?=route('get_nutritions')?>">Импорт типов питания</a><br />
                        <a href="<?=route('get_offices')?>">Импорт Офисов</a><br />
                        <a href="<?=route('get_labels')?>">Импорт Меток</a><br />
                        <a href="<?=route('insert_questions')?>">Обновить базу вопросов для CC</a><br />
                        <a href="<?=route('add_role')?>">Добавить роль пользователя</a><br />
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
