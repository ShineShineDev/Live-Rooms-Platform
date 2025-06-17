<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionList;
use Illuminate\Support\Facades\Validator;
use App\Services\RabbitMQService;

class SubscriptionController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:customers,id',
            'room_id' => 'required|numeric|exists:rooms,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $exists = SubscriptionList::where('user_id', $request->user_id)
            ->where('room_id', $request->room_id)
            ->exists();
        if ($exists) {
            return response()->json([
                'code' => -1,
                'message' => 'This user is already subscribed to the room.'
            ], 200);
        }
        $event = SubscriptionList::create($validator->validated());
        $rabbit = new RabbitMQService();
        $rabbit->publish('data_bridge', '', json_encode($event));
        return response()->json([
            "code" => 1,
            "message" => "Subscribed Successfully",
            "service" => "subscription",
            "event" => "subscribed",
            "data" => $event
        ], 201);
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $events = SubscriptionList::with('room')
            ->where('user_id', $request->user_id)
            ->get()
            ->groupBy(function ($item) {
                return $item->room->category ?? 'Unknown';
            });

        return response()->json([
            "service" => "subscription",
            "event" => "subscribed",
            "data" => $events
        ], 201);
    }

    public function show($id)
    {
        return response()->json(SubscriptionList::find($id));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:customers,id',
            'room_id' => 'required|numeric|exists:rooms,id',
            'status' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return response()->json([
            "service" => "subscription",
            "event" => "updated",
            "data" => null
        ], 201);
    }
}
