<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\EventScraper;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventSeeder extends Seeder
{
    protected $scraper;

    public function __construct(EventScraper $scraper)
    {
         $this->scraper = $scraper;
    }
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        // Log::info('Starting EventSeeder...');
        // $events = $this->scraper->scrape();

        // foreach ($events as $eventData) {
        //     Log::info('Inserting event: ' . $eventData['title']);
        //     Event::updateOrCreate(
        //         ['title' => $eventData['title'], 'start_date' => $eventData['start_date']],
        //         $eventData
        //     );
        // }
        // Log::info('EventSeeder completed.');
        Log::info('Starting EventSeeder...');
        $events = $this->scraper->scrape();

        foreach ($events as $eventData) {
            Log::info('Inserting event: ' . $eventData['title']);
            Event::updateOrCreate(
                ['title' => $eventData['title'], 'start_date' => $eventData['start_date']],
                $eventData
            );
        }
        Log::info('EventSeeder completed.');

        Event::factory()->count(5)->create();
    }
}
