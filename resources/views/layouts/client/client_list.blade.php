@extends('layouts.app')

@section('content')
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
<div class="panel panel-default">
    <div class="panel-heading">Список клиентов
        <span class="seacrh_panel">
            {{ Form::open(array('url' => route('client_list'), 'method' => 'post')) }}
            {{ Form::label('search','Поиск: ')}}
            {{ Form::text('search', 'Строка поиска...') }}
            {{ Form::submit('Поиск') }}
            {{ Form::close() }}
        </span>
    </div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <table class="table table-bordered">
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Мобильный</th>
            <th>E-Mail</th>
            <th>День рождения</th>
            <th>Действия</th>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->u_surname }}</td>
                <td>{{ $user->u_name }}</td>
                <td>{{ $user->u_sname }}</td>
                <td>{{ $user->u_phone_mobile }}</td>
                <td>{{ $user->u_email }}</td>
                <td><?php
                    $date_b = new App\myDate();
                    $b_date = $date_b->getBirthdayDate($user->u_birthday);
                    echo $b_date;
                    ?>
                </td>
                <td><a class="user_edit_{{$user->u_id}}" data-toggle="modal" data-target="#bid_modal" style="cursor: pointer;"><span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></a>
                    <script>
                        $('.user_edit_<?= $user->u_id ?>').bind('click', function () {
                            $('.modal-body').html('');
                            $('.modal-body').load('{{ route('client_edit',['u_id' => $user->u_id]) }} .panel-body', function () {
                                $('#client_tabs').tabs();
                                $('input[name="birthday"]').datetimepicker({
                                    locale: 'ru',
                                    format: 'DD.MM.YYYY'
                                });
                                $('.confirm_dialog').bind('click', function () {
                                    $('form[name="client_change"]').submit();
                                })
                            });
                            $('.modal-title').html('Турист №<?= $user->u_id ?>');
                        });
                    </script>

            </tr>
            @endforeach
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
