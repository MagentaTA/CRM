@extends('layouts.app')
@section('content')
<?php
$norm_date = new App\myDate();
$bids = new \App\Helper();
?>
<!-- Модальное окно -->
<div class="modal fade" id="bid_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:90rem;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Именинники</div>

                <div class="panel-body">
                    <div class="list-group">
                        @foreach ($Birthdays as $Birthday)
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="user_edit_{{$Birthday->u_id}}" data-toggle="modal" data-target="#bid_modal" style="cursor: pointer;">{{$Birthday->u_surname}} {{$Birthday->u_name}} {{$Birthday->u_sname}}</a>
                                    <script>
                                        $('.user_edit_<?= $Birthday->u_id ?>').bind('click', function () {
                                            $('.modal-body').html('');
                                                    $('.modal-body').load('{{ route('client_edit',['u_id' => $Birthday->u_id]) }} .panel-body');
                                            $('.modal-title').html('Турист №<?= $Birthday->u_id ?>');
                                        });
                                    </script>
                                </div>
                                <div class="col-md-2">
                                    <?php
                                    $b_date = $Birthday->u_birthday;
                                    $b_date = $norm_date->getBirthdayDate($b_date);
                                    $age = date('Y') - date('Y', strtotime($b_date));
                                    ?>
                                    {{$b_date}} (<b>{{$age}}</b>)
                                </div>
                                <div class="col-md-2">
                                    {{$Birthday->u_phone}} {{$Birthday->u_phone_mobile}}
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    $bids_data = $bids->getBidDataByUser($Birthday->u_id);
                                    foreach ($bids_data as $bid) {
                                        //var_dump($bid).'<br />';
                                        $last_bid_date = $norm_date->getNormalDateTime($bid->r_dat);
                                        ?>
                                        <a class="btn btn-primary bid_edit_{{$bid->r_id}}" role="button" data-toggle="modal" data-target="#bid_modal">{{$last_bid_date}}</a>
                                        <script>
                                            $('.bid_edit_<?= $bid->r_id ?>').bind('click', function () {
                                                $('.modal-body').html('');
                                                        $('.modal-body').load('{{ route('bid_edit',['r_id' => $bid->r_id]) }} .panel-body');
                                                $('.modal-title').html('Заявка №<?= $bid->r_id ?>');
                                            });
                                        </script>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-2">
                                    <?php
                                    $Birthday_call_id = $Birthday->u_id . '_' . date('dmY');
                                    ?>
                                    <a href="{{route('birthday_call',['id' => $Birthday_call_id, 'opros_id' => 1, 'user_id' => $Birthday->u_id])}}"><span class="oi oi-phone call_button {{$Birthday_call_id}}" title="Начать прозвон" aria-hidden="true" style="cursor: pointer;"></span></a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
