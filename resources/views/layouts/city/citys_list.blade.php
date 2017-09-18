@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Список Городов</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table_list">
                        <th>Город</th>
                        <th>Город EN</th>
                        @foreach ($citys as $city)
                        <tr>
                            <td>{{ $city->uon_name }}</td>
                            <td>{{ $city->uon_name_en }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $citys->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
