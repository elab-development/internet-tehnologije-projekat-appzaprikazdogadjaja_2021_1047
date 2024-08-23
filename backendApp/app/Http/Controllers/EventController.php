<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Location;
use App\Models\Category;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(EventResource::collection($events));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location_id' => 'required|integer|exists:locations,id',
            'category_id' => 'required|integer|exists:categories,id',
            'reference_id' => 'required|integer|exists:references,id',
            'url' => 'required|string',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event = Event::create($validator->validated());
        return response()->json(new EventResource($event), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json(new EventResource($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location_id' => 'required|integer|exists:locations,id',
            'category_id' => 'required|integer|exists:categories,id',
            'reference_id' => 'required|integer|exists:references,id',
            'url' => 'required|string',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event = Event::findOrFail($id);
        $event->update($validator->validated());
        return response()->json(new EventResource($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = Event::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }

        if ($request->has('location_id')) {
            $query->where('location_id', $request->input('location_id'));
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $events = $query->with(['location', 'category'])->get();

        return EventResource::collection($events);
    }

    public function statistics()
    {
        try {
            // Fetch events by category
            $eventsByCategory = Event::select(DB::raw('count(*) as count, category_id'))
                ->groupBy('category_id')
                ->with('category')
                ->get()
                ->map(function ($item) {
                    return [
                        'category' => $item->category ? $item->category->name : 'Unknown',
                        'count' => $item->count,
                    ];
                });
    
            // Log the eventsByCategory for debugging
            \Log::info('Events By Category:', $eventsByCategory->toArray());
    
            // Fetch events by day of the week
            $eventsByDay = Event::select(DB::raw('count(*) as count, DAYOFWEEK(start_time) as day'))
                ->groupBy(DB::raw('DAYOFWEEK(start_time)'))
                ->get()
                ->map(function ($item) {
                    return [
                        'day' => $this->getDayName($item->day),
                        'count' => $item->count,
                    ];
                });
    
            // Log the eventsByDay for debugging
             Log::info('Events By Day:', $eventsByDay->toArray());
    
            return response()->json([
                'eventsByCategory' => $eventsByCategory,
                'eventsByDay' => $eventsByDay,
            ]);
        } catch (\Exception $e) {
             Log::error('Error fetching statistics:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while fetching statistics'], 500);
        }
    }
    private function getDayName($dayNumber)
    {
        $days = [
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday',
        ];
    
        return $days[$dayNumber] ?? 'Unknown';
    }
    
}
