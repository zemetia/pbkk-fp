<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CoAuthorController extends Controller
{
    // We can add multiple Co-Authors
    // but delete just one each request
    public function add($username, $slug, Request $request, AddCoAuthorService $service): JsonResponse
    {
        $request->validate([
            'name' => 'unique:roles',
        ]);
        $input = new AddCoAuthorRequest(
            $username,
            $slug,
            $request->input('coauthor_ids')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("CoAuthor Berhasil Ditambahkan");
    }

    public function delete(Request $request, DeleteCoAuthorService $service): JsonResponse
    {
        $input = new DeleteCoAuthorRequest(
            $username,
            $slug,
            $request->input('coauthor_id')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("CoAuthor Berhasil Dihapus");
    }
}
