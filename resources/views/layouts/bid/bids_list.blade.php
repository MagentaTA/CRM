@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Заявки</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table_list">
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Дата начала</th>
                        <th>Дата конца</th>
                        <th>Клиент</th>
                        <th>Статус</th>
                        <th>Источник</th>
                        @foreach ($bids as $bid)
                        <tr>
                            <td>{{ $bid->r_id }}</td>
                            <td>{{ $bid->r_dat }}</td>
                            <td>{{ $bid->r_date_begin }}</td>
                            <td>{{ $bid->r_date_end }}</td>
                            <td>
                                {{ $bid->u_surname }} {{ $bid->u_name }} {{ $bid->u_sname }} 
                            </td>
                            <td>{{ $bid->r_status }}</td>
                            <td>{{ $bid->uon_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $bids->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
