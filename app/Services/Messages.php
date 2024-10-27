<?php

namespace App\Services;

class Messages
{
    public static function success($data=[],$msg='')
    {
        return response()->json(['message'=>$msg,'data'=>$data]);
    }
    public static function error($msg='',$status=400)
    {
        return response()->json(['message'=>$msg],$status);
    }

}
