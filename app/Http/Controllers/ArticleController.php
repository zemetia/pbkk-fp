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
        return $this->success("Berhasil Menambahkan Artikel");
    }

    public function deleteArticle($username, $slug, Request $request, DeleteArticleService $service): JsonResponse
    {
        $input = new DeleteArticleRequest(
            $username,
            $slug
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account')->getUserId());
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Menghapus Artikel");
    }

    public function updateArticle($username, $slug, Request $request, UpdateArticleService $service): JsonResponse
    {
        $input = new UpdateArticleRequest(
            $username,
            $slug,
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
        return $this->success("Berhasil Update Artikel");
    }

    public function getArticle($username, $slug, GetArticleService $service): JsonResponse
    {
        $input = new GetArticleRequest(
            $username,
            $slug
        );

        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Mendapatkan User Page");
    }

    public function createTag(Request $request, CreateTagService $service): JsonResponse
    {
        // every time tag separated by , it will send request to create tag and assign it to this article
        // create Schedulling to delete tag(s) with 0 articles on it
        $input = new CreateTagRequest(
            $request->input("tag"),
            $request->input("article_id")
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account')->getUserId());
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Menambahkan Tag");
    }
}
