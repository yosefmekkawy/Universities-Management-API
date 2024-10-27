<?php

namespace App\Http\Controllers;

use App\Actions\HandleDataBeforeSaveAction;
use App\Filter\EndDateFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\SubjectIdFilter;
use App\Http\Requests\GovernmentFormRequest;
use App\Http\Resources\GovernmentResource;
use App\Models\Government;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class GovernmentControllerResource extends Controller
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
//        $data = Government::query();
//        if(request()->filled('filter_name')){
//            $data->where('name', 'like', '%'.request('filter_name').'%');
//        }
//        if(request()->filled('filter_start_date')){
//            $data->where('created_at', '>=',request('filter_start_date'));
//        }
//        if(request()->filled('filter_end_date')){
//            $data->where('created_at', '<=',request('filter_end_date'));
//        }
//        return $data->get();
////////////////////////////////instead of repeat ->
        $data = Government::query();
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                SubjectIdFilter::class
            ])
            ->thenReturn()
            ->get();
        return GovernmentResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        $output = Government::query()->updateOrCreate([
            'id'=> $data['id'] ?? null
        ],$data);
//        return Messages::success($output,__('messages.saved_successfully'));
        return Messages::success(GovernmentResource::make($output),__('messages.saved_successfully'));
    }
    public function store(GovernmentFormRequest $request)
    {
        $data = $request->validated();
        $handled_data = HandleDataBeforeSaveAction::handle($data);
//        return $handled_data;
//        Government::query()->create($handled_data);
        return $this->save($handled_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Government::query()->findOrFail($id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GovernmentFormRequest $request, string $id)
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
