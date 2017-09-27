@extends('layouts.app')

@section('content')
<?php $date_norm = new App\myDate(); ?>

<div class="panel panel-default">
    <div class="panel-heading">Редактирование Услуги по заявке</div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <?php
        $services_types = GuzzleHttp\json_decode($services_types, TRUE);
        ?>
        {{ Form::label('services_types','Услуга: ') }}
        {{ Form::select('services_types', $services_types, $service_data->service_type_id, ['class' => 'form-control']) }}
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
        {{ Form::select('nutrition', $nutritions, $service_data->nutrition_id, ['class' => 'form-control']) }}
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

    </div>
    @endsection
