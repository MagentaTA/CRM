@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование обращения</div>
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
                        <div class="table_list" id="tabs-1">
                            <table>
                                <tr>
                                    <td>{{ Form::label('status','Статус: ')}}</td>
                                    <td>{{ Form::text('status', $bid->r_status) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('dat','Дата: ')}}</td>
                                    <td>{{ Form::text('dat', $bid->r_dat) }}</td>
                                </tr>
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
                                    <td>{{ Form::label('uon_name','Источник: ')}}</td>
                                    <td>{{ Form::text('uon_name', $bid->uon_name) }}</td>
                                </tr>
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
        </div>
    </div>
</div>
@endsection
