<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Helpers\ApiResponse;
use Exception;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $articles = Article::with(['category', 'images', 'author'])
                ->latest()
                ->paginate($perPage);

            $items = $articles->getCollection()->map(function ($article) {
                $article->images->transform(function ($image) {
                    $image->url = asset('storage/' . $image->image_path);
                    return $image;
                });
                return $article;
            });

            return ApiResponse::success([
                'items' => $articles->items(),
                'pagination' => [
                    'current_page' => $articles->currentPage(),
                    'last_page' => $articles->lastPage(),
                    'per_page' => $articles->perPage(),
                    'total' => $articles->total(),
                ]
            ], 'Daftar artikel berhasil diambil');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil artikel', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($slug)
    {
        try {
            $article = Article::with(['category', 'images', 'author'])
                ->where('slug', $slug)
                ->first();

            if (!$article) {
                return ApiResponse::error('Artikel tidak ditemukan', 404);
            }

            $article->increment('views');

            return ApiResponse::success($article, 'Detail artikel berhasil diambil');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail artikel', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }
}
