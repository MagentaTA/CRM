@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in!<br />
                    <a href="{{ route('client_add') }}">Добавить клиента</a>
                    @if ($view == 'client_add')
                        @include('layouts.forms.client_add')
                    @endif
                    @if ($view == 'client_create')
                        Добавлен! Клиент {{ $name }}
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
