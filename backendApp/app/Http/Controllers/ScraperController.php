<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller
{
    public function fetchEvents()
    {
        $allEvents = [];

        // Fetch events from the first website
        $response1 = Http::withHeaders([
            'X-Api-Key' => 'cdBp5C7hVS7gbjOonMGK5KRnvweJwu3ie2B5TQAt'
        ])->get('https://api.api-ninjas.com/v1/webscraper?url=https://allevents.in/belgrade/all');

        if ($response1->successful()) {
            $htmlContent1 = $response1->json()['data']; // assuming the API response has 'html_content' field
            $crawler1 = new Crawler($htmlContent1);

            // Assuming events are in a li with class 'event-card'
            $events1 = $crawler1->filter('.event-card')->each(function (Crawler $node) {
                $title = $node->filter('.title h3')->count() ? $node->filter('.title h3')->text() : 'No title';
                $date = $node->filter('.meta-bottom .date')->count() ? $node->filter('.meta-bottom .date')->text() : 'No date';
                $location = $node->filter('.subtitle')->count() ? $node->filter('.subtitle')->text() : 'No location';
                $link = $node->attr('data-link') ?? 'No link';

                return [
                    'title' => $title,
                    'date' => $date,
                    'location' => $location,
                    'link' => $link,
                ];
            });

            $allEvents = array_merge($allEvents, $events1);
        }

        // Fetch events from the second website
        $response2 = Http::get('https://belgrade-beat.rs/desavanja/danas');
        if ($response2->successful()) {
            $htmlContent2 = $response2->body();
            $crawler2 = new Crawler($htmlContent2);

            // Assuming events are in a div with class 'js-event'
            $events2 = $crawler2->filter('.js-event')->each(function (Crawler $node) {
                $title = $node->filter('a h2')->count() ? $node->filter('a h2')->text() : 'No title';
                $date = $node->filter('.tj div span.fw6')->count() ? $node->filter('.tj div span.fw6')->eq(1)->text() : 'No date';
                $location = $node->filter('.tj div a')->count() ? $node->filter('.tj div a')->eq(0)->text() : 'No location';
                $link = $node->filter('a')->attr('href') ?? 'No link';
                $link = 'https://belgrade-beat.rs' . $link;

                return [
                    'title' => $title,
                    'date' => $date,
                    'location' => $location,
                    'link' => $link,
                ];
            });

            $allEvents = array_merge($allEvents, $events2);
        }

        return response()->json($allEvents);
    }
}