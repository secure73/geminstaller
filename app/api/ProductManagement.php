<?php

namespace App\Api;

use App\Controller\ProductController;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;


class ProductManagement extends AuthService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->auth->authorize(['admin']);
    }

    public function create(): JsonResponse
    {
        $this->validatePosts([
            'name' => 'string',
            'price' => 'float',
            'description' => 'string',
            'pictures' => 'string'
        ]);
        return (new ProductController($this->request))->create();
    }

    public function read(): JsonResponse
    {
        $this->validatePosts(['id' => 'int']);
        return (new ProductController($this->request))->read();
    }

    public function update(): JsonResponse
    {
        //validate the post data is one of the most important part in GEMVC framework
        //this method firstof all sanitize  and then validate the data
        //also by using this method you have full auto complete Documentations !
        //this method is essntial to validate the data before sending it to the model layer and it is very easy to use
        //also it return proper failure messages and response codes to front end developer!
        $this->validatePosts([
            'id' => 'int',
            'name' => 'string',
            'price' => 'float',
            'description' => 'string',
            'pictures' => 'string'
        ]);
        return (new ProductController($this->request))->update();
    }

    public function delete(): JsonResponse
    {
        $this->validatePosts(['id' => 'int']);
        return (new ProductController($this->request))->delete();
    }

    public function list(): JsonResponse
    {
        // Define searchable fields and their types
        $this->request->findable([
            'name' => 'string',
            'price' => 'float',
            'description' => 'string'
        ]);

        // Define sortable fields
        $this->request->sortable([
            'id',
            'name',
            'price',
            'description',
        ]);
        
        return (new ProductController($this->request))->list();
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
            'create' => [
                'response_code' => 201,
                'message' => 'created',
                'count' => 1,
                'service_message' => 'Product created successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Sample Product',
                    'price' => 99.99,
                    'description' => 'Product description',
                    'pictures' => 'product1.jpg,product2.jpg'
                ]
            ],
            'read' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 1,
                'service_message' => 'Product retrieved successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Sample Product',
                    'price' => 99.99,
                    'description' => 'Product description',
                    'pictures' => 'product1.jpg,product2.jpg'
                ]
            ],
            'update' => [
                'response_code' => 209,
                'message' => 'updated',
                'count' => 1,
                'service_message' => 'Product updated successfully',
                'data' => [
                    'id' => 1,
                    'name' => 'Updated Product',
                    'price' => 149.99,
                    'description' => 'Updated description',
                    'pictures' => 'product1.jpg,product2.jpg,product3.jpg'
                ]
            ],
            'delete' => [
                'response_code' => 210,
                'message' => 'deleted',
                'count' => 1,
                'service_message' => 'Product deleted successfully',
                'data' => null
            ],
            'list' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 2,
                'service_message' => 'Products retrieved successfully',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Product 1',
                        'price' => 99.99,
                        'description' => 'Description 1',
                        'pictures' => 'product1.jpg'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Product 2',
                        'price' => 149.99,
                        'description' => 'Description 2',
                        'pictures' => 'product2.jpg'
                    ]
                ]
            ],
            default => [
                'success' => false,
                'message' => 'Unknown method'
            ]
        };
    }
} 