<?php

namespace App\Jobs;

use App\Event;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $res = $client->request('GET', 'https://polisen.se/api/events');

        $events = json_decode($res->getBody()->getContents());

        foreach ($events as $event) {
            $datetime = new \DateTime($event->datetime);

            $newEvent = Event::firstOrNew(['id' => $event->id]);
            $newEvent->name = $event->name;
            $newEvent->summary = $event->summary;
            $newEvent->type = $event->type;
            $newEvent->url = $event->url;
            $newEvent->location_name = $event->location->name;
            $newEvent->location_gps = $event->location->gps;
            $newEvent->happen_at = \Carbon\Carbon::instance($datetime)->toDateTimeString();
            $newEvent->save();
        }
    }
}
