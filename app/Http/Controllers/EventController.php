<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use ErrorHandler;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');    
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);

        $events  = Event::orderBy('created_at')->paginate($limit);

        return EventResource::collection($events)->additional([
            'success' => true,
            'total' => $events->total(),
            'code' => 206
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = new Event();

        $event->name = $request->name;
        $event->price = $request->price;
        $event->location = $request->location;
        $event->description = $request->description;
        $event->schedule = json_encode($request->schedule);
        $event->location_description = $request->location_description;
        $event->rules = $request->rules;
        $event->organization_id = auth('sanctum')->user()->organization_id;

        if($event->save()) {
            return (new EventResource($event))
                ->additional($this->additionalResource($event));
        }

        return ErrorHandler('Gagal menyimpan event', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = Event::find($id);

        $event->name = $request->name;
        $event->price = $request->price;
        $event->location = $request->location;
        $event->description = $request->description;
        $event->schedule = json_encode($request->schedule);
        $event->location_description = $request->location_description;
        $event->rules = $request->rules;

        if($event->save()) {
            return (new EventResource($event))
                ->additional($this->additionalResource($event));
        }

        return ErrorHandler::errorResource('Gagal menyimpan event', 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if($event->delete()) {
            return [
                'success' => true,
                'code' => 200
            ];
        }

        return ErrorHandler('Gagal menghapus event', 400);
    }
}
