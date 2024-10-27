<?php

namespace App\Actions;

use App\Models\Language;
use Illuminate\Support\Str;

class HandleDataBeforeSaveAction
{
    public static function handle($data)
    {
//        $data['price'] = 100;
        $langs = Language::query()->pluck('prefix');
        $output=[];
//        dd($data);
        foreach($data as $key=>$value){
            $lang_exist_at_input = 0;
            foreach($langs as $lang){
//                if(Str::contains($key,$lang.'_')){
                if(Str::startsWith($key,$lang.'_')){
                    $input_name = Str::replace($lang,'',$key);
                    $input_name = Str::replace('_','',$input_name);
                    $output[$input_name][$lang]=$value;
                    $lang_exist_at_input = 1;
                }
            }
            if($lang_exist_at_input == 0){
                $output[$key] = $value ;
            }
        }
        foreach ($output as $key => $value) {
            if(is_array($value)){
                $output[$key] = json_encode($value,JSON_UNESCAPED_UNICODE);
            }
        }
//        dd($output);
        return $output;






    }



}
