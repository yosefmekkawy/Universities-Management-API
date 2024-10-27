<?php

namespace App\Actions;

use App\Models\Images;

class DisplayDateWithCurrentLang
{
    public static function display($data)
    {
        $result = json_decode($data,true);
        return $result[app()->getLocale()] ?? null; // if field has no value return null
    }

}
