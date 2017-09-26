<?php
require_once './vendor/drteam/uon/src/Requests.php';
$request_data = new \UON\Requests();
$request = $request_data->get(19641);
var_dump($request);