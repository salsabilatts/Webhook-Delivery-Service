<?php

namespace App\Jobs;

use App\Models\Event;
use App\Services\WebhookDeliveryService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeliverWebhookJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;

    public function __construct(
        public Event $event
    ) {}

    public function backoff(): array
    {
        return [1, 2, 4, 8, 16];
    }

    public function handle(WebhookDeliveryService $service): void
    {
        $this->event->refresh();

        $this->event->increment('attempts');

        if ($service->deliver($this->event)) {

            $this->event->update([
                'status' => 'delivered',
                'last_error' => null,
            ]);

            return;
        }

        throw new Exception('Webhook delivery failed.');
    }

    public function failed(?Exception $exception): void
    {
        $this->event->refresh();

        $this->event->update([
            'status' => 'failed',
            'last_error' => $exception?->getMessage(),
        ]);
    }
}