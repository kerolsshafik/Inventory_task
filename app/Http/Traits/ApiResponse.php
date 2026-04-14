<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
trait ApiResponse
{



    /**
     */
    protected function successResponse(
        mixed $data = null,
        ?array $meta = null,
        int $statusCode = 200
    ): JsonResponse {
        $response = [
            'success' => true,
            'data' => $data,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a paginated response
     */
    protected function paginatedResponse(LengthAwarePaginator $paginator, int $statusCode = 200): JsonResponse
    {
        return $this->successResponse(
            $paginator->items(),
            $this->getPaginationMeta($paginator),
            $statusCode
        );
    }

    /**
     * Return an error response
     */
    protected function errorResponse(
        string $message,
        ?array $errors = null,
        int $statusCode = 400
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, statusCode: 404);
    }

    /**
     * Get pagination metadata
     */
    private function getPaginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'has_more' => $paginator->hasMorePages(),
            ],
        ];
    }
}
