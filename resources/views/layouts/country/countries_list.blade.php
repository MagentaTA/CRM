@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Список Стран</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table_list">
                        <th>Страна</th>
                        <th>Страна EN</th>
                        @foreach ($countries as $country)
                        <tr>
                            <td>{{ $country->uon_name }}</td>
                            <td>{{ $country->uon_name_en }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $countries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
