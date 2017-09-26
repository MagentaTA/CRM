@extends('layouts.app')

@section('content')
<?php //var_dump($bid); ?>
<?php $date_norm = new App\myDate(); ?>

<div class="panel panel-default">
    <div class="panel-heading">Редактирование Услуги по заявке</div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        {{ $service_data }}
    </div>
    @endsection
