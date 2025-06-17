<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rooms as Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
class RoomController extends Controller
{
    public function index()
    { 
        $redisKey = 'rooms';
        if (Redis::exists($redisKey)) {
            $data = json_decode(Redis::get($redisKey), true);
        } else {
            $data =  Event::latest()->get()->groupBy("category");
            Redis::set($redisKey, json_encode($data));
        }
        return response()->json([
            "service" => "room",
            "event" => "list",
            "data" => $data
        ], 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'image_url' => 'nullable|url',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'team_a' => 'required|string',
            'team_b' => 'required|string',
            'commentator' => 'nullable|string',
            'is_live' => 'boolean',
            'is_hot' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $event = Event::create($validator->validated());
        return response()->json([
            "service" => "room",
            "event" => "created",
            "data" => $event
        ], 201);
    }

    public function show($id)
    {
        return response()->json(Event::find($id));
    }

    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'image_url' => 'nullable|url',
            'category' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'team_a' => 'required|string',
            'team_b' => 'required|string',
            'commentator' => 'nullable|string',
            'is_live' => 'boolean',
            'is_hot' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event->update($validator->validated());

        return response()->json([
            "service" => "room",
            "event" => "created",
            "data" => $event
        ], 201);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
