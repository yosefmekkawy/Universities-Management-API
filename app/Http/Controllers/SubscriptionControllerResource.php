<?php

namespace App\Http\Controllers;

use App\Actions\HandleDataBeforeSaveAction;
use App\Filter\EndDateFilter;
use App\Filter\StartDateFilter;
use App\Filter\SubjectIdFilter;
use App\Filter\UserIdFilter;
use App\Http\Requests\SubscriptionFormRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class SubscriptionControllerResource extends Controller
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
        $data = Subscription::query()
        ->with('user')
        ->with('subject')
        ;
        $result = app(Pipeline::class)
            ->send($data)
            ->through([
                StartDateFilter::class,
                EndDateFilter::class,
                UserIdFilter::class,
                SubjectIdFilter::class,
            ])
            ->thenReturn()
            ->get();
//        return $result;
        return SubscriptionResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save($data)
    {
        $output = Subscription::query()->updateOrCreate([
            'id'=> $data['id'] ?? null
        ],$data);
        $output -> load('user');
        $output -> load('subject');
        return Messages::success(SubscriptionResource::make($output),__('messages.saved_successfully'));
    }
    public function store(SubscriptionFormRequest $request)
    {
        $data = $request->validated();
        return $this->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Subscription::query()
            ->with(['user','year'])
            ->findOrFail($id);
        return SubscriptionResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionFormRequest $request, string $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        return $this->save($data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
