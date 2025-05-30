<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\ApiClient;
use App\Helpers\ApiResponse;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('api_token');

        if (!$token) {
            return ApiResponse::error('Unauthenticated', 401);
        }

        try {
            $payload = JWTAuth::setToken($token)->getPayload();
            $publicKey = $payload->get('sub');
        } catch (JWTException $e) {
            return ApiResponse::error('Invalid token', 401, [
                'error' => $e->getMessage()
            ]);
        }

        $client = ApiClient::where('public_key', $publicKey)
            ->where('is_active', true)
            ->first();

        if (!$client) {
            return ApiResponse::error('Unauthorized client', 401);
        }

        $origin = $request->header('Origin') ?? parse_url($request->headers->get('Referer'), PHP_URL_HOST);
        if ($origin && $client->allowed_domains) {
            $allowed = collect(explode(',', $client->allowed_domains))
                ->map(fn ($d) => trim($d))
                ->filter();

            if ($allowed->isNotEmpty() && !$allowed->contains(fn ($domain) => str_contains($origin, $domain))) {
                return ApiResponse::error('Unauthorized origin', 403);
            }
        }

        $request->merge(['api_client' => $client]);

        return $next($request);
    }

}
