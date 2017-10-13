@extends('layouts.app')
@section('content')
<!-- Модальное окно -->
<?php
$norm_date = new App\myDate();

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
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="col-md-12" style="margin: 0.5rem;">
                    <div class="col-md-6">Данные о звонке в День Рождения</div>
                    <div class="col-md-6"><a role="button" class="btn btn-primary" href="{{ URL::previous() }}">НАЗАД</a></div>
                </div>
                <div class="clearfix"></div>
                <div class="panel-body">
                    <?php $answers_class = new App\Helper; ?>
                    <h2>Данные об имениннике</h2>
                    <div class="col-md-6">
                        <span class="oi oi-person" title="ФИО Клиента" aria-hidden="true"></span> <a class="client_edit" style="cursor:pointer;" data-toggle="modal" data-target="#bid_modal">{{$user_data->u_surname}} {{$user_data->u_name}} {{$user_data->u_sname}}</a><br />
                        <script>
                            $('a.client_edit').bind('click', function () {
                            $('.modal-body').html('');
                            $('.modal-body').load('{{ route('client_edit',['id' => $user_data->u_id]) }} .panel-body', function(){
                            $('#client_tabs').tabs();
                            $('input[name="birthday"]').datetimepicker({
                            locale: 'ru',
                                    format: 'DD.MM.YYYY'
                            });
                            $('.confirm_dialog').bind('click', function(){
                            $('form[name="client_change"]').submit();
                            })
                            });
                            $('.modal-title').html('Турист №<?= $user_data->u_id ?>');
                            });
                        </script>
                        <?php
                        if (mb_strlen($user_data->u_phone_mobile) == 0 && mb_strlen($user_data->u_phone) == 0) {
                            echo '<span class="oi oi-phone" title="Телефон клиента" aria-hidden="true" style="color:red;"></span>';
                        } else {
                            echo '<span class="oi oi-phone" title="Телефон клиента" aria-hidden="true"></span>';
                        }
                        ?>
                        <b>{{$user_data->u_phone_mobile}} {{$user_data->u_phone}}</b><br />
                        <?php
                        if (mb_strlen($user_data->u_email) == 0) {
                            echo '<span class="oi oi-chat" title="E-Mail" aria-hidden="true" style="color:red;"></span><br />';
                        } else {
                            echo '<span class="oi oi-chat" title="E-Mail" aria-hidden="true"></span> ' . $user_data->u_email . '<br />';
                        }
                        $b_date = $user_data->u_birthday;
                        $b_date = $norm_date->getBirthdayDate($b_date);
                        $age = date('Y') - date('Y', strtotime($b_date));
                        ?>
                        <span class="oi oi-calendar" title="Дата рождения" aria-hidden="true"></span> {{$b_date}} (<b>{{$age}}</b>)
                    </div>
                    <div class="col-md-6">
                        <h3>Менеджер</h3>
                        <?php
                        $managers = GuzzleHttp\json_decode($managers, TRUE);
                        ?>
                        {{ Form::select('manager', $managers, $user_data->manager_id, ['class' => 'form-control selectpicker manager_data', 'data-live-search' => 'true']) }}
                        <a role="button" class="btn btn-success send_for_manager" style="margin-top:0.5rem;" data-toggle="modal" data-target="#bid_modal">Запрос менеджеру</a>
                        <?php
                        $text_remind = '';
                        $text_remind .= Form::open(array('url' => route('add_reminder'), 'method' => 'post', 'id' => 'send_reminder'));
                        $text_remind .= Form::label('date_remind', 'Дата напоминания:');
                        $text_remind .= '<br />';
                        $text_remind .= Form::date('date_remind', \Carbon\Carbon::now('Europe/Kiev')->toDateString());
                        $text_remind .= Form::hidden('pool_id', $id);
                        $text_remind .= Form::hidden('client_id', $user_data->u_id);
                        $text_remind .= Form::hidden('from_id', 11307);
                        $text_remind .= '<br />';
                        $text_remind .= Form::label('manager', 'Кому напоминание:');
                        $text_remind .= '<div style="margin-top:0.5rem">' . Form::select('manager', $managers, $user_data->manager_id, ['class' => 'form-control manager_data_modal selectpicker', 'data-live-search' => 'true']) . '</div>';
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
                    <div class="col-md-6 col-md-offset-6" style="margin-top: 0.5rem;">
                        <h3>Заявки</h3>
                        <?php
                        foreach ($bids as $bid) {
                            //var_dump($bid).'<br />';
                            $last_bid_date = $norm_date->getNormalDateTime($bid->r_dat);
                            ?>
                            <a class="btn btn-primary bid_edit_{{$bid->r_id}}" role="button" data-toggle="modal" data-target="#bid_modal">{{$last_bid_date}}</a>
                            <script>
                                $('.bid_edit_<?= $bid->r_id ?>').bind('click', function () {
                                $('.modal-body').html('');
                                $('.modal-body').load('{{ route('bid_edit',['r_id' => $bid->r_id]) }} .panel-body', function(){
                                $('.selectpicker').each(function(){
                                $(this).selectpicker('refresh');
                                })
                                });
                                $('.modal-title').html('Заявка №<?= $bid->r_id ?>');
                                });
                            </script>
                            <?php
                        }
                        ?>
                    </div>
                    <h2>Опрос</h2>
                    <?php $count = 0; ?>
                    @Foreach($questions as $question)
                    <?php
                    $answers = $answers_class->get_A_by_Q($question->q_id);
                    if ($count <> 0) {
                        ?>
                        <div class="list-group-item hide answer_div" q_id="{{$question->q_id}}" level="<?= $count ?>">
                            <?php
                        } else {
                            ?>
                            <div class="list-group-item answer_div" q_id="{{$question->q_id}}" level="<?= $count ?>">
                            <?php } ?>
                            <h3>{{$question->question_text}}?</h3>
                            @Foreach ($answers as $answer)
                            <?php
                            if ($answer->type == 'input') {
                                ?>
                                <input <?= $answer->answer_text ?> />
                            <?php } else { ?>
                                <a role="button" class="btn btn-warning answer" href="#" q_id="{{$question->q_id}}" a_id="{{$answer->a_id}}" q_next_id="{{$answer->q_next_id}}">{{$answer->answer_text}}</a>
                            <?php } ?>
                            @Endforeach
                        </div>
                        <?php $count++ ?>
                        @Endforeach
                        <br /><a role="button" class="btn btn-primary send_results">Сохранить</a>
                        <script>
                            $('a.send_results').bind('click', function () {
                            var id = '<?= $id ?>';
                            var user_id = <?= $user_data->u_id ?>;
                            var comment = $('input[name=comment]').val();
                            var status = '';
                            var return_data = 'Что-то пошло не так';
                            $.ajax({
                            type: 'GET',
                                    url: '<?= route('birthday_pool_data_delete') ?>',
                                    data: {pool_id: id},
                                    success: function (data) {
                                    $('.btn-info').each(function () {
                                    var q_id = $(this).attr('q_id');
                                    var a_data = $(this).html();
                                    var status = '0';
                                    $(this).removeClass('btn-info');
                                    $(this).addClass('btn-warning');
                                    // Проверка на хороший статус этого опроса

                                    // ---------------------------------------
                                    //alert(a_data);
                                    $.ajax({
                                    type: 'GET',
                                            url: '<?= route('birthday_pool_data') ?>',
                                            data: {pool_id: id, user_id: user_id, q_id: q_id, a_data: a_data, status: status},
                                            success: function (data) {
                                            if (q_id === '1' && a_data === 'Нет')
                                            {
                                            status = '1_not_call';
                                            }
                                            if (q_id === '2' && a_data === 'Да')
                                            {
                                            status = '3_ok';
                                            }
                                            if (q_id === '2' && a_data === 'Нет')
                                            {
                                            status = '2_not_congrat';
                                            }
                                            if (status != '0')
                                            {
                                            $.ajax({
                                            type: 'GET',
                                                    url: '<?= route('birthday_pool_status') ?>',
                                                    data: {pool_id: id, status: status},
                                                    success: function (data) {
                                                    //alert('Good: ' + data);
                                                    //return_data = 'Результаты опроса сохранены';
                                                    },
                                                    error: function (data) {
                                                    //alert('Bad: ' + data);
                                                    }
                                            });
                                            }
                                            },
                                            error: function (data) {
                                            // alert('Bad: ' + data);
                                            }
                                    });
                                    //alert(a_data);
                                    })
                                            //alert(return_data);
                                            if (comment.length > 0)
                                    {
                                    var status = '';
                                    var q_id = $('input[name=comment]').closest('.answer_div').attr('q_id');
                                    $.ajax({
                                    type: 'GET',
                                            url: '<?= route('birthday_pool_data') ?>',
                                            data: {pool_id: id, user_id: user_id, q_id: q_id, a_data: comment, status: status},
                                            success: function (data) {
                                            //alert('Good: ' +data);
                                            //location.reload();
                                            },
                                            error: function (data) {
                                            //alert('Bad: ' + data);
                                            }
                                    });
                                    }
                                    },
                                    error: function (data) {
                                    alert('Bad: ' + data);
                                    }
                            });
                            //location.reload();
                            })
                        </script>
                        <script>
                                    $(document).ready(function () {
                            $('a.answer').bind('click', function () {
                            $(this).siblings('a.answer').removeClass('btn-info');
                            $(this).siblings('a.answer').addClass('btn-warning');
                            $(this).removeClass('btn-warning');
                            $(this).addClass('btn-info');
                            var start_level = $(this).closest('.answer_div').attr('level');
                            var q_next_id = $(this).attr('q_next_id');
                            var end_level = $('[q_id = ' + q_next_id + ']').attr('level');
                            if ($(this).attr('q_next_id') != 0) {
                            $('.answer_div').each(function () {
                            if ($(this).attr('q_id') == q_next_id)
                            {
                            $(this).removeClass('hide');
                            }
                            if ($(this).attr('level') > start_level && $(this).attr('level') < end_level || $(this).attr('level') > end_level)
                            {
                            $(this).addClass('hide');
                            }
                            })
                            }
                            })
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
