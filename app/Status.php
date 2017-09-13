<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    public function get_text_name($status_id) {
        $_text_status = new \UON\Statuses();
        $text_status = $_text_status->get();
        $text_status = \GuzzleHttp\json_encode($text_status);
        $text_status = \GuzzleHttp\json_decode($text_status);
        $text_status = $text_status->message->records;
        foreach ($text_status as $status_array) {
            if ($status_array->id == $status_id)
            {
                $return_text = $status_array->name;
            }
        }
        return isset($return_text) ? $return_text : FALSE;
    }

}
