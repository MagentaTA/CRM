@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование клиента</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div id="client_tabs">
                        <ul>
                            <li><a href="#tabs-1">Основные</a></li>
                            <li><a href="#tabs-2">Пасспорт</a></li>
                            <li><a href="#tabs-3">Визы</a></li>
                            <li><a href="#tabs-4">Файлы</a></li>
                            <li><a href="#tabs-5">Бонусы</a></li>
                            <li><a href="#tabs-6">История туров</a></li>
                            <li><a href="#tabs-7">История общения</a></li>
                            <li><a href="#tabs-8">История Звонков</a></li>
                        </ul>                        

                        {{ Form::open(array('url' => route('client_create'), 'method' => 'post')) }}
                        <div class="clients_table_list" id="tabs-1">
                            <table>
                                <tr>
                                    <td>{{ Form::label('surname','Фамилия: ')}}</td>
                                    <td>{{ Form::text('surname', $user->u_surname) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('name','Имя: ')}}</td>
                                    <td>{{ Form::text('name', $user->u_name) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('sname','Отчество: ')}}</td>
                                    <td>{{ Form::text('sname', $user->u_sname) }}</td>
                                </tr>
                                <tr>
                                    <?php
                                    $date_b = new App\myDate();
                                    $b_date = $date_b->getBirthdayDate($user->u_birthday);
                                    ?>
                                    <td>{{ Form::label('birthday','День рождения: ')}}</td>
                                    <td>{{ Form::text('birthday', $b_date) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('fax','Телефон: ')}}</td>
                                    <td>{{ Form::text('fax', $user->u_fax) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('phone','Домашний телефон: ')}}</td>
                                    <td>{{ Form::text('phone', $user->u_phone) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('phone_mobile','Мобильный телефон: ')}}</td>
                                    <td>{{ Form::text('phone_mobile', $user->u_phone_mobile) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('email','E-Mail: ')}}</td>
                                    <td>{{ Form::text('email', $user->u_email) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('note','Примечания: ')}}</td>
                                    <td>{{ Form::textarea('note', $user->u_note) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('social_vk','Ссылка VK: ')}}</td>
                                    <td>{{ Form::text('social_vk', $user->u_social_vk) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('social_fb','Ссылка FB: ')}}</td>
                                    <td>{{ Form::text('social_fb', $user->u_social_fb) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('social_ok','Ссылка OK: ')}}</td>
                                    <td>{{ Form::text('social_ok', $user->u_social_ok) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('social_viber','Ссылка Viber: ')}}</td>
                                    <td>{{ Form::text('social_viber', $user->u_social_viber) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('social_watsup','Ссылка WatsUp: ')}}</td>
                                    <td>{{ Form::text('social_watsup', $user->u_social_watsup) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('social_telegram','Ссылка Telegram: ')}}</td>
                                    <td>{{ Form::text('social_telegram', $user->u_social_telegram) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="clients_table_list" id="tabs-2">
                            <table>
                                <tr><td colspan="2">Заграничный пасспорт</td></tr>
                                <tr>
                                    <td>{{ Form::label('name_en','Имя: ')}}</td>
                                    <td>{{ Form::text('name_en', $user->u_name_en) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('surname_en','Фамилия: ')}}</td>
                                    <td>{{ Form::text('surname_en', $user->u_surname_en) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('passport_number','Серия и номер: ')}}</td>
                                    <td>{{ Form::text('passport_number', $user->u_passport_number) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('zagran_given','Дата выдачи: ')}}</td>
                                    <td>{{ Form::text('zagran_given', $user->u_zagran_given) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('zagran_expire','Дата действия: ')}}</td>
                                    <td>{{ Form::text('zagran_expire', $user->u_zagran_expire) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('zagran_organization','Организация: ')}}</td>
                                    <td>{{ Form::text('zagran_organization', $user->u_zagran_organization) }}</td>
                                </tr>
                                <tr><td colspan="2">Украинский пасспорт</td></tr>
                                <tr>
                                    <td>{{ Form::label('passport_number','Серия и номер: ')}}</td>
                                    <td>{{ Form::text('passport_number', $user->u_passport_number) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('passport_date','Дата выдачи: ')}}</td>
                                    <td>{{ Form::text('passport_date', $user->u_passport_date) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('passport_taken','Кем выдан: ')}}</td>
                                    <td>{{ Form::textarea('passport_taken', $user->u_passport_taken) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Form::label('address','Адрес регистрации: ')}}</td>
                                    <td>{{ Form::textarea('address', $user->address) }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="clients_table_list" id="tabs-7">
                            <table>
                                <tr><td colspan="2">История общения</td></tr>
                                <tr><td colspan="2">Список обращений</td></tr>
                            </table>
                        </div>

                    </div>

                    {{ Form::close() }}
                    <script>
                        $(function () {
                            $('#client_tabs').tabs();
                            $('[name="birthday"]').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: 'dd.mm.yy'
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
