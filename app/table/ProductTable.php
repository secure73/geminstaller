<?php

namespace App\Table;

use Gemvc\Core\CRUDTable;

/**
 * Product table class for handling product database operations
 * 
 * @property int $id Product's unique identifier
 * @property string $name Product's name
 * @property float $price Product's price
 * @property string $description Product's description
 * @property string $pictures Product's pictures (comma-separated)
 */
class ProductTable extends CRUDTable
{
    public int $id;
    public string $name;
    public float $price;
    public string $description;
    public string $pictures;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTable(): string
    {
        return 'products';
    }

    /**
     * @return null|static
     * null or ProductTable Object
     */
    public function selectById(int $id): null|static
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        return $result[0] ?? null;
    }

    /**
     * @return null|static[]
     * null or array of ProductTable Objects
     */
    public function selectByName(string $name): null|array
    {
        return $this->select()->whereLike('name', $name)->run();
    }


} 