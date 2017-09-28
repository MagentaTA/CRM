@extends('layouts.app')

@section('content')
<?php //var_dump($bid); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование обращения<br />
                    {{ Form::label('statuse','Статус: ') }}
                    <?php
                    $statuses = GuzzleHttp\json_decode($statuses, TRUE);
                    ?>
                    {{ Form::select('statuse', $statuses, $lead->l_status_id, ['class' => 'form-control selectpicker']) }}
                </div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">Данные по клиенту</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    {{ Form::label('name','Имя клиента: ')}}
                                    {{ Form::text('name', $lead->l_client_name, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::label('surname','Фамилия клиента: ')}}
                                    {{ Form::text('surname', $lead->l_client_surname, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::label('sname','Отчество клиента: ')}}
                                    {{ Form::text('sname', $lead->l_client_sname, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('email','E-Mail клиента: ')}}
                                    {{ Form::text('email', $lead->l_client_email, ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('phone','Телефон клиента: ')}}
                                    {{ Form::text('phone', $lead->l_client_phone_mobile, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            {{ Form::label('notes','Примечания: ')}}
                            {{ Form::textarea('notes', $lead->l_notes, ['class' => 'form-control']) }}
                            {{ Form::label('source','Источник: ') }}
                            <?php
                            $sources = GuzzleHttp\json_decode($sourses, TRUE);
                            ?>
                            {{ Form::select('source', $sources, $lead->l_source_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
                            <?php
                            $tour_types = GuzzleHttp\json_decode($tour_types, TRUE);
                            ?>
                            {{ Form::label('tour_type','Тип тура: ') }}
                            {{ Form::select('tour_type', $tour_types, $lead->l_travel_type_id, ['class' => 'form-control selectpicker']) }}

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Данные продавца</div>
                        <div class="card-body">
                            {{ Form::label('manager','Менеджер: ') }}
                            <?php
                            $managers = GuzzleHttp\json_decode($managers, TRUE);
                            ?>
                            {{ Form::select('manager', $managers, $lead->l_manager_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}

                            {{ Form::label('company_fullname','Оформляющая компанія: ') }}
                            <?php
                            $companies = GuzzleHttp\json_decode($companies, TRUE);
                            foreach ($companies as $com_id => $company) {
                                if (htmlspecialchars($company) == htmlspecialchars($lead->l_company_fullname)) {
                                    $company_id = $com_id;
                                }
                            }
                            ?>
                            {{ Form::select('company_fullname', $companies, $company_id, ['class' => 'form-control selectpicker']) }}

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Запрос</div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
