<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected function jsonResponse(bool $success, $data = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => $success ? 'success' : 'error'
        ];

        if (isset($data)) {
            $key = is_string($data) ? 'message' : 'data';
            $response[$key] = $data;
        }

        return response()->json($response, $statusCode);
    }
}
