@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Список Отелей</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table_list">
                        <th>Название</th>
                        <th>Название EN</th>
                        <th>Звёздность</th>
                        <th>Страна</th>
                        <th>Город</th>
                        @foreach ($hotels as $hotel)
                        <tr>
                            <td>{{ $hotel->uon_name }}</td>
                            <td>{{ $hotel->uon_name_en }}</td>
                            <td>{{ $hotel->uon_stars }}</td>
                            <td>{{ $hotel->uon_country }}</td>
                            <td>{{ $hotel->uon_city }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $hotels->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
