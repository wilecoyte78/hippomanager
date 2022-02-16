<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /*
     * Return json response with given data.
     *
     * @param mixed $data
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data = [], $statusCode = 200, $headers = [])
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }

        return response()->json($data, $statusCode, $headers, JSON_UNESCAPED_SLASHES);
    }

    /*
     * Return json response with given paginated data.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondPaginated($data)
    {
        return $this->respond([
            'data' => $data->collection,
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage()
            ],
        ]);
    }

    /*
     * Respond with success.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($data = [])
    {
        return $this->respond($data);
    }

    /*
     * Respond with created.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated($data = [])
    {
        return $this->respond($data, 201);
    }

    /*
     * Respond with no content.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNoContent()
    {
        return $this->respond([], 204);
    }

    /*
     * Respond with error.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message, $statusCode = 400)
    {
        return $this->respond($message, $statusCode);
    }

    /*
     * Respond with unauthorized.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }

    /*
     * Respond with forbidden.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, 403);
    }

    /*
     * Respond with forbidden.
     *
     * @param string $message
     * @return \Iluminate\Http\JsonResponse
     */
    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }
}
