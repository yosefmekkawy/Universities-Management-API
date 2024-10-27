<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Repositories\Auth\RegisterRepository;
use App\Services\Messages;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */

    private $repo;

    public function __construct(RegisterRepository $repo) //injecting the class to create instance
    {
        $this->repo = $repo;

    }
    public function __invoke(UserFormRequest $request)
    {
//        $data = $request->validated();
////        return $data;
////        return response()->json('user created successfully', 404);
//        if(!(isset($data['password']))){
//            $data['password'] = rand(0,999999);
//        }
//        User::query()->create($data);
////        return Messages::success([],'User created successfully');
//        return Messages::success($data,'User created successfully');

        return $this->repo->create_user($request->validated());


    }
}
