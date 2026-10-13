<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InactiveEntityException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message ?: 'هذا المنتج متوقف مؤقتاً ولا يمكن الوصول إليه.',
        ], 403);
    }
}