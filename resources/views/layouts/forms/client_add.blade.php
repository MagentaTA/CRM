<?php
echo Form::open(array('url' => route('client_create'), 'method' => 'post'));
echo Form::label('surname','Фамилия: ');
echo Form::text('surname').'<br />';
echo Form::label('name','Имя: ');
echo Form::text('name').'<br />';
echo Form::label('sname','Отчество: ');
echo Form::text('sname').'<br />';
echo Form::label('phone_mobile','Мобильный: ');
echo Form::text('phone_mobile').'<br />';
echo Form::label('u_birthday','День рождения: ');
echo Form::text('u_birthday').'<br />';

echo Form::submit('Добавить');
echo Form::close();

