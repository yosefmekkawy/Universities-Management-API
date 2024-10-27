<?php

namespace App\Http\Controllers;

use App\Actions\DeleteFileFromPublic;
use App\Http\Requests\DeleteFormRequest;
use App\Models\Images;
use App\Services\Messages;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DeleteFormRequest $request)
    {
        //DB :: table(request('model_name'))->where('id' ,'=',request('id'))->delete();
        if (request('model_name') == 'Images') {
            $image = Images::query()->find(request('id'));
            $image->delete();
            DeleteFileFromPublic::delete('images', $image->name);
        }
        else {
                $item = ('App\Models\\' . request('model_name'))::query()->find(request('id'));
                $item->delete();
        }
        return Messages::success([],__('messages.deleted_successfully'));
    }
}
