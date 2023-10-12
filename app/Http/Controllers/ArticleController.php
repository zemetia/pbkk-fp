<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\AddArticle\AddArticleRequest;
use App\Core\Application\Service\AddArticle\AddArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ArticleController extends Controller
{
    public function createArticle(Request $request, AddArticleService $service): JsonResponse
    {
        $request->validate([
            'visibility' => 'required|in:published,private,unlisted,draf',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image_url' => 'required|url',
            'tags' => 'required|array',
        ]);

        $input = new AddArticleRequest(
            $request->input('visibility'),
            $request->input('title'),
            $request->input('description'),
            $request->input('content'),
            $request->input('image_url'),
            $request->input('tags'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account')->getUserId());
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Registrasi");
    }
}
