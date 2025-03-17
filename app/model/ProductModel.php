<?php

namespace App\Model;

use App\Table\ProductTable;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;

/**
 * Product model class for handling product data
 * 
 * @property int $id Product's unique identifier
 * @property string $name Product's name
 * @property float $price Product's price
 * @property string $description Product's description
 * @property array $pictures Product's pictures (comma-separated)
 * @property string $_created_at Creation timestamp
 * @property string $_updated_at Last update timestamp
 */
class ProductModel extends ProductTable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createModel(): JsonResponse
    {
        $success = $this->insert();
        return Response::success($this, 1, "Product created successfully");
    }

    public function readModel(): JsonResponse
    {
        $product = $this->selectById($this->id);
        if (!$product) {
            return Response::notFound("Product not found");
        }
        return Response::success($product, 1, "Product retrieved successfully");
    }

    public function updateModel(): JsonResponse
    {
        $product = $this->selectById($this->id);
        if (!$product) {
            return Response::notFound("Product not found");
        }
        $success = $this->update("id", $this->id);
        return Response::success($this, 1, "Product updated successfully");
    }

    public function deleteModel(): JsonResponse
    {
        $product = $this->selectById($this->id);
        if (!$product) {
            return Response::notFound("Product not found");
        }
        $this->delete($this->id);
        return Response::success(null, 1, "Product deleted successfully");
    }
} 