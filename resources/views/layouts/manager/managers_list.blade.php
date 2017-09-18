@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Сотрудники</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table_list">
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Телефон</th>
                        <th>E-Mail</th>
                        @foreach ($managers as $manager)
                        <tr>
                            <td>{{ $manager->u_surname }}</td>
                            <td>{{ $manager->u_name }}</td>
                            <td>{{ $manager->u_sname }}</td>
                            <td>{{ $manager->u_phone }}</td>
                            <td>{{ $manager->u_email }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $managers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
