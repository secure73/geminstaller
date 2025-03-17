<?php

namespace App\Api;

use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;
use Gemvc\Core\Documentation;

class Index extends ApiService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(): JsonResponse
    {
        $this->validatePosts([]);
        return Response::success("gemvc is successfully installed");
    }

    public function document(): never
    {
        (new Documentation())->html();
    }

    /**
     * Generates mock responses for API documentation
     * 
     * @param string $method The API method name
     * @return array<mixed> Example response data for the specified method
     * @hidden
     */
    public static function mockResponse(string $method): array
    {
        return match($method) {
            'index' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 1,
                'service_message' => 'gemvc is successfully installed',
                'data' => null
            ],
            default => [
                'success' => false,
                'message' => 'Unknown method'
            ]
        };
    }
}
