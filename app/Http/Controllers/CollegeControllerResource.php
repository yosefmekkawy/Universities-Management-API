<?php

namespace App\Http\Controllers;

use App\Actions\HandleDataBeforeSaveAction;
use App\Filter\EndDateFilter;
use App\Filter\GovernmentIdFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\SubjectIdFilter;
use App\Http\Requests\CollegeFormRequest;
use App\Http\Resources\CollegeResource;
use App\Models\College;
use App\Models\colleges_years;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class CollegeControllerResource extends Controller
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
        $data = College::query()->with('government')
        ->with(
//            'years',function ($e){
//            $e->with('year');
//        }
//                'years.year'
                'years'
        );
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                SubjectIdFilter::class,
                GovernmentIdFilter::class,
            ])
            ->thenReturn()
            ->get();
//        return $result;
        return CollegeResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        DB::beginTransaction();
        $data['years_ids'] = json_decode($data['years_ids'],true);
//        dd($data['years_ids']);
        $output = College::query()->updateOrCreate([
            'id'=> $data['id'] ?? null
        ],$data);
        // method 1
//        foreach ($data['years_ids'] as $year) { //id , //year_id
//            colleges_years::query()->updateOrCreate([
//                'id'=> $year['id'] ?? null
//            ],[
//                'college_id'=>$output->id,
//                'year_id'=>$year['year_id'],
//            ]);
//        }
        // method 2
//        colleges_years::query()
//            ->where('college_id','=',$output->id)
//            ->delete();
//        foreach ($data['years_ids'] as $year) { //id , //year_id
//            colleges_years::query()->create([
//                'college_id'=>$output->id,
//                'year_id'=>$year,
//            ]);
//        }
        //method 3 (the best)
        $output->years()->sync($data['years_ids']);
        $output->load('government');
        DB::commit();
//        return Messages::success($output,__('messages.saved_successfully'));
        return Messages::success(CollegeResource::make($output),__('messages.saved_successfully'));
    }
    public function store(CollegeFormRequest $request)
    {
        $data = $request->validated();
//        dd($data);
        $handled_data = HandleDataBeforeSaveAction::handle($data);
//        return $handled_data;
//        College::query()->create($handled_data);
        return $this->save($handled_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = College::query()->findOrFail($id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CollegeFormRequest $request, string $id)
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
