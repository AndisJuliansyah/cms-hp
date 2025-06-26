<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Helpers\ApiResponse;
use Exception;

class PartnerController extends Controller
{
    public function index()
    {
        try {
            $partners = Partner::where('is_active', 1)->get()->map(function ($partner) {
                return [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'url' => $partner->url,
                    'logo_url' => $partner->logo ? asset('storage/' . $partner->logo) : null,
                    'created_at' => $partner->created_at,
                    'updated_at' => $partner->updated_at,
                ];
            });

            return ApiResponse::success($partners, 'Partners retrieved successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve partners: ' . $e->getMessage(), 500);
        }
    }
}
