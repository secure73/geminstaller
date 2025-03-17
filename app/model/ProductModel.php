<?php
/**
 * this is model layer. what so called Data logic layer
 * classes in this layer shall be extended from relevant classes in Table layer
 * classes in this layer  will be called from controller layer
 *      if this is complex data type which property not exits in Table layer which is this class parent, 
 *      you can define property with first charechter underline like _exampleProperty , it will be ignored in Table layer!
 *      if you want to use this property in controller layer, you can use it like this:but it will appear in response !
 */
namespace App\Model;

use App\Table\ProductTable;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;
use Gemvc\Traits\Model\ListTrait;

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