<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Services\Messages;

class RegisterRepository
{
    public static function create_user($data)
    {
        if(!(isset($data['password']))){
            $data['password'] = rand(0,999999);
        }
        User::query()->create($data);
        return Messages::success($data,'User created successfully');
    }

}
