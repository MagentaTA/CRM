@extends('layouts.app')

@section('content')
<?php
$date_norm = new App\myDate();
?>
<div class="panel panel-default">
    <div class="panel-heading">Заявки</div>
    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <table class="table_list table">
            <th>Номер</th>
            <th>Дата</th>
            <th>Дата начала</th>
            <th>Дата конца</th>
            <th>Клиент</th>
            <th>Статус</th>
            <th>Источник</th>
            <th>Действия</th>
            @foreach ($bids as $bid)
            <tr>
                <td>{{ $bid->r_id }}</td>
                <?php
                $date = $date_norm->getNormalDate($bid->r_dat);
                $date_begin = $date_norm->getNormalDate($bid->r_date_begin);
                $date_end = $date_norm->getNormalDate($bid->r_date_end);
                ?>                
                <td>{{ $date }}</td>
                <td>{{ $date_begin }}</td>
                <td>{{ $date_end }}</td>
                <td>
                    {{ $bid->u_surname }} {{ $bid->u_name }} {{ $bid->u_sname }} 
                </td>
                <td>{{ $bid->r_status }}</td>
                <td>{{ $bid->uon_name }}</td>
                <td><a href="{{ route('bid_edit',['r_id' => $bid->r_id]) }}"><span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></span>
                    </a></td>
            </tr>
            @endforeach
        </table>
        {{ $bids->links() }}
    </div>
</div>
</div>
@endsection
