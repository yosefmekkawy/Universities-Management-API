<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Services\Messages;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */

//    public function __construct()
//    {
//        $this->middleware('auth:sanctum');
//    }
    public function __invoke(UserFormRequest $request)
    {
//        dd('token sent');
        $credentials = ['phone' => request('phone'), 'password' => request('password')];
        if (auth()->attempt($credentials)) { //auth()->attempt($credentials) returns 0 or 1
//            dd(auth()->user());  // -> instance of User model
            $data = auth()->user();
            $data['token'] = auth()->user()->createToken($data['phone'])->plainTextToken;
            return Messages::success(UserResource::make($data),'Logged in successfully');
         }
        else{
            return Messages::error('Login Failed');
        }
    }
}
