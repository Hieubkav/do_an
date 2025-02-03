<?php

namespace App\Helpers;

class Support
{
    public static function change_date($date)
    {
        $newDate = date("d-m-Y H:i:s", strtotime($date));

        return $newDate;
    }
    public static function change_vnd($vnd)
    {
        $formatted = number_format($vnd, 0, ',', '.') . ' vnd';
        return $formatted;  
    }
    public static function pre_array($array){
        echo "<pre>";
        echo $array;
        echo "</pre>";
    }
}
