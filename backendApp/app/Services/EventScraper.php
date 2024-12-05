<?php
namespace App\Services;

use Goutte\Client;
use App\Models\Event;
use App\Models\Location;
use App\Models\Category;
use App\Models\Reference;
use Illuminate\Support\Facades\Log;

class EventScraper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function scrape()
    {
        $events = [];

        // Define the URLs and corresponding parsing methods
        $urls = [
            'https://belgrade-beat.com/events/today' => 'parseBelgradeBeat',
            'https://www.tob.rs/en/events' => 'parseTob',
        ];

        foreach ($urls as $url => $method) {
            try {
                Log::info("Scraping URL: " . $url);
                $crawler = $this->client->request('GET', $url);
                $events = array_merge($events, $this->$method($crawler));
            } catch (\Exception $e) {
                Log::error("Error scraping URL: " . $url . " - " . $e->getMessage());
            }
        }

        return $events;
    }

    private function parseBelgradeBeat($crawler)
    {
        $events = [];
        Log::info("Parsing Belgrade Beat");

        $crawler->filter('.colx.w-50.w-100-l.mt15')->each(function ($node) use (&$events) {
            $title = $node->filter('h3.mt4.mt0-l.mb0.f4x.fw6.lh-title')->text();
            $link = 'https://belgrade-beat.com' . $node->filter('a')->attr('href');
            $imageUrl = 'https://belgrade-beat.com' . $node->filter('img.imgx')->attr('src');

            Log::info("Scraped event: " . $title);

            // Use dummy values for location, category, and reference
            $locaitonModel = Location::firstOrCreate(['name' => 'Unknown Location'], [
                'address' => 'Unknown address',
                'city' => 'Belgrade',
                'country' => 'Serbia',
                'postal_code' => '11000',
            ]);

            $categoryModel = Category::firstOrCreate(['name' => 'General']);
            $referenceModel = Reference::firstOrCreate(
                ['website' => 'https://belgrade-beat.com'],
                ['name' => 'Belgrade Beat']
            );

            $events[] = [
                'title' => $title,
                'description' => '',  // No description in initial event listing
                'start_date' => now()->toDateString(),  // Modify as needed
                'end_date' => now()->toDateString(),    // Modify as needed
                'location_id' => $locationModel->id,
                'category_id' => $categoryModel->id,
                'reference_id' => $referenceModel->id,
                'url' => $link,
                'image' => $imageUrl,
            ];
        });

        Log::info("Parsed " . count($events) . " events from Belgrade Beat");
        return $events;
    }

    private function parseTob($crawler)
    {
        $events = [];
        Log::info("Parsing Tob.rs");

        $crawler->filter('.main-content .event-item')->each(function ($node) use (&$events) {
            $title = $node->filter('.event-title')->text();
            $description = $node->filter('.event-description')->text();
            $startDate = $node->filter('.event-date')->text(); // Adjust the selector if needed
            $endDate = $startDate; // Adjust if the end date is different
            $locationName = $node->filter('.event-location')->text();
            $categoryName = 'General'; // Use a default category
            $referenceUrl = $node->filter('a')->attr('href');
            $refereceUrl = 'https://www.tob.rs' . $referenceUrl; // Complete the URL if relative
            $imageUrl = $node->filter('img')->attr('src');

            Log::info("Scraped event: " . $title);

            $location = Location::firstOrCreate(['name' => $locationName], [
                'address' => $locationName,
                'city' => 'Belgrade',
                'country' => 'Serbia',
                'postal_code' => '11000',
            ]);

            $category = Category::firstOrCreate(['name' => $categoryName]);

            $reference = Reference::firstOrCreate(
                ['website' => 'https://www.tob.rs'],
                ['name' => 'Tourist Organization of Belgrade']
            );

            $events[] = [
                'title' => $title,
                'description' => $description,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'location_id' => $location->id,
                'category_id' => $category->id,
                'reference_id' => $reference->id,
                'url' => $referenceUrl,
                'image' => $imageUrl,
            ];
        });

        Log::info("Parsed " . count($events) . " events from Tob.rs");
        return $events;
    }
}
?>