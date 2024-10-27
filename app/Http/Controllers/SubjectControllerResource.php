<?php

namespace App\Http\Controllers;

use App\Actions\HandleDataBeforeSaveAction;
use App\Filter\EndDateFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\SubjectIdFilter;
use App\Filter\UserIdFilter;
use App\Filter\YearIdFilter;
use App\Http\Requests\SubjectFormRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class SubjectControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');
    }

    public function index()
    {
        $data = Subject::query()
        ->with('user')
        ->with('year', function ($e){
            $e->with(['year','college']);
        })
        ;
//        ->with(['user','year'=>function ($e){
//                $e->with(['year','college']);
//            }]);
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                UserIdFilter::class,
                YearIdFilter::class,
            ])
            ->thenReturn()
            ->get();
//        return $result;
        return SubjectResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        $output = Subject::query()->updateOrCreate([
            'id'=> $data['id'] ?? null
        ],$data);
        $output -> load('user');
        $output -> load('year');
        return Messages::success(SubjectResource::make($output),__('messages.saved_successfully'));
    }
    public function store(SubjectFormRequest $request)
    {
        $data = $request->validated();
        $handled_data = HandleDataBeforeSaveAction::handle($data);
//        return $handled_data;
        return $this->save($handled_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Subject::query()
            ->with(['user','year'])
            ->findOrFail($id);
        return SubjectResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectFormRequest $request, string $id)
    {
        $data = $request->validated();
        $handled_data = HandleDataBeforeSaveAction::handle($data);
        $handled_data['id'] = $id;
        return $this->save($handled_data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
