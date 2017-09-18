@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Список клиентов</div>
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
                            <td><a href="{{ route('client_edit',['id' => $user->u_id]) }}">Edit</a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
