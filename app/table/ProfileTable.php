<?php

namespace App\Table;

use App\Core\Interface\ITable;
use App\Core\Table;
use App\Core\TableTrait\TDelete;
use App\Core\TableTrait\TInsert;
use App\Core\TableTrait\TSelect;
use App\Core\TableTrait\TUpdate;

class ProfileTable extends Table implements ITable
{
    use TInsert;
                                                                                                                                                                                                                                                                       use TUpdate;
                                                                                                                                                                                                                                                                       use TDelete;
                                                                                                                                                                                                                                                                       use TSelect;


    public int $id;
    public string $name;
    public ?string $address;
    public ?string $tel;
    public function __construct()
    {
        $this->address = null;
        $this->tel = null;
        parent::__construct();
    }

    public function getTable(): string
    {
        return "profiles";
    }
}
