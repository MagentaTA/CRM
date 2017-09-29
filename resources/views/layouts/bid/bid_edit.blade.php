@extends('layouts.app')

@section('content')
<?php //var_dump($bid); ?>
<?php $date_norm = new App\myDate(); ?>
<div class="panel panel-default row">
    <div class="panel-heading">Редактирование заявки</div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <?php Form::open(array('url' => route('bid_change', ['id' => $bid->r_id]), 'method' => 'post')) ?>
        <div class="col-md-12 bg-success" style="height: 3rem; font-size: 2rem;">
            Основные
        </div>
        <div class="col-md-5">
            {{ Form::label('status','Статус: ') }}</td>
            <?php
            $statuses = GuzzleHttp\json_decode($statuses, TRUE);
            ?>
        </div>
        <div class="col-md-5">
            {{ Form::select('status', $statuses, $bid->r_status_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-5">
            {{ Form::label('notes','Примечания: ')}}        
        </div>
        <div class="col-md-5">
            {{ Form::textarea('notes', $bid->r_notes, ['class' => 'form-control']) }}        
        </div>
        <div class="col-md-5">
            {{ Form::label('company_fullname','Оформляющая компанія: ') }}        
        </div>
        <div class="col-md-5">
            <?php
            $companies = GuzzleHttp\json_decode($companies, TRUE);
            foreach ($companies as $com_id => $company) {
                if (htmlspecialchars($company) == htmlspecialchars($bid->r_company_fullname)) {
                    $company_id = $com_id;
                }
            }
            ?>
            {{ Form::select('company_fullname', $companies, $company_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-5">
            {{ Form::label('supplier_name','Туроператор: ') }}                        
        </div>
        <div class="col-md-5">
            <?php
            $operators = GuzzleHttp\json_decode($operators, TRUE);
            ?>
            {{ Form::select('supplier_name', $operators, $bid->r_supplier_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-4">
            {{ Form::label('type_tours','Тип тура: ') }}
            <?php
            $types = GuzzleHttp\json_decode($types, TRUE);
            ?>
            {{ Form::select('type_tours', $types, $bid->r_travel_type_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-4">
            {{ Form::label('manager','Менеджер: ') }}
            <?php
            $managers = GuzzleHttp\json_decode($managers, TRUE);
            ?>
            {{ Form::select('manager', $managers, $bid->r_manager_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-4">
            {{ Form::label('source','Источник: ') }}
            <?php
            $sources = GuzzleHttp\json_decode($sourses, TRUE);
            ?>
            {{ Form::select('source', $sources, $bid->uon_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('bron','Номер брони: ')}}
            {{ Form::text('bron', $bid->r_reservation_number, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6">
            <?php
            $r_date = $date_norm->getNormalDate($bid->r_dat);
            ?>
            {{ Form::label('dat','Дата: ')}}
            {{ Form::text('dat', $r_date, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-12 bg-primary" style="height: 3rem; font-size: 2rem;">
            Заказчик
        </div>
        <div class="col-md-4">
            {{ Form::label('surname','Фамилия: ')}}
            {{ Form::text('surname', $user->u_surname, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-4">
            {{ Form::label('name','Имя: ')}}
            {{ Form::text('name', $user->u_name, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-4">
            {{ Form::label('sname','Отчество: ')}}
            {{ Form::text('sname', $user->u_sname, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('email','E-mail: ')}}
            {{ Form::text('email', $bid->r_client_email, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('tel_no','Телефон: ')}}
            {{ Form::text('tel_no', $user->u_phone, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('calc_price','Цена для клиента: ')}}
            {{ Form::text('calc_price', $bid->r_calc_price, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('calc_price','Цена для нас: ')}}
            {{ Form::text('calc_price', $bid->r_calc_price_netto, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-12 bg-primary" style="height: 3rem; font-size: 2rem;">
            Туристы                        
        </div>
        @if ($tourists)
        @foreach ($tourists as $tourist)
        <div class="col-md-3">
            {{ $tourist->u_surname }}
        </div>
        <div class="col-md-3">
            {{ $tourist->u_name }}
        </div>
        <div class="col-md-3">
            {{ $tourist->u_sname }}
        </div>
        <div class="col-md-3">
            {{ $tourist->u_phone_mobile }}
        </div>
        @endforeach
        @endif
        <div class="col-md-12 bg-warning" style="height: 3rem; font-size: 2rem;">
            Услуги в заявке                        
        </div>
        @if ($services)
        <div class="col-md-2">
            Даты:
        </div>
        <div class="col-md-3">
            Описание:
        </div>
        <div class="col-md-2">
            Партнёр:
        </div>
        <div class="col-md-2">
            Курс и расчёт:
        </div>
        <div class="col-md-2">
            Цена:
        </div>
        <div class="col-md-1">
            Действия:
        </div>
        @foreach ($services as $service)
        @if ($service->service_type_id <> 6)
        <?php
        //var_dump($service);
        $date_norm = new App\myDate();
        $date_begin = $date_norm->getNormalDate($service->date_begin);
        $date_end = $date_norm->getNormalDate($service->date_end);
        ?>
        <div class="col-md-2"> {{$date_begin}} - {{$date_end}}</div>
        <div class="col-md-3">
            @if ($service->in_package == 1)
            <span class="oi oi-layers" title="Входит в пакетный тур" aria-hidden="true">
                @endif
                <b>{{$service->service_type}}</b><br />{{$service->description}}<br />
                {{$service->country}}, {{$service->city}}, {{$service->hotel}}, {{$service->nutrition}}<br />
                <b>Туристы: </b>{{$service->tourists_count}} <span class="oi oi-person" title="Редактировать" aria-hidden="true">
                    </div>
                    <div class="col-md-2">
                        {{$service->partner_name}}
                    </div>
                    <div class="col-md-2">
                        {{$service->price}} {{$service->currency_netto}} * {{$service->rate}} (=)    
                    </div>
                    <div class="col-md-2">
                        {{round($service->price*$service->rate,2)}} грн.<br />
                        <div class="bg-info">
                            {{round($service->price_netto*$service->rate_netto,2)}} грн.<br />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('service_edit',['id' => $service->crm_id]) }}"><span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></a>
                    </div>
                    <div class="clearfix"></div>
                    @endif
                    @if ($service->service_type_id == 6)
                    @foreach ($flights as $flight)
                    <div class="col-md-2">
                        <?php
                        $date_begin = $date_norm->getNormalDate($flight->date_begin);
                        $date_end = $date_norm->getNormalDate($flight->date_end);
                        ?>
                        {{$date_begin}} <b>({{$flight->time_begin}})</b> - {{$date_end}} <b>({{$flight->time_end}})</b>
                    </div>
                    <div class="col-md-3">
                        @if ($service->in_package == 1)
                        <span class = "oi oi-layers" title = "Входит в пакетный тур" aria-hidden = "true">
                            @endif
                            <b>{{$service->service_type}}</b><br />{{$service->description}}<br />
                            Вылет: {{$flight->course_begin}}<br />
                            <b>Туристы: </b>{{$service->tourists_count}} <span class = "oi oi-person" title = "Турист" aria-hidden = "true">
                                </div>
                                <div class="col-md-2">
                                    {{$service->partner_name}}
                                </div>
                                <div class="col-md-2">
                                    {{$service->price}} {{$service->currency_netto}} * {{$service->rate}} ( = )                                    
                                </div>
                                <div class="col-md-2">
                                    {{round($service->price*$service->rate, 2)}} грн.
                                    <div class="bg-info">
                                        {{round($service->price_netto*$service->rate_netto,2)}} грн.<br />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a href = "{{ route('service_edit',['id' => $service->crm_id]) }}"><span class = "oi oi-pencil" title = "Редактировать" aria-hidden = "true"></a>
                                </div>
                                <div class="clearfix"></div>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                                <table class = "table table-bordered">
                                    <tr><td colspan = "6" style = "text-align: center;"><b>Расчёты с заказчиком</b></td></tr>
                                    <th>Каса</th><th>Тип и дата</th><th>Курс</th><th>Сумма</th><th>Офис</th>
                                    @if($payments)
                                    @foreach($payments as $payment)
                                    <?php
                                    //var_dump($payment);
                                    //echo '---------------------------------------<br />';
                                    ?>
                                    @if($payment->type_id == 1)
                                    <?php
                                    if ($payment->cio_id == 2) {
                                        echo '<tr class="payment_minus">';
                                    } else {
                                        echo '<tr class="payment_plus">';
                                    }
                                    ?>

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
                                    <td>{{$payment->rate}} * {{$payment->price}} {{$payment->currency}}</td>
                                    <?php
                                    $cur_price = $payment->rate * $payment->price;
                                    ?>
                                    <td>{{$cur_price}} грн.</td>

                                    <td>
                                        {{ Form::select('office_name', $offices, $payment->office_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
                                    </td>
                                    </tr>
                                    @endif

                                    @endforeach
                                </table>
                                <table class="table table-bordered">
                                    <tr><td colspan="6" style="text-align: center;"><b>Расчеты с партнёрами</b></td></tr>
                                    <th>Каса</th><th>Тип и дата</th><th>Курс</th><th>Сумма</th><th>Офис</th>

                                    @foreach($payments as $payment)
                                    <?php
                                    //var_dump($payment);
                                    //echo '---------------------------------------<br />';
                                    ?>
                                    @if($payment->type_id == 2)
                                    <?php
                                    if ($payment->cio_id == 2) {
                                        echo '<tr class="payment_minus">';
                                    } else {
                                        echo '<tr class="payment_plus">';
                                    }
                                    ?>

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
                                    <td>{{$payment->rate}} * {{$payment->price}} {{$payment->currency}}</td>
                                    <?php
                                    $cur_price = $payment->rate * $payment->price;
                                    ?>
                                    <td>{{$cur_price}} грн.</td>
                                    <td>
                                        {{ Form::select('office_name', $offices, $payment->office_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
                                    </td>
                                    </tr>

                                    @endif
                                    @endforeach

                                    @endif

                                </table>
                                <div id="tabs-2">
                                    <ul class="list-group-item-info">
                                        @foreach ($reminders as $reminder)
                                        <li class="list-group-item">
                                            {{$reminder->text}}
                                            <br />
                                            {{$reminder->datetime}}
                                        </li>
                                        @endforeach
                                    </ul>
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
                                @endsection
