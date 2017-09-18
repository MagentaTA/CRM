@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Источники заявок</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table_list">
                        <th>ID</th>
                        <th>Значение</th>
                        @if ($sourses)
                        @foreach ($sourses as $sourse)
                        <tr>
                            <td>{{ $sourse->uon_id }}</td>
                            <td>{{ $sourse->uon_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $sourses->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
