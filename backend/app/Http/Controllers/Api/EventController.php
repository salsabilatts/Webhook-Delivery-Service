<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Jobs\DeliverWebhookJob;

class EventController extends Controller
{
    public function store(StoreEventRequest $request)
    {
        $event = Event::create([
            'customer_id' => $request->customerId,
            'endpoint_url' => $request->endpoint,
            'payload' => $request->payload,
            'status' => 'pending',
            'attempts' => 0,
        ]);
        DeliverWebhookJob::dispatch($event);

        return response()->json([
            'id' => $event->id,
            'status' => 'pending',
        ], 201);
    }

    public function show(Event $event)
    {
        return response()->json([
            'id' => $event->id,
            'status' => $event->status,
            'attempts' => $event->attempts,
            'last_error' => $event->last_error,
        ]);
    }
}
