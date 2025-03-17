<?php
/**
 * this is table layer. what so called Data access layer
 * classes in this layer shall be extended from CRUDTable or Gemvc\Core\Table ;
 * for each column in database table, you must define property in this class with same name and property type;
 */
namespace App\Table;

use Gemvc\Core\CRUDTable;

/**
 * Product table class for handling product database operations
 * 
 * @property int $id Product's unique identifier  column id in database table
 * @property string $name Product's name column name in database table      
 * @property float $price Product's price column price in database table
 * @property string $description Product's description column description in database table
 * @property string $pictures Product's pictures (comma-separated) column pictures in database table
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

    /**
     * @return string
     * the name of the database table
     */
    public function getTable(): string
    {
        //return the name of the table  in database
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