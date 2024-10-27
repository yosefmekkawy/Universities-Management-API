<?php

namespace App\Http\Controllers;

use App\Actions\HandleDataBeforeSaveAction;
use App\Filter\EndDateFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\SubjectIdFilter;
use App\Http\Requests\YearFormRequest;
use App\Http\Resources\YearResource;
use App\Models\Year;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class YearControllerResource extends Controller
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
        $data = Year::query();
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
        return YearResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        $output = Year::query()->updateOrCreate([
            'id'=> $data['id'] ?? null
        ],$data);
//        return Messages::success($output,__('messages.saved_successfully'));
        return Messages::success(YearResource::make($output),__('messages.saved_successfully'));
    }
    public function store(YearFormRequest $request)
    {
        $data = $request->validated();
        $handled_data = HandleDataBeforeSaveAction::handle($data);
//        return $handled_data;
//        Year::query()->create($handled_data);
        return $this->save($handled_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Year::query()->findOrFail($id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(YearFormRequest $request, string $id)
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
