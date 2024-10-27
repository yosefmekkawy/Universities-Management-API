<?php

namespace App\Actions;

use App\Models\Language;
use Illuminate\Support\Str;

class HandleRulesValidation
{
    public static function handle($basic,$langs_data)
    {
//        $langs = Language::query()->select('prefix')
//            ->get()->map(function ($lang) {
//                return $lang->prefix;
//            });
        $langs = Language::query()->pluck('prefix'); // [ar,en]
//        dd($langs);
        foreach ($langs as $lang) {
            foreach ($langs_data as $data) { // [name:required, info:nullable]
//                $basic[$lang.'_'.$data] = 'required';
                $name =Str::before($data,':'); // name
                $validation =Str::after($data,':'); // required
                $basic[$lang.'_'.$name] = $validation;
            }
        }
//        dd($basic);
        return $basic;

    }

}
