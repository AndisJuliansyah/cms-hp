<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Helpers\ApiResponse;
use Exception;

class EventController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $events = Event::latest('event_date')->where('is_published', 1)->paginate($perPage);

            $items = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'description' => $event->description,
                    'location' => $event->location,
                    'event_date' => $event->event_date,
                    'poster_url' => $event->poster_path ? asset('storage/' . $event->poster_path) : null,
                    'seo_title' => $event->seo_title,
                    'seo_description' => $event->seo_description,
                ];
            });

            return ApiResponse::success([
                'items' => $items,
                'pagination' => [
                    'current_page' => $events->currentPage(),
                    'last_page' => $events->lastPage(),
                    'per_page' => $events->perPage(),
                    'total' => $events->total(),
                ]
            ], 'Daftar event berhasil diambil');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil event', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }
}
