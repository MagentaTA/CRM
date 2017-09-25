@extends('layouts.app')

@section('content')
<?php //var_dump($bid); ?>
<?php $date_norm = new App\myDate(); ?>

<div class="panel panel-default">
    <div class="panel-heading">Редактирование заявки</div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div id="bid_tabs">
            <ul>
                <li><a href="#tabs-1">Основные</a></li>
            </ul>
            <?php Form::open(array('url' => route('bid_change', ['id' => $bid->r_id]), 'method' => 'post')) ?>
            <div id="tabs-1">
                <table class="table table-bordered">
                    <tr><td colspan="6" style="text-align: center;"><b>Основные</b></td></tr>
                    <tr>
                        <td>{{ Form::label('status','Статус: ') }}</td>
                        <?php
                        $statuses = GuzzleHttp\json_decode($statuses, TRUE);
                        ?>
                        <td>{{ Form::select('status', $statuses, $bid->r_status_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('notes','Примечания: ')}}</td>
                        <td>{{ Form::textarea('notes', $bid->r_notes) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('company_fullname','Оформляющая компанія: ') }}</td>
                        <?php
                        $companies = GuzzleHttp\json_decode($companies, TRUE);
                        foreach ($companies as $com_id => $company) {
                            if (htmlspecialchars($company) == htmlspecialchars($bid->r_company_fullname)) {
                                $company_id = $com_id;
                            }
                        }
                        ?>
                        <td>{{ Form::select('company_fullname', $companies, $company_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('supplier_name','Туроператор: ') }}</td>
                        <?php
                        $operators = GuzzleHttp\json_decode($operators, TRUE);
                        ?>
                        <td>{{ Form::select('supplier_name', $operators, $bid->r_supplier_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('type_tours','Тип тура: ') }}</td>
                        <?php
                        $types = GuzzleHttp\json_decode($types, TRUE);
                        ?>
                        <td>{{ Form::select('type_tours', $types, $bid->r_travel_type_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('manager','Менеджер: ') }}</td>
                        <?php
                        $managers = GuzzleHttp\json_decode($managers, TRUE);
                        ?>
                        <td>{{ Form::select('manager', $managers, $bid->r_manager_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('source','Источник: ') }}</td>
                        <?php
                        $sources = GuzzleHttp\json_decode($sourses, TRUE);
                        ?>
                        <td>{{ Form::select('source', $sources, $bid->uon_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('bron','Номер брони: ')}}</td>
                        <td>{{ Form::text('bron', $bid->r_reservation_number) }}</td>
                    </tr>
                    <tr>
                        <?php
                        $r_date = $date_norm->getNormalDate($bid->r_dat);
                        ?>
                        <td>{{ Form::label('dat','Дата: ')}}</td>
                        <td>{{ Form::text('dat', $r_date) }}</td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr><td colspan="6" style="text-align: center;"><b>Заказчик</b></td></tr>
                    <tr>
                        <td>{{ Form::label('surname','Фамилия: ')}}</td>
                        <td>{{ Form::text('surname', $bid->u_surname) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('name','Имя: ')}}</td>
                        <td>{{ Form::text('name', $bid->u_name) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('sname','Отчество: ')}}</td>
                        <td>{{ Form::text('sname', $bid->u_sname) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('email','E-mail: ')}}</td>
                        <td>{{ Form::text('email', $bid->r_client_email) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('tel_no','Телефон: ')}}</td>
                        <td>{{ Form::text('tel_no', $bid->r_client_phone_mobile) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('calc_price','Цена клиента: ')}}</td>
                        <td>{{ Form::text('calc_price', $bid->r_calc_price) }}</td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr><td colspan="6" style="text-align: center;"><b>Туристы</b></td></tr>
                    @if ($tourists)
                    @foreach ($tourists as $tourist)
                    <tr>
                        <td>
                            {{ $tourist->u_surname }}
                        </td>
                        <td>
                            {{ $tourist->u_name }}
                        </td>
                        <td>
                            {{ $tourist->u_sname }}
                        </td>
                        <td>
                            {{ $tourist->u_phone_mobile }}
                        </td>

                    </tr>
                    @endforeach
                    @endif
                </table>
                <table class="table table-bordered">
                    <tr><td colspan="6" style="text-align: center;"><b>Услуги в заявке</b></td></tr>
                    @if ($services)
                    <tr style="text-decoration: underline;">
                        <td>
                            Даты:
                        </td>
                        <td>
                            Описание:
                        </td>
                        <td>
                            Партнёр:
                        </td>
                        <td>
                            Курс и расчёт:
                        </td>
                        <td>
                            Цена:
                        </td>
                        <td>
                            Действия:
                        </td>
                    </tr>
                    @foreach ($services as $service)
                    @if ($service->service_type_id <> 6)
                    <tr>
                        <?php
                        //var_dump($service);
                        $date_norm = new App\myDate();
                        $date_begin = $date_norm->getNormalDate($service->date_begin);
                        $date_end = $date_norm->getNormalDate($service->date_end);
                        ?>
                        <td>{{$date_begin}} - {{$date_end}}</td>
                        <td>
                            @if ($service->in_package == 1)
                            <span class="oi oi-layers" title="Входит в пакетный тур" aria-hidden="true">
                                @endif
                                <b>{{$service->service_type}}</b><br />{{$service->description}}<br />
                                {{$service->country}}, {{$service->city}}, {{$service->hotel}}, {{$service->nutrition}}<br />
                                <b>Туристы: </b>{{$service->tourists_count}} <span class="oi oi-person" title="Редактировать" aria-hidden="true">
                                    </td>

                                    <td>{{$service->partner_name}}</td>
                                    <td>{{$service->price}} {{$service->currency_netto}} * {{$service->rate}} (=) <br /></td>
                                    <td>{{round($service->price*$service->rate,2)}} грн.</td>
                                    </tr>
                                    @endif
                                    @if ($service->service_type_id == 6)
                                    @foreach ($flights as $flight)
                                    <tr>
                                        <?php
                                        //var_dump($services);
                                        $date_begin = $date_norm->getNormalDate($flight->date_begin);
                                        $date_end = $date_norm->getNormalDate($flight->date_end);
                                        ?>
                                        <td>{{$date_begin}} <b>({{$flight->time_begin}})</b> - {{$date_end}} <b>({{$flight->time_end}})</b></td>
                                        <td>
                                            @if ($service->in_package == 1)
                                            <span class="oi oi-layers" title="Входит в пакетный тур" aria-hidden="true">
                                                @endif
                                                <b>{{$service->service_type}}</b><br />{{$service->description}}<br />
                                                Вылет: {{$flight->course_begin}}<br />
                                                <b>Туристы: </b>{{$service->tourists_count}} <span class="oi oi-person" title="Редактировать" aria-hidden="true">

                                                    </td>
                                                    <td>{{$service->partner_name}}</td>
                                                    <td>{{$service->price}} {{$service->currency_netto}} * {{$service->rate}} (=) <br /></td>
                                                    <td>{{round($service->price*$service->rate,2)}} грн.</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    </table>
                                                    <table class="table table-bordered">
                                                        <tr><td colspan="6" style="text-align: center;"><b>Платежи по заявке</b></td></tr>
                                                        <th>Каса</th><th>Тип и дата</th><th>Курс</th><th>Сумма</th>
                                                        @if($payments)
                                                        @foreach($payments as $payment)
                                                        <?php
                                                        //  var_dump($payment);
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $cash_data = new App\Helper();
                                                                $cash_name = $cash_data->getCashData($payment->cash_id);
                                                                ?>
                                                                {{$cash_name->name}}
                                                            </td>
                                                            <?php
                                                            $date_norm = new App\myDate();
                                                            $cash_date = $date_norm->getNormalDateTime($payment->date_create);
                                                            ?>
                                                            <td>{{$cash_date}}</td>
                                                            <td>{{$payment->rate}} {{$payment->currency}}</td>
                                                            <td>{{$payment->price}} {{$payment->currency}}</td>
                                                        </tr>
                                                        @endforeach
                                                        @endif

                                                    </table>
                                                    </div>
                                                    </div>

                                                    {{ Form::close() }}
                                                    <script>
                                                        $(function () {
                                                            $('#bid_tabs').tabs();
                                                            $('[name="birthday"]').datepicker({
                                                                changeMonth: true,
                                                                changeYear: true,
                                                                dateFormat: 'dd.mm.yy'
                                                            });
                                                        });
                                                    </script>
                                                    </div>
                                                    </div>
                                                    @endsection
