@extends('layouts.app')
@section('content')
<!-- Модальное окно -->
<?php
$date_norm = new App\myDate();

use Carbon\Carbon;
?>
<!-- Модальное окно -->
<div class="modal fade" id="bid_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:90rem;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close_dialog" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary confirm_dialog">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
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
        <div class="col-md-2">
            {{ Form::label('status','Статус: ') }}</td>
            <?php
            $statuses = GuzzleHttp\json_decode($statuses, TRUE);
            ?>
            {{ Form::select('status', $statuses, $bid->r_status_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('notes','Примечания: ')}}        
            {{ Form::textarea('notes', $bid->r_notes, ['class' => 'form-control','style' => 'height:3rem;']) }}        
        </div>
        <div class="col-md-2">
            {{ Form::label('company_fullname','Компания: ') }}        
            <?php
            $companies = GuzzleHttp\json_decode($companies, TRUE);
            foreach ($companies as $com_id => $company) {
                if (htmlspecialchars($company) == htmlspecialchars($bid->r_company_fullname)) {
                    $company_id = $com_id;
                }
            }
            ?>
            {{ Form::select('company_fullname', $companies, $company_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'disabled' => 'disabled']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('supplier_name','Туроператор: ') }}                        
            <?php
            $operators = GuzzleHttp\json_decode($operators, TRUE);
            ?>
            {{ Form::select('supplier_name', $operators, $bid->r_supplier_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('type_tours','Тип тура: ') }}
            <?php
            $types = GuzzleHttp\json_decode($types, TRUE);
            ?>
            {{ Form::select('type_tours', $types, $bid->r_travel_type_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('manager','Менеджер: ') }}
            <?php
            $managers = GuzzleHttp\json_decode($managers, TRUE);
            ?>
            {{ Form::select('manager', $managers, $bid->r_manager_id, ['class' => 'form-control manager_data selectpicker', 'data-live-search' => 'true']) }}
            <a role="button" class="btn btn-success send_for_manager" style="margin-top:0.5rem;" data-toggle="modal" data-target="#bid_modal">Запрос менеджеру</a>
            <?php
            $text_remind = '';
            $text_remind .= Form::open(array('url' => route('add_reminder'), 'method' => 'post', 'id' => 'send_reminder'));
            $text_remind .= Form::label('date_remind', 'Дата напоминания:');
            $text_remind .= '<br />';
            $text_remind .= Form::date('date_remind', \Carbon\Carbon::now('Europe/Kiev')->toDateString());
            $text_remind .= Form::hidden('pool_id', $id);
            $text_remind .= Form::hidden('client_id', $bid->r_client_id);
            $text_remind .= Form::hidden('from_id', 11307);
            $text_remind .= '<br />';
            $text_remind .= Form::label('manager', 'Кому напоминание:');
            $text_remind .= '<div style="margin-top:0.5rem">' . Form::select('manager', $managers, $bid->r_manager_id, ['class' => 'form-control manager_data_modal selectpicker', 'data-live-search' => 'true']) . '</div>';
            $text_remind .= Form::label('do', 'Что сделать:');
            $text_remind .= '<div style="margin-top:0.5rem">' . Form::select('do', array('Позвонить' => 'Позвонить', 'Письмо' => 'Письмо', 'Встреча' => 'Встреча', 'Другое' => 'Другое'), 'Позвонить', ['class' => 'form-control type_remind']) . '</form>';
            $text_remind .= Form::label('remind_text', 'Дополнительная информация:');
            $text_remind .= '<br />';
            $text_remind .= '<textarea name="remind_text" class="text_for_manager" style="margin-top:0.5rem;"></textarea>';
            ?>
            <script>
                $('a.send_for_manager').bind('click', function () {
                    var manager = $('.manager_data option:selected').text();
                    var manager_id = $('.manager_data option:selected').val();
                    $('.modal-body').html('');
                    $('.modal-body').html('<?= $text_remind ?>');
                    $('.manager_data_modal').val(manager_id);
                    $('.manager_data_modal [value="' + manager_id + '"]').attr('selected', 'selected');
                    $('input[name="date_remind"]').datetimepicker({
                        locale: 'ru',
                        sideBySide: true
                    });
                    $('.selectpicker').each(function () {
                        $(this).selectpicker('refresh');
                    })
                    $('.modal-title').html('Отправка задания менеджеру ' + manager + ' (ID ' + manager_id + ')');
                    $('button.close_dialog').html('Отмена');
                    $('button.confirm_dialog').html('Отправить');
                    $('button.confirm_dialog').attr('type', 'submit');
                    $('button.confirm_dialog').attr('form', 'send_reminder');
                    $('.modal-content').append('<?= Form::close() ?>');
                });
            </script>
        </div>
        <div class="col-md-2">
            {{ Form::label('source','Источник: ') }}
            <?php
            $sources = GuzzleHttp\json_decode($sourses, TRUE);
            ?>
            {{ Form::select('source', $sources, $bid->uon_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('office','Офис: ') }}
            <?php
            $offices = GuzzleHttp\json_decode($offices, TRUE);
            ?>
            {{ Form::select('office', $offices, $bid->r_office_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('bron','Номер брони: ')}}
            {{ Form::text('bron', $bid->r_reservation_number, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-2">
            <?php
            $r_date_begin = $date_norm->getNormalDate($bid->r_date_begin);
            ?>
            {{ Form::label('date_begin','Дата выезда: ')}}
            {{ Form::text('date_begin', $r_date_begin, ['class' => 'form-control','disabled' => 'disabled']) }}
        </div>
        <div class="col-md-2">
            <?php
            $r_date_end = $date_norm->getNormalDate($bid->r_date_end);
            ?>
            {{ Form::label('date_end','Дата приезда: ')}}
            {{ Form::text('date_end', $r_date_end, ['class' => 'form-control','disabled' => 'disabled']) }}
        </div>
        
        <div class="col-md-12 bg-primary" style="height: 3rem; font-size: 2rem; margin-top: 1rem;">
            Заказчик
        </div>
        <div class="col-md-2">
            {{ Form::label('surname','Фамилия: ')}}
            {{ Form::text('surname', $user->u_surname, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('name','Имя: ')}}
            {{ Form::text('name', $user->u_name, ['class' => 'form-control']) }}
        </div>
        <div class="col-md-2">
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
        <div class="col-md-12 bg-primary" style="height: 3rem; font-size: 2rem; margin-top: 1rem;">
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
<?php /*                                <table class = "table table-bordered">
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

                                </table> */ ?>
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
                                </div>
                                @endsection
