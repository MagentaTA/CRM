@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Обращения</div>
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
                        @foreach ($leads as $lead)
                        <tr>
                            <td>{{ $lead->l_id }}</td>
                            <td>{{ $lead->l_dat }}</td>
                            <td>{{ $lead->l_date_begin }}</td>
                            <td>{{ $lead->l_date_end }}</td>
                            <td>
                                {{ $lead->u_surname }} {{ $lead->u_name }} {{ $lead->u_sname }} 
                            </td>
                            <td>{{ $lead->l_status }}</td>
                            <td>{{ $lead->uon_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $leads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
