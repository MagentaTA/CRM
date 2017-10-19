<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CRM MAKiNTOUR') }}</title>

        <!-- Styles -->
        <link href="{{ elixir('css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/open-iconic-master/font/css/open-iconic-bootstrap.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" />
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ elixir('js/all.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
        <script src="{{ asset('js/moments.js') }}"></script>
        <script src="{{ asset('js/datetimepicker.js') }}"></script>
    </head>
    <body>
        <?php
        $start = microtime(true);
        $d = new DateTime($start_date);
        $d->modify("+1 day");
        $end_date = $d->format("Y-m-d");
        $date_norm = new App\myDate();
        $start_date_d = $date_norm->getNormalDate($start_date);
        $end_date_d = $date_norm->getNormalDate($end_date);
        $to_date_d = $date_norm->getNormalDate($to_date);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="card text-center">
                        <img class="card-img-top" src="/public/images/template/skeleton-opt.png" style="max-width: 30rem; width: auto; height: auto;" />
                        <div class="card-header"><h2>Please Wait...</h2><br /><h3>Выгружаем заявки за период...</h3></div>
                        <div class="card-body">
                            <?php
                            echo '<div class="dates_diapazon">';
                            echo '<span class="start_date"><b>' . $start_date_d . '</b></span> - <span class="end_date"><b>' . $end_date_d . '</b> по ('.$to_date_d.')</span><br />';
                            $ch = curl_init();

// установка URL и других необходимых параметров

                            curl_setopt($ch, CURLOPT_URL, route('all_requests', ['start_date' => $start_date, 'end_date' => $end_date]));
                            curl_setopt($ch, CURLOPT_HEADER, false);

// загрузка страницы и выдача её браузеру
                            echo '<button class="btn btn-lg btn-warning"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></button>';
                            curl_exec($ch);

// завершение сеанса и освобождение ресурсов
                            curl_close($ch);
                            ?>
                            <?php
                            $time = microtime(true) - $start;
                            echo '<br><font style="color:green; font-weight:bold;">';
                            printf('Скрипт выполнялся %.4F сек.', $time);
                            echo '</font>';
                            header("Refresh: 1;" . route('ParseBidsByDate'));
                            echo '</div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>