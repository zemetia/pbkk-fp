<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddCoAuthor\AddCoAuthorRequest;
use App\Core\Application\Service\AddCoAuthor\AddCoAuthorService;
use App\Core\Application\Service\DeleteCoAuthor\DeleteCoAuthorRequest;
use App\Core\Application\Service\DeleteCoAuthor\DeleteCoAuthorService;

class CoAuthorController extends Controller
{
    // We can add multiple Co-Authors
    // but delete just one each request
    public function add(Request $request, AddCoAuthorService $service): JsonResponse
    {
        $request->validate([
            'name' => 'unique:roles',
        ]);
        $input = new AddCoAuthorRequest(
            $request->input('artikel_id'),
            $request->input('coauthor_ids')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account')->getUserId());
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
            $request->input('artikel_id'),
            $request->input('coauthor_id')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account')->getUserId());
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("CoAuthor Berhasil Dihapus");
    }
}
