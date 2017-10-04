@extends('layouts.app')
@section('content')
<!-- Модальное окно -->
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
                    <div class="list-group-item">
                        <span class="oi oi-person" title="ФИО Клиента" aria-hidden="true"></span> {{$user_data->u_surname}} {{$user_data->u_name}} {{$user_data->u_sname}}<br />
                        <span class="oi oi-phone" title="Телефон клиента" aria-hidden="true"></span> <b>{{$user_data->u_phone_mobile}}, {{$user_data->u_phone}}</b><br />
                        <span class="oi oi-chat" title="E-Mail" aria-hidden="true"></span> {{$user_data->u_email}}
                        <h3>Менеджер</h3>
                        {{ Form::label('manager','Менеджер: ') }}
                        <?php
                        $managers = GuzzleHttp\json_decode($managers, TRUE);
                        ?>
                        {{ Form::select('manager', $managers, $user_data->manager_id, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) }}
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
                                var pool_id = <?= $pool_id ?>;
                                var user_id = <?= $user_data->u_id ?>;
                                var comment = $('input[name=comment]').val();
                                $('a.btn-info').each(function () {
                                    var q_id = $(this).attr('q_id');
                                    var a_data = 1;
                                    //alert(a_data);
                                    $.ajax({
                                        type: 'GET',
                                        url: '<?= route('birthday_pool_data') ?>',
                                        data: {pool_id: pool_id, user_id: user_id, comment: comment, q_id: q_id, a_data: a_data},
                                        success: function (data) {
                                            alert(data);
                                        },
                                        error: function () {
                                            alert('error')
                                        }
                                    });
                                    //alert(a_data);
                                })
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
