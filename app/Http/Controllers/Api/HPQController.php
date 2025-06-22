<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Hpq;
use App\Helpers\ApiResponse;
use Exception;

class HPQController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search');
            $coffeeType = $request->get('coffee_type');

            $query = Hpq::with('scores');

            if ($coffeeType) {
                $query->where('coffee_type', $coffeeType);
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code_hpq', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('full_name', 'like', "%$search%")
                        ->orWhere('brand_name', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%");
                });
            }

            $hpqs = $query->get();

            $sorted = $hpqs->sort(function ($a, $b) {
            $scoreA = $a->score_summary['total_score'] ?? 0;
            $scoreB = $b->score_summary['total_score'] ?? 0;

            if ($scoreA !== $scoreB) {
                return $scoreB <=> $scoreA;
            }

            if ($a->status !== $b->status) {
                return $a->status <=> $b->status;
            }

                return $b->updated_at <=> $a->updated_at;
            })->values();

            $paged = $sorted->slice(($page - 1) * $perPage, $perPage)->values();

            $paginator = new LengthAwarePaginator(
                $paged,
                $sorted->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            if ($paginator->isEmpty()) {
                return ApiResponse::success([
                    'items' => [],
                    'pagination' => [
                        'current_page' => $paginator->currentPage(),
                        'last_page' => $paginator->lastPage(),
                        'per_page' => $paginator->perPage(),
                        'total' => $paginator->total(),
                    ]
                ], 'Tidak ada data HPQ yang ditemukan sesuai filter atau pencarian');
            }

            if ($hpqs->isEmpty()) {
                return ApiResponse::success([
                    'items' => [],
                    'pagination' => [
                        'current_page' => $paginator->currentPage(),
                        'last_page' => $paginator->lastPage(),
                        'per_page' => $paginator->perPage(),
                        'total' => $paginator->total(),
                    ]
                ], 'Tidak ada data HPQ yang ditemukan sesuai filter atau pencarian');
            }

            $items = $hpqs->map(function ($hpq) {
                return [
                    'id' => $hpq->id,
                    'code_hpq' => $hpq->code_hpq,
                    'email' => $hpq->email,
                    'full_name' => $hpq->full_name,
                    'brand_name' => $hpq->brand_name,
                    'contact_number' => $hpq->contact_number,
                    'address' => $hpq->address,
                    'customer_type' => $hpq->customer_type,
                    'coffee_type' => $hpq->coffee_type,
                    'coffee_sample_name' => $hpq->coffee_sample_name,
                    'lot_number' => $hpq->lot_number,
                    'total_lot_quantity' => $hpq->total_lot_quantity,
                    'origin' => $hpq->origin,
                    'variety' => $hpq->variety,
                    'altitude' => $hpq->altitude,
                    'post_harvest_process' => $hpq->post_harvest_process,
                    'harvest_date' => $hpq->harvest_date?->format('Y-m-d'),
                    'green_bean_condition' => $hpq->green_bean_condition,
                    'sort_before_sending' => $hpq->sort_before_sending,
                    'specific_goal' => $hpq->specific_goal,
                    'notes' => $hpq->notes,
                    'status' => $hpq->status,
                    'score_summary' => $hpq->score_summary,
                    'updated_at' => $hpq->updated_at,
                ];
            });

            return ApiResponse::success([
                'items' => $items,
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ]
            ], 'Daftar HPQ berhasil diambil');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data HPQ', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($code_hpq)
    {
        try {
            $hpq = Hpq::with('scores')->where('code_hpq', $code_hpq)->first();

            if (!$hpq) {
                return ApiResponse::error('Data HPQ tidak ditemukan', 404);
            }

            $data = [
                'id' => $hpq->id,
                'code_hpq' => $hpq->code_hpq,
                'email' => $hpq->email,
                'full_name' => $hpq->full_name,
                'brand_name' => $hpq->brand_name,
                'contact_number' => $hpq->contact_number,
                'address' => $hpq->address,
                'customer_type' => $hpq->customer_type,
                'coffee_type' => $hpq->coffee_type,
                'coffee_sample_name' => $hpq->coffee_sample_name,
                'lot_number' => $hpq->lot_number,
                'total_lot_quantity' => $hpq->total_lot_quantity,
                'origin' => $hpq->origin,
                'variety' => $hpq->variety,
                'altitude' => $hpq->altitude,
                'post_harvest_process' => $hpq->post_harvest_process,
                'harvest_date' => $hpq->harvest_date?->format('Y-m-d'),
                'green_bean_condition' => $hpq->green_bean_condition,
                'sort_before_sending' => $hpq->sort_before_sending,
                'specific_goal' => $hpq->specific_goal,
                'notes' => $hpq->notes,
                'status' => $hpq->status,
                'updated_at' => $hpq->updated_at,
                'score_summary' => $hpq->score_summary,
                'scores' => $hpq->scores->map(function ($score) {
                    return [
                        'id' => $score->id,
                        'judge_name' => $score->judge_name,
                        'fragrance_aroma' => $score->fragrance_aroma,
                        'flavor' => $score->flavor,
                        'aftertaste' => $score->aftertaste,
                        'acidity' => $score->acidity,
                        'body' => $score->body,
                        'balance' => $score->balance,
                        'uniformity' => $score->uniformity,
                        'sweetness' => $score->sweetness,
                        'clean_cup' => $score->clean_cup,
                        'overall' => $score->overall,
                        'notes' => $score->notes
                    ];
                }),
            ];

            return ApiResponse::success($data, 'Detail HPQ berhasil diambil');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail HPQ', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'full_name' => 'required|string|max:255',
                'brand_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:50',
                'address' => 'required|string|max:500',
                'customer_type' => 'required|string|max:100',
                'coffee_type' => 'required|string|max:100',
                'coffee_sample_name' => 'required|string|max:255',
                'lot_number' => 'required|string|max:100',
                'total_lot_quantity' => 'required|integer|min:1',
                'origin' => 'required|string|max:255',
                'variety' => 'required|string|max:255',
                'altitude' => 'required|string|max:100',
                'post_harvest_process' => 'required|string|max:255',
                'harvest_date' => 'required|date',
                'green_bean_condition' => 'required|string|max:255',
                'sort_before_sending' => 'required|string|max:255',
                'specific_goal' => 'nullable|string|max:1000',
                'notes' => 'nullable|string|max:1000',
            ]);

            $lastCode = Hpq::where('code_hpq', 'like', '%-GB')
            ->orderByDesc('created_at')
            ->value('code_hpq');

            if ($lastCode) {
                $number = (int) substr($lastCode, 0, 7);
                $number++;
            } else {
                $number = 1;
            }

            $validated['code_hpq'] = str_pad($number, 7, '0', STR_PAD_LEFT) . '-GB';

            $hpq = Hpq::create($validated);

            return ApiResponse::success([
                'code_hpq' => $hpq->code_hpq,
                'data' => $hpq
            ], 'HPQ data submitted successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to submit HPQ data', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }
}
