@extends('layouts.app')

@section('content')
<?php $date_norm = new App\myDate(); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <a role="button" class="btn btn-primary" href="{{ URL::previous() }}">НАЗАД</a>
            </div>
            <div class="col-md-6">
                Редактирование Услуги по заявке                
            </div>
        </div>
    </div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <?php
        $services_types = GuzzleHttp\json_decode($services_types, TRUE);
        ?>
        <?php
        if ($service_data->service_type_id == 6) {
            $k = 1;
            ?>
            @if($flys)
            @foreach($flys as $fly)
            <div class="row" style="margin-top: 0.5rem;">
                <div class="col-md-12 bg-info">
                    Перелёт № {{$k}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    {{ Form::label('date_begin','Дата отправления: ') }}
                    {{ Form::text('date_begin', $fly->date_begin, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-5">
                    {{ Form::label('time_begin','Время отправления: ') }}
                    {{ Form::text('time_begin', $fly->time_begin, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('avia','Авиакомпания: ') }}
                    {{ Form::select('avia', $avia, $fly->supplier_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('flight_number','Номер рейса: ') }}
                    {{ Form::text('flight_number', $fly->flight_number, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('course_begin','Отправление: ') }}
                    {{ Form::text('course_begin', $fly->course_begin, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('code_begin','Код аэропорта: ') }}
                    {{ Form::text('code_begin', $fly->code_begin, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('terminal_begin','Терминал: ') }}
                    {{ Form::text('terminal_begin', $fly->terminal_begin, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('seats','Посадочные места: ') }}
                    {{ Form::text('seats', $fly->seats, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('tickets','Билеты: ') }}
                    {{ Form::text('tickets', $fly->tickets, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('type','Тип: ') }}
                    {{ Form::text('type', $fly->type, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('class','Тип: ') }}
                    {{ Form::select('class', [0 => '', 1 => 'Эконом', 2 => 'Бизнес', 3 => 'Первый'], $fly->class, ['class' => 'form-control selectpicker']) }}
                </div>
                <div class="col-md-4">или</div>
                <div class="col-md-4">
                    {{ Form::label('class','Тип: ') }}
                    {{ Form::text('class', $fly->class, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('duration','Время в пути: ') }}
                    {{ Form::text('duration', $fly->duration, ['class' => 'form-control']) }}
                </div>
            </div>

            <?php $k++; ?>
            @endforeach
            @endif
        <?php } else { ?>
            {{ Form::label('services_types','Услуга: ') }}
            {{ Form::select('services_types', $services_types, $service_data->service_type_id, ['class' => 'form-control selectpicker']) }}
            {{ Form::label('service_note','Описание услуги: ') }}
            {{ Form::textarea('service_note', $service_data->description, ['class' => 'form-control']) }}
            {{ Form::label('service_note_en','Описание услуги EN: ') }}
            {{ Form::textarea('service_note_en', '', ['class' => 'form-control']) }}
            {{ Form::label('service_link','Ссылка на услугу: ') }}
            {{ Form::textarea('service_link', '', ['class' => 'form-control']) }}
            <?php
            $date_begin = $date_norm->getDateFromDatetime($service_data->date_begin);
            $date_end = $date_norm->getDateFromDatetime($service_data->date_end);
            ?>
            {{ Form::label('dates','Даты: ') }}
            <div class="row">
                <div class="col-md-5">
                    {{ Form::text('date_begin', $date_begin, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-2 text-center">-</div>
                <div class="col-md-5">
                    {{ Form::text('date_end', $date_end, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('country','Страна: ') }}
                    {{ Form::text('country', $service_data->country, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('city','Город: ') }}
                    {{ Form::text('city', $service_data->city, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('hotel','Отель: ') }}
                    {{ Form::text('hotel', $service_data->hotel, ['class' => 'form-control']) }}
                </div>
            </div>
            {{ Form::label('nutrition','Тип питания: ') }}
            {{ Form::select('nutrition', $nutritions, $service_data->nutrition_id, ['class' => 'form-control selectpicker']) }}
            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('tourists_count','Кол-во туристов: ') }}
                    {{ Form::text('tourists_count', $service_data->tourists_count, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('tourists_child_count','Кол-во детей: ') }}
                    {{ Form::text('tourists_child_count', $service_data->tourists_child_count, ['class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('tourists_baby_count','Кол-во младенцев: ') }}
                    {{ Form::text('tourists_baby_count', $service_data->tourists_baby_count, ['class' => 'form-control']) }}
                </div>
            </div>
        <?php } ?>

    </div>
    @endsection
