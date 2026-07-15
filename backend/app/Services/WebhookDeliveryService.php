<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Http;

class WebhookDeliveryService
{
    public function deliver(Event $event): bool
    {
        $response = Http::timeout(5)->post(
            $event->endpoint_url,
            $event->payload
        );

        return $response->successful();
    }
}