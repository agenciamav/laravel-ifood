<?php

namespace Agenciamav\LaravelIfood\Controllers;

use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Agenciamav\LaravelIfood\Controllers\IfoodOrderEvent;
use Agenciamav\LaravelIfood\IfoodClient;

class OrderEvents
{
    use IfoodClient;
    public function getOrderEvents()
    {

        // ----------------------
        $request = $this->client->request('GET', "order/v1.0/events:polling");
        $response = $request->getBody();

        if ($request->getStatusCode() == 200) {
            $events = json_decode($response->getContents());

            foreach ($events as $event) {
                if (property_exists($event, 'orderId')) {
                    $order_details = Details::show($event->orderId);
                    $order_details = json_decode($order_details);

                    \App\Models\Order::updateOrCreate(
                        [
                            'ifood_id' => $order_details->id
                        ],
                        [
                            'order_type' => $order_details->orderType,
                            'payments' => $order_details->orderType,
                            'merchant' => $order_details->merchant,
                            'sales_channel' => $order_details->salesChannel,
                            'order_timing' => $order_details->orderTiming,
                            'total' => $order_details->total,
                            'preparation_start_date_time' => \Carbon\Carbon::create($order_details->preparationStartDateTime)->toDateTimeString(),
                            'display_id' => $order_details->displayId,
                            'items' => $order_details->items,
                            'customer' => $order_details->customer,
                            'extra_info' => null,
                            'delivery' => $order_details->delivery,
                            'schedule' => null,
                            'indoor' => null,
                            'takeout' => null,
                            'status' => $event->fullCode
                        ]
                    );
                }

                if (!IfoodOrderEvent::find($event->id)) {
                    IfoodOrderEvent::create([
                        'id' => $event->id,
                        'order_id' => $event->orderId,
                        'code' => $event->code,
                        'metadata' => property_exists($event, 'metadata') ? json_encode($event->metadata) : null,
                        'full_code' => $event->fullCode,
                        'created_at' => \Carbon\Carbon::create($event->createdAt)->toDateTimeString(),
                        'acknoledged_at' => null,
                    ]);
                };
            }

            if ($events) {
                $this->acknowledgeEvents($events);
            }
        }

        return  IfoodOrderEvent::orderBy('created_at', 'asc')->get();
    }

    public function acknowledgeEvents($events)
    {

        // ----------------------
        $request = $this->client->request('POST', "order/v1.0/events/acknowledgment", [
            'header' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $events,
        ]);

        return $request->getStatusCode() == 202;
    }

    public static function sendAcknowledgement($event)
    {
        return !!app(Events::class)->acknowledgeEvents($event);
    }

    public static function check()
    {
        return app(Events::class)->getOrderEvents();
    }

    public static function hasNewEvents()
    {
        return !!app(Events::class)->check()->getContent();
    }
}
