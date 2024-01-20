<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 指定されたHTTPステータスコードとデータ配列でJSONレスポンスを生成します。
     * 
     * @param int $statusCode
     * @param array $data
     * @return JsonResponse
     */
    public function jsonResponse(int $statusCode, array $data): JsonResponse
    {
        $responseArray = ['code' => $statusCode] + $data;
        return response()->json($responseArray, $statusCode);
    }
}
