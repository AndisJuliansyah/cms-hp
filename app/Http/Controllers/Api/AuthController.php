<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiClient;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    public function issueToken(Request $request)
    {
        try {
            $request->validate(['public_key' => 'required|uuid']);

            $client = ApiClient::where('public_key', $request->public_key)
                ->where('is_active', true)
                ->first();

            if (!$client) {
                return ApiResponse::error('Invalid public key', 401);
            }

            try {
                $token = JWTAuth::claims(['sub' => $client->public_key])->fromUser($client);
            } catch (JWTException $e) {
                return ApiResponse::error('Could not create token', 500, [
                    'exception' => $e->getMessage(),
                ]);
            }

            return ApiResponse::success(null, 'Token issued')
                    ->cookie('api_token', $token, 60 * 24 * 7, '/', null, true, true, false, 'Strict');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', 422, $e->errors());

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to issue token', 500, [
                'exception' => $e->getMessage()
            ]);
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $token = JWTAuth::getToken();

            // Jika token tidak ditemukan, coba ambil dari cookie
            if (!$token) {
                $tokenFromCookie = $request->cookie('api_token');
                if ($tokenFromCookie) {
                    $token = JWTAuth::setToken($tokenFromCookie);
                }
            }

            if (!$token) {
                return ApiResponse::error('Token not found', 401);
            }

            $newToken = JWTAuth::refresh($token);

            return ApiResponse::success(null, 'Token refreshed')
                ->cookie('api_token', $newToken, 60 * 24 * 7, '/', null, true, true, false, 'Strict');

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ApiResponse::error('Invalid token', 401);

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to refresh token', 500, [
                'exception' => $e->getMessage()
            ]);
        }
    }



    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

            return ApiResponse::success(null, 'Logged out')
                ->cookie('api_token', '', -1, '/', null, true, true, false, 'Strict');

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to logout', 500, [
                'exception' => $e->getMessage()
            ]);
        }
    }

}
